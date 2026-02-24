<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Worksheet;
use App\Models\User;
use App\Models\ScallingData;
use App\Models\ScallingGovResponse;
use App\Models\LopOnHandImport;
use App\Models\LopOnHandData;
use App\Models\LopQualifiedImport;
use App\Models\LopQualifiedData;
use App\Models\LopKoreksiImport;
use App\Models\LopKoreksiData;
use App\Models\LopInitiateData;
use App\Models\FunnelTracking;
use App\Models\LopAdminNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        // Get all users grouped by role
        $users = User::all()->groupBy('role');
        
        return view('admin.index', compact('users'));
    }
    
    // Scalling Management Page
    public function scalling($role)
    {
        if ($role !== 'gov') {
            abort(404);
        }
        
        $scallingData = ScallingData::with('responses.user')->latest()->get();
        
        return view('admin.scalling', compact('role', 'scallingData'));
    }
    
    // Upload Scalling Data from Excel
    public function uploadScalling(Request $request, $role)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);
        
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        
        // Read Excel file
        $spreadsheet = IOFactory::load($file->getRealPath());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        // Store in database
        ScallingData::create([
            'uploaded_by' => Auth::user()->email,
            'file_name' => $fileName,
            'data' => $rows,
        ]);
        
        return redirect()->route('admin.scalling', $role)->with('success', 'File berhasil diupload!');
    }
    
    // PSAK Management Page
    public function psak($role)
    {
        if ($role !== 'gov') {
            abort(404);
        }
        
        return view('admin.psak', compact('role'));
    }
    
    // Step 2: Type Selection (Scalling/PSAK)
    public function selectRole($role)
    {
        if (!in_array($role, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        return view('admin.select-type', compact('role'));
    }
    
    // Step 3: LOP Category Selection (for Scalling only)
    public function selectType($role, $type)
    {
        if (!in_array($role, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        if (!in_array($type, ['scalling', 'psak'])) {
            abort(404);
        }
        
        // For PSAK, go directly to management page (no LOP categories)
        if ($type === 'psak') {
            return redirect()->route('admin.lop-manage', [$role, $type, 'none']);
        }
        
        return view('admin.select-lop', compact('role', 'type'));
    }
    
    // Step 4: LOP Management Page (Tambah/Lihat Data/Riwayat)
    public function manageLop($role, $type, $lopCategory)
    {
        if (!in_array($role, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        if (!in_array($type, ['scalling', 'psak'])) {
            abort(404);
        }
        
        if ($type === 'scalling' && !in_array($lopCategory, ['on_hand', 'qualified', 'initiate', 'koreksi'])) {
            abort(404);
        }
        
        // Government cannot access Initiate
        if ($role === 'government' && $lopCategory === 'initiate') {
            return redirect()->route('admin.select-type', $role)->with('error', 'Government tidak dapat mengakses LOP Initiate!');
        }
        
        return view('admin.lop-manage', compact('role', 'type', 'lopCategory'));
    }
    
    // View Data (Active worksheets)
    public function viewData($role, $type, $lopCategory)
    {
        $query = Worksheet::where('role', $role)
            ->where('type', $type)
            ->with(['projects' => function($q) {
                $q->orderBy('created_at', 'asc');
            }]);
        
        if ($type === 'scalling') {
            $query->where('lop_category', $lopCategory);
        }
        
        $worksheets = $query->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        
        return view('admin.view-data', compact('worksheets', 'role', 'type', 'lopCategory'));
    }
    
    // View History (All worksheets ever created)
    public function viewHistory($role, $type, $lopCategory)
    {
        $query = Worksheet::where('role', $role)
            ->where('type', $type)
            ->with(['projects' => function($q) {
                $q->orderBy('created_at', 'asc');
            }]);
        
        if ($type === 'scalling') {
            $query->where('lop_category', $lopCategory);
        }
        
        $worksheets = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.view-history', compact('worksheets', 'role', 'type', 'lopCategory'));
    }
    
    // Create new worksheet
    public function createWorksheet(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2024',
            'role' => 'required|in:government,private,soe',
            'type' => 'required|in:scalling,psak',
            'lop_category' => 'required_if:type,scalling|in:on_hand,qualified,initiate,koreksi',
        ]);
        
        $role = $request->role;
        $type = $request->type;
        $lopCategory = $request->lop_category ?? 'none';
        
        // Validate that government cannot use initiate
        if ($role === 'government' && $lopCategory === 'initiate') {
            return redirect()->route('admin.lop-manage', [$role, $type, $lopCategory])
                ->with('error', 'Government tidak dapat menggunakan LOP Initiate!');
        }
        
        // Check if worksheet already exists
        $existing = Worksheet::where('month', $request->month)
            ->where('year', $request->year)
            ->where('role', $role)
            ->where('type', $type)
            ->where('lop_category', $lopCategory)
            ->first();
            
        if ($existing) {
            return redirect()->route('admin.lop-manage', [$role, $type, $lopCategory])
                ->with('error', 'Worksheet untuk kombinasi ini sudah ada!');
        }
        
        // Create worksheet
        $worksheet = Worksheet::create([
            'month' => $request->month,
            'year' => $request->year,
            'role' => $role,
            'type' => $type,
            'lop_category' => $lopCategory === 'none' ? null : $lopCategory,
        ]);
        
        // Create 8 empty rows for the worksheet
        for ($i = 1; $i <= 8; $i++) {
            Project::create([
                'user_id' => auth()->id(),
                'worksheet_id' => $worksheet->id,
                'role' => $role,
                'project_name' => '',
                'is_user_added' => false,
            ]);
        }
        
        return redirect()->route('admin.lop-manage', [$role, $type, $lopCategory])
            ->with('success', 'Worksheet ' . $worksheet->full_name . ' berhasil dibuat dengan 8 rows!');
    }
    
    public function updateProject(Request $request, Project $project)
    {
        $validated = $request->validate([
            'project_name' => 'nullable|string|max:255',
            'id_lop' => 'nullable|string|max:255',
            'cc' => 'nullable|string|max:255',
            'nipnas' => 'nullable|string|max:255',
            'am' => 'nullable|string|max:255',
            'mitra' => 'nullable|string|max:255',
            'phn_bulan' => 'nullable|string|max:255',
            'est_nilai_bc' => 'nullable|string|max:255',
            // Boolean fields (checkboxes)
            'f0' => 'nullable|boolean',
            'f1' => 'nullable|boolean',
            'f2_p5_evaluasi_sph' => 'nullable|boolean',
            'negosiasi' => 'nullable|boolean',
            'f5_p8_surat_penetapan' => 'nullable|boolean',
            // Text fields
            'f2_p0_p1_jukbok' => 'nullable|string',
            'p2_evaluasi_bakal_calon' => 'nullable|string',
            'f2_p3_permintaan_penawaran' => 'nullable|string',
            'f2_p4_rapat_penjelasan' => 'nullable|string',
            'offering_harga_final' => 'nullable|string',
            'f3_p6_klarifikasi_negosiasi' => 'nullable|string',
            'f3_p7_penetapan_mitra' => 'nullable|string',
            'f3_submit_proposal' => 'nullable|string',
            'surat' => 'nullable|string',
            'tanda' => 'nullable|string',
            'kontrak_layanan' => 'nullable|string',
            'baut_bast' => 'nullable|string',
            'baso' => 'nullable|string',
            'invoice' => 'nullable|string',
            'ar' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);
        
        // Map f0/f1 to actual database column names
        $updateData = [];
        if (isset($validated['f0'])) {
            $updateData['f0_inisiasi_solusi'] = $validated['f0'];
            unset($validated['f0']);
        }
        if (isset($validated['f1'])) {
            $updateData['f1_technical_budget'] = $validated['f1'];
            unset($validated['f1']);
        }
        
        $project->update(array_merge($validated, $updateData));
        
        return redirect()->back()->with('success', 'Project berhasil diupdate!');
    }
    
    public function addProject(Request $request)
    {
        $request->validate([
            'worksheet_id' => 'required|exists:worksheets,id',
            'project_name' => 'required|string',
            'id_lop' => 'nullable|string',
            'cc' => 'nullable|string',
            'nipnas' => 'nullable|string',
            'am' => 'nullable|string',
            'mitra' => 'nullable|string',
            'phn_bulan' => 'nullable|string',
            'est_nilai_bc' => 'nullable|string',
        ]);
        
        $worksheet = Worksheet::findOrFail($request->worksheet_id);
        
        // Create new project row (admin-created, not user-added)
        Project::create([
            'user_id' => auth()->id(),
            'worksheet_id' => $worksheet->id,
            'role' => $worksheet->role,
            'is_user_added' => false,
            'project_name' => $request->project_name,
            'id_lop' => $request->id_lop,
            'cc' => $request->cc,
            'nipnas' => $request->nipnas,
            'am' => $request->am,
            'mitra' => $request->mitra,
            'phn_bulan_billcomp' => $request->phn_bulan,
            'est_nilai_bc' => $request->est_nilai_bc,
        ]);
        
        return redirect()->back()->with('success', 'Baris project berhasil ditambahkan!');
    }
    
    public function recap($role)
    {
        if (!in_array($role, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        $worksheets = Worksheet::where('role', $role)
            ->with(['projects' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        
        return view('admin.recap', compact('worksheets', 'role'));
    }

    // ==================== NEW LOP MANAGEMENT METHODS ====================
    
    // Halaman pilih entity (Government/Private/SOE)
    public function lopEntitySelect()
    {
        return view('admin.lop.select-entity');
    }
    
    // Halaman pilih tipe (Scalling/PSAK)
    public function lopTypeSelect($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        return view('admin.lop.select-type', compact('entity'));
    }
    
    // Halaman pilih kategori LOP (untuk Scalling)
    public function lopCategorySelect($entity, $type)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        if (!in_array($type, ['scalling', 'psak'])) {
            abort(404);
        }
        return view('admin.lop.select-category', compact('entity', 'type'));
    }
    
    // ==================== LOP ON HAND ====================
    
    public function lopOnHandManage($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopOnHandImport::with('data')
            ->where('entity_type', $entity)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        return view('admin.lop.on-hand', compact('entity', 'latestImport', 'currentMonth', 'currentYear'));
    }
    
    public function lopOnHandHistory($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        $imports = LopOnHandImport::where('entity_type', $entity)
            ->withCount('data')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->latest()
            ->get();
        
        return view('admin.lop.on-hand-history', compact('entity', 'imports'));
    }
    
    // ==================== LOP QUALIFIED ====================
    
    public function lopQualifiedManage($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopQualifiedImport::with('data')
            ->where('entity_type', $entity)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        return view('admin.lop.qualified', compact('entity', 'latestImport', 'currentMonth', 'currentYear'));
    }
    
    public function lopQualifiedHistory($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        $imports = LopQualifiedImport::where('entity_type', $entity)
            ->withCount('data')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->latest()
            ->get();
        
        return view('admin.lop.qualified-history', compact('entity', 'imports'));
    }
    
    // ==================== LOP KOREKSI ====================
    
    public function lopKoreksiManage($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopKoreksiImport::with('data')
            ->where('entity_type', $entity)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        return view('admin.lop.koreksi', compact('entity', 'latestImport', 'currentMonth', 'currentYear'));
    }
    
    public function lopKoreksiHistory($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        $imports = LopKoreksiImport::where('entity_type', $entity)
            ->withCount('data')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->latest()
            ->get();
        
        return view('admin.lop.koreksi-history', compact('entity', 'imports'));
    }
    
    // ==================== LOP INITIATE ====================
    
    public function lopInitiateManage($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $data = LopInitiateData::where('entity_type', $entity)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->get();
        
        return view('admin.lop.initiate', compact('entity', 'data', 'currentMonth', 'currentYear'));
    }
    
    public function lopInitiateHistory($entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        $data = LopInitiateData::where('entity_type', $entity)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->latest()
            ->get();
        
        return view('admin.lop.initiate-history', compact('entity', 'data'));
    }
    
    public function lopInitiateStore(Request $request, $entity)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2024',
            'no' => 'nullable|string',
            'project' => 'required|string',
            'id_lop' => 'nullable|string',
            'cc' => 'nullable|string',
            'nipnas' => 'nullable|string',
            'am' => 'nullable|string',
            'mitra' => 'nullable|string',
            'plan_bulan_billcom_p_2025' => 'nullable|string',
            'est_nilai_bc' => 'nullable|string',
        ]);
        
        LopInitiateData::create([
            'entity_type' => $entity,
            'created_by' => Auth::user()->email,
            'month' => $request->month,
            'year' => $request->year,
            'no' => $request->no,
            'project' => $request->project,
            'id_lop' => $request->id_lop,
            'cc' => $request->cc,
            'nipnas' => $request->nipnas,
            'am' => $request->am,
            'mitra' => $request->mitra,
            'plan_bulan_billcom_p_2025' => $request->plan_bulan_billcom_p_2025,
            'est_nilai_bc' => $request->est_nilai_bc,
        ]);
        
        return redirect()->route('admin.lop.initiate', ['entity' => $entity, 'month' => $request->month, 'year' => $request->year])
            ->with('success', 'Data berhasil ditambahkan!');
    }
    
    public function lopInitiateDelete($entity, $id)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        
        $data = LopInitiateData::where('entity_type', $entity)->findOrFail($id);
        $data->delete();
        
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
    
    // ==================== IMPORT EXCEL (Untuk On Hand, Qualified, Koreksi) ====================
    
    public function uploadLopData(Request $request, $entity, $category)
    {
        if (!in_array($entity, ['government', 'private', 'soe'])) {
            abort(404);
        }
        if (!in_array($category, ['on_hand', 'qualified', 'koreksi'])) {
            abort(404);
        }
        
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2024',
        ]);
        
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $month = $request->month;
        $year = $request->year;
        
        // Read Excel file
        $spreadsheet = IOFactory::load($file->getRealPath());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        // Get headers from first row (normalize to lowercase and remove spaces)
        $headers = array_map(function($header) {
            return strtolower(trim($header));
        }, $rows[0]);
        
        // Map common header variations to standard field names
        $headerMap = [
            'no' => 'no',
            'project' => 'project',
            'id lop' => 'id_lop',
            'id_lop' => 'id_lop',
            'cc' => 'cc',
            'nipnas' => 'nipnas',
            'am' => 'am',
            'mitra' => 'mitra',
            'plan bulan billcom p 2025' => 'plan_bulan_billcom_p_2025',
            'plan_bulan_billcom_p_2025' => 'plan_bulan_billcom_p_2025',
            'est nilai bc' => 'est_nilai_bc',
            'est_nilai_bc' => 'est_nilai_bc',
        ];
        
        // Create column index mapping
        $columnMap = [];
        foreach ($headers as $index => $header) {
            if (isset($headerMap[$header])) {
                $columnMap[$headerMap[$header]] = $index;
            }
        }
        
        // Import ke ketiga tabel sekaligus
        $totalRows = count($rows) - 1; // Exclude header
        
        // 1. LOP On Hand
        $onHandImport = LopOnHandImport::create([
            'uploaded_by' => Auth::user()->email,
            'file_name' => $fileName,
            'total_rows' => $totalRows,
            'entity_type' => $entity,
            'month' => $month,
            'year' => $year,
        ]);
        
        foreach (array_slice($rows, 1) as $row) {
            // Skip empty rows
            if (empty($row[$columnMap['project'] ?? 1])) {
                continue;
            }
            
            $onHandData = LopOnHandData::create([
                'import_id' => $onHandImport->id,
                'no' => $row[$columnMap['no'] ?? 0] ?? '',
                'project' => $row[$columnMap['project'] ?? 1] ?? '',
                'id_lop' => $row[$columnMap['id_lop'] ?? 2] ?? '',
                'cc' => $row[$columnMap['cc'] ?? 3] ?? '',
                'nipnas' => $row[$columnMap['nipnas'] ?? 4] ?? '',
                'am' => $row[$columnMap['am'] ?? 5] ?? '',
                'mitra' => $row[$columnMap['mitra'] ?? 6] ?? '',
                'plan_bulan_billcom_p_2025' => $row[$columnMap['plan_bulan_billcom_p_2025'] ?? 7] ?? '',
                'est_nilai_bc' => $row[$columnMap['est_nilai_bc'] ?? 8] ?? '',
            ]);
            
            // Create empty funnel tracking for this data
            FunnelTracking::create([
                'data_type' => 'on_hand',
                'data_id' => $onHandData->id,
            ]);
        }
        
        // 2. LOP Qualified
        $qualifiedImport = LopQualifiedImport::create([
            'uploaded_by' => Auth::user()->email,
            'file_name' => $fileName,
            'total_rows' => $totalRows,
            'entity_type' => $entity,
            'month' => $month,
            'year' => $year,
        ]);
        
        foreach (array_slice($rows, 1) as $row) {
            if (empty($row[$columnMap['project'] ?? 1])) {
                continue;
            }
            
            $qualifiedData = LopQualifiedData::create([
                'import_id' => $qualifiedImport->id,
                'no' => $row[$columnMap['no'] ?? 0] ?? '',
                'project' => $row[$columnMap['project'] ?? 1] ?? '',
                'id_lop' => $row[$columnMap['id_lop'] ?? 2] ?? '',
                'cc' => $row[$columnMap['cc'] ?? 3] ?? '',
                'nipnas' => $row[$columnMap['nipnas'] ?? 4] ?? '',
                'am' => $row[$columnMap['am'] ?? 5] ?? '',
                'mitra' => $row[$columnMap['mitra'] ?? 6] ?? '',
                'plan_bulan_billcom_p_2025' => $row[$columnMap['plan_bulan_billcom_p_2025'] ?? 7] ?? '',
                'est_nilai_bc' => $row[$columnMap['est_nilai_bc'] ?? 8] ?? '',
            ]);
            
            // Create empty funnel tracking for this data
            FunnelTracking::create([
                'data_type' => 'qualified',
                'data_id' => $qualifiedData->id,
            ]);
        }
        
        // 3. LOP Koreksi
        $koreksiImport = LopKoreksiImport::create([
            'uploaded_by' => Auth::user()->email,
            'file_name' => $fileName,
            'total_rows' => $totalRows,
            'entity_type' => $entity,
            'month' => $month,
            'year' => $year,
        ]);
        
        foreach (array_slice($rows, 1) as $row) {
            if (empty($row[$columnMap['project'] ?? 1])) {
                continue;
            }
            
            $koreksiData = LopKoreksiData::create([
                'import_id' => $koreksiImport->id,
                'no' => $row[$columnMap['no'] ?? 0] ?? '',
                'project' => $row[$columnMap['project'] ?? 1] ?? '',
                'id_lop' => $row[$columnMap['id_lop'] ?? 2] ?? '',
                'cc' => $row[$columnMap['cc'] ?? 3] ?? '',
                'nipnas' => $row[$columnMap['nipnas'] ?? 4] ?? '',
                'am' => $row[$columnMap['am'] ?? 5] ?? '',
                'mitra' => $row[$columnMap['mitra'] ?? 6] ?? '',
                'plan_bulan_billcom_p_2025' => $row[$columnMap['plan_bulan_billcom_p_2025'] ?? 7] ?? '',
                'est_nilai_bc' => $row[$columnMap['est_nilai_bc'] ?? 8] ?? '',
            ]);
            
            // Create empty funnel tracking for this data
            FunnelTracking::create([
                'data_type' => 'koreksi',
                'data_id' => $koreksiData->id,
            ]);
        }
        
        // Delete uploaded file
        if (file_exists($file->getRealPath())) {
            unlink($file->getRealPath());
        }
        
        return redirect()->route('admin.lop.' . $category, ['entity' => $entity, 'month' => $month, 'year' => $year])
            ->with('success', 'Data berhasil diimport ke 3 tabel (On Hand, Qualified, Koreksi) dan file berhasil dihapus!');
    }
    
    // ==================== FUNNEL TRACKING ====================
    
    public function showFunnelForm($dataType, $dataId)
    {
        if (!in_array($dataType, ['on_hand', 'qualified', 'koreksi', 'initiate'])) {
            abort(404);
        }
        
        // Get the data based on type
        $data = null;
        $mitraValue = '';
        
        switch($dataType) {
            case 'on_hand':
                $data = LopOnHandData::findOrFail($dataId);
                $mitraValue = $data->mitra;
                break;
            case 'qualified':
                $data = LopQualifiedData::findOrFail($dataId);
                $mitraValue = $data->mitra;
                break;
            case 'koreksi':
                $data = LopKoreksiData::findOrFail($dataId);
                $mitraValue = $data->mitra;
                break;
            case 'initiate':
                $data = LopInitiateData::findOrFail($dataId);
                $mitraValue = $data->mitra;
                break;
        }
        
        // Get existing funnel tracking atau create baru
        $funnel = FunnelTracking::where('data_type', $dataType)
            ->where('data_id', $dataId)
            ->first();
        
        if (!$funnel) {
            $funnel = FunnelTracking::create([
                'data_type' => $dataType,
                'data_id' => $dataId,
            ]);
        }
        
        // Determine dengan/tanpa mitra
        $denganMitra = stripos($mitraValue, 'dengan') !== false || stripos($mitraValue, 'with') !== false;
        
        return view('admin.lop.funnel-form', compact('data', 'funnel', 'dataType', 'dataId', 'denganMitra'));
    }
    
    public function updateFunnel(Request $request, $dataType, $dataId)
    {
        if (!in_array($dataType, ['on_hand', 'qualified', 'koreksi', 'initiate'])) {
            abort(404);
        }
        
        $funnel = FunnelTracking::where('data_type', $dataType)
            ->where('data_id', $dataId)
            ->firstOrFail();
        
        // Update all funnel fields
        $funnel->update([
            'f0_lead' => $request->has('f0_lead'),
            'f0_inisiasi_solusi' => $request->has('f0_inisiasi_solusi'),
            'f0_technical_proposal' => $request->has('f0_technical_proposal'),
            'f1_p0_p1_juskeb' => $request->has('f1_p0_p1_juskeb'),
            'f2_p2_evaluasi' => $request->has('f2_p2_evaluasi'),
            'f2_p3_permintaan_harga' => $request->has('f2_p3_permintaan_harga'),
            'f2_p4_rapat_penjelasan' => $request->has('f2_p4_rapat_penjelasan'),
            'f2_offering_harga' => $request->has('f2_offering_harga'),
            'f2_p5_evaluasi_sph' => $request->has('f2_p5_evaluasi_sph'),
            'f3_propos_al' => $request->has('f3_propos_al'),
            'f3_p6_klarifikasi' => $request->has('f3_p6_klarifikasi'),
            'f3_p7_penetapan' => $request->has('f3_p7_penetapan'),
            'f3_submit_proposal' => $request->has('f3_submit_proposal'),
            'f4_negosiasi' => $request->has('f4_negosiasi'),
            'f4_surat_kesanggupan' => $request->has('f4_surat_kesanggupan'),
            'f4_p8_surat_pemenang' => $request->has('f4_p8_surat_pemenang'),
            'f5_kontrak_layanan' => $request->has('f5_kontrak_layanan'),
            'delivery_billing_complete' => $request->has('delivery_billing_complete'),
            'delivery_nilai_billcomp' => $request->delivery_nilai_billcomp,
            'delivery_baso' => $request->delivery_baso,
        ]);
        
        return redirect()->back()->with('success', 'Funnel tracking berhasil diupdate!');
    }
    
    // ==================== ADMIN NOTES ====================
    
    public function saveAdminNote(Request $request)
    {
        $request->validate([
            'entity_type' => 'required|in:government,private,soe',
            'category' => 'required|in:on_hand,qualified,koreksi,initiate',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2024',
            'note' => 'required|string',
        ]);
        
        // Update or create note
        LopAdminNote::updateOrCreate(
            [
                'entity_type' => $request->entity_type,
                'category' => $request->category,
                'month' => $request->month,
                'year' => $request->year,
            ],
            [
                'note' => $request->note,
                'created_by' => Auth::user()->email,
            ]
        );
        
        return redirect()->back()->with('success', 'Catatan berhasil disimpan!');
    }
    
    public function getAdminNote($entity, $category, $month, $year)
    {
        $note = LopAdminNote::where('entity_type', $entity)
            ->where('category', $category)
            ->where('month', $month)
            ->where('year', $year)
            ->first();
        
        return response()->json(['note' => $note ? $note->note : '']);
    }
    
    /**
     * Show LOP Progress Tracking - Admin View
     */
    public function lopProgressTracking()
    {
        // Get all LOP data with funnel tracking and user info
        $onHandData = LopOnHandData::with(['funnel.updatedByUser'])
            ->whereHas('funnel', function($query) {
                $query->whereNotNull('updated_by');
            })
            ->get();
        
        $qualifiedData = LopQualifiedData::with(['funnel.updatedByUser'])
            ->whereHas('funnel', function($query) {
                $query->whereNotNull('updated_by');
            })
            ->get();
        
        $koreksiData = LopKoreksiData::with(['funnel.updatedByUser'])
            ->whereHas('funnel', function($query) {
                $query->whereNotNull('updated_by');
            })
            ->get();
        
        $initiateData = LopInitiateData::with(['funnel.updatedByUser'])
            ->whereHas('funnel', function($query) {
                $query->whereNotNull('updated_by');
            })
            ->get();
        
        return view('admin.lop-progress-tracking', compact(
            'onHandData',
            'qualifiedData',
            'koreksiData',
            'initiateData'
        ));
    }
}
