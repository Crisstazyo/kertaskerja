<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Worksheet;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Step 1: Role Selection
    public function index()
    {
        return view('admin.index');
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
}
