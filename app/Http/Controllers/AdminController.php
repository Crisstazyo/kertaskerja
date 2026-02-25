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
use App\Models\TaskProgress;
use App\Models\LopAdminNote;
use App\Models\PsakGovernment;
use App\Models\PsakPrivate;
use App\Models\PsakSoe;
use App\Models\PsakSme;
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
    
    // NEW SIMPLIFIED FLOW
    // Role Menu - Choose Upload or Progress
    public function roleMenu($role)
    {
        if (!in_array($role, ['government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        return view('admin.role-menu', compact('role'));
    }
    
    // Category-specific Upload Page
    public function uploadCategoryPage($role, $category)
    {
        if (!in_array($role, ['government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        if (!in_array($category, ['on_hand', 'qualified', 'koreksi', 'initiate'])) {
            abort(404);
        }
        
        // Government doesn't have initiate
        if ($role === 'government' && $category === 'initiate') {
            abort(404);
        }
        
        // Get upload history for this specific category
        // Map role and category to model name
        $importModelMap = [
            'government' => [
                'on_hand' => 'App\Models\LopOnHandImport',
                'qualified' => 'App\Models\LopQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
            ],
            'private' => [
                'on_hand' => 'App\Models\LopPrivateOnHandImport',
                'qualified' => 'App\Models\LopPrivateQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
                'initiate' => 'App\Models\LopInitiateData', // Check this
            ],
            'soe' => [
                'on_hand' => 'App\Models\LopSoeOnHandImport',
                'qualified' => 'App\Models\LopSoeQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
                'initiate' => 'App\Models\LopInitiateData', // Check this
            ],
            'sme' => [
                'on_hand' => 'App\Models\LopSmeOnHandImport',
                'qualified' => 'App\Models\LopSmeQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
                'initiate' => 'App\Models\LopInitiateData', // Check this
            ],
        ];
        
        $uploadHistory = collect();
        
        if (isset($importModelMap[$role][$category])) {
            $modelClass = $importModelMap[$role][$category];
            
            if (class_exists($modelClass)) {
                $query = $modelClass::query();
                
                // Apply filters
                if (request('filter_month')) {
                    $query->where('month', request('filter_month'));
                }
                if (request('filter_year')) {
                    $query->where('year', request('filter_year'));
                }
                
                $uploadHistory = $query->latest()->get();
            }
        }
        
        return view('admin.upload-category', compact('role', 'category', 'uploadHistory'));
    }
    
    // Category-specific Progress Page
    public function progressCategoryPage($role, $category)
    {
        if (!in_array($role, ['government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        if (!in_array($category, ['on_hand', 'qualified', 'koreksi', 'initiate'])) {
            abort(404);
        }
        
        // Government doesn't have initiate
        if ($role === 'government' && $category === 'initiate') {
            abort(404);
        }
        
        // Get view mode
        $view = request()->get('view', 'current');
        
        // Map role and category to model
        $importModelMap = [
            'government' => [
                'on_hand' => 'App\Models\LopOnHandImport',
                'qualified' => 'App\Models\LopQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
            ],
            'private' => [
                'on_hand' => 'App\Models\LopPrivateOnHandImport',
                'qualified' => 'App\Models\LopPrivateQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
                'initiate' => 'App\Models\LopInitiateData',
            ],
            'soe' => [
                'on_hand' => 'App\Models\LopSoeOnHandImport',
                'qualified' => 'App\Models\LopSoeQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
                'initiate' => 'App\Models\LopInitiateData',
            ],
            'sme' => [
                'on_hand' => 'App\Models\LopSmeOnHandImport',
                'qualified' => 'App\Models\LopSmeQualifiedImport',
                'koreksi' => 'App\Models\LopKoreksiImport',
                'initiate' => 'App\Models\LopInitiateData',
            ],
        ];
        
        $allUploads = collect();
        $visibleData = collect();
        
        if (isset($importModelMap[$role][$category])) {
            $modelClass = $importModelMap[$role][$category];
            
            if (class_exists($modelClass)) {
                // Get all uploads for history view
                $allUploads = $modelClass::with(['data.funnel.progress' => function($query) {
                        $query->whereDate('tanggal', today())->with('user');
                    }])
                    ->latest()
                    ->get()
                    ->unique(function($item) {
                        return $item->month . '-' . $item->year;
                    })
                    ->sortByDesc(function($item) {
                        return $item->year * 100 + $item->month;
                    });
                
                // For current progress view
                if ($view !== 'history') {
                    $currentMonth = 2; // February 2026
                    $currentYear = 2026;
                    
                    // Get visible upload IDs from session
                    $visibleUploadIds = session('visible_uploads_' . $role . '_' . $category, []);
                    
                    // Get selected user filter (default: show aggregate)
                    $selectedUserId = request()->get('user_id', null);
                    
                    // Always include current month data with task_progress
                    $currentMonthUpload = $modelClass::with(['data.funnel.progress' => function($query) use ($selectedUserId) {
                            $query->whereDate('tanggal', today())->with('user');
                            if ($selectedUserId) {
                                $query->where('user_id', $selectedUserId);
                            }
                        }])
                        ->where('month', $currentMonth)
                        ->where('year', $currentYear)
                        ->latest()
                        ->first();
                    
                    if ($currentMonthUpload) {
                        $visibleData = $visibleData->merge($currentMonthUpload->data);
                    }
                    
                    // Include data from visible uploads
                    if (!empty($visibleUploadIds)) {
                        $visibleUploads = $modelClass::with(['data.funnel.progress' => function($query) use ($selectedUserId) {
                                $query->whereDate('tanggal', today())->with('user');
                                if ($selectedUserId) {
                                    $query->where('user_id', $selectedUserId);
                                }
                            }])
                            ->whereIn('id', $visibleUploadIds)
                            ->where(function($query) use ($currentMonth, $currentYear) {
                                $query->where('month', '!=', $currentMonth)
                                      ->orWhere('year', '!=', $currentYear);
                            })
                            ->get();
                        
                        foreach ($visibleUploads as $upload) {
                            $visibleData = $visibleData->merge($upload->data);
                        }
                    }
                }
            }
        }
        
        // Get all users for the filter dropdown
        $users = User::whereIn('role', ['government', 'private', 'soe', 'sme', 'admin'])
            ->orderBy('name')
            ->get();
        
        $selectedUserId = request()->get('user_id', null);
        
        // Get month filter (default: current month)
        $selectedMonth = request()->get('month', now()->format('Y-m'));
        list($filterYear, $filterMonth) = explode('-', $selectedMonth);
        $filterYear = (int) $filterYear;
        $filterMonth = (int) $filterMonth;
        
        // Get list of available months for history dropdown
        $availableMonths = [];
        if ($modelClass && class_exists($modelClass)) {
            $availableMonths = $modelClass::selectRaw('DISTINCT year, month')
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->get()
                ->map(function($item) {
                    return [
                        'value' => sprintf('%04d-%02d', $item->year, $item->month),
                        'label' => date('F Y', mktime(0, 0, 0, $item->month, 1, $item->year))
                    ];
                })
                ->toArray();
        }
        
        // Get latestImport for selected month (for full table view)
        $latestImport = null;
        if ($modelClass && class_exists($modelClass)) {
            $latestImport = $modelClass::with(['data.funnel' => function($query) use ($selectedUserId) {
                    $query->with(['progress' => function($q) use ($selectedUserId) {
                        $q->whereDate('tanggal', today())->with('user');
                        if ($selectedUserId) {
                            $q->where('user_id', $selectedUserId);
                        }
                    }, 'todayProgress' => function($q) use ($selectedUserId) {
                        $q->whereDate('tanggal', today());
                        if ($selectedUserId) {
                            $q->where('user_id', $selectedUserId);
                        }
                    }]);
                }])
                ->where('year', $filterYear)
                ->where('month', $filterMonth)
                ->latest()
                ->first();
        }
        
        return view('admin.progress-category', compact(
            'role', 
            'category', 
            'allUploads', 
            'visibleData', 
            'users', 
            'selectedUserId',
            'availableMonths',
            'selectedMonth',
            'latestImport'
        ));
    }
    
    // Toggle visibility of upload in progress view
    public function toggleUploadVisibility($role, $category)
    {
        $uploadId = request('upload_id');
        $sessionKey = 'visible_uploads_' . $role . '_' . $category;
        
        $visibleUploads = session($sessionKey, []);
        
        if (in_array($uploadId, $visibleUploads)) {
            // Remove from visible
            $visibleUploads = array_diff($visibleUploads, [$uploadId]);
        } else {
            // Add to visible
            $visibleUploads[] = $uploadId;
        }
        
        session([$sessionKey => array_values($visibleUploads)]);
        
        return redirect()->back()->with('success', 'Visibility updated successfully');
    }
    
    // Upload Page - Shows upload forms and history (DEPRECATED)
    public function uploadPage($role)
    {
        if (!in_array($role, ['government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        // You can add history data here later
        return view('admin.upload', compact('role'));
    }
    
    // Progress Page - Shows progress monitoring with filters
    public function progressPage($role)
    {
        if (!in_array($role, ['government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        // Get all users for this role
        $users = User::where('role', $role)->get();
        
        // Get filter parameters
        $category = request()->get('category', 'on_hand');
        $month = request()->get('month', date('n'));
        $year = request()->get('year', date('Y'));
        $userId = request()->get('user_id');
        
        // Normalize role for database queries
        $roleNormalized = ($role === 'government') ? 'government' : $role;
        
        // Get latest import based on category
        $importModelMap = [
            'on_hand' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'OnHandImport',
            'qualified' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'QualifiedImport',
            'koreksi' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'CorrectionImport',
            'initiate' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'InitiatedImport',
        ];
        
        $latestImport = null;
        if (isset($importModelMap[$category]) && class_exists($importModelMap[$category])) {
            $query = $importModelMap[$category]::with(['data.funnel'])
                ->where('entity_type', $roleNormalized)
                ->where('month', $month)
                ->where('year', $year);
            
            $latestImport = $query->latest()->first();
        }
        
        return view('admin.progress', compact('role', 'users', 'category', 'month', 'year', 'latestImport'));
    }
    
    // Progress Detail - Shows full table like user view (read-only)
    public function progressDetail($role, $category, $month, $year)
    {
        if (!in_array($role, ['government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        if (!in_array($category, ['on_hand', 'qualified', 'koreksi', 'initiate'])) {
            abort(404);
        }
        
        // Normalize role
        $roleNormalized = ($role === 'government') ? 'government' : $role;
        
        // Get data similar to user controller
        $importModelMap = [
            'on_hand' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'OnHandImport',
            'qualified' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'QualifiedImport',
            'koreksi' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'CorrectionImport',
            'initiate' => 'App\Models\Lop' . ucfirst($roleNormalized) . 'InitiatedImport',
        ];
        
        $latestImport = null;
        if (isset($importModelMap[$category]) && class_exists($importModelMap[$category])) {
            $latestImport = $importModelMap[$category]::with(['data.funnel'])
                ->where('entity_type', $roleNormalized)
                ->where('month', $month)
                ->where('year', $year)
                ->latest()
                ->first();
        }
        
        // Get admin note
        $adminNote = LopAdminNote::where('entity_type', $roleNormalized)
            ->where('category', $category)
            ->where('month', $month)
            ->where('year', $year)
            ->first();
        
        // Use the same view as users but with read-only mode
        $viewMap = [
            'on_hand' => 'admin.lop-on-hand-detail',
            'qualified' => 'admin.lop-qualified-detail',
            'koreksi' => 'admin.lop-koreksi-detail',
            'initiate' => 'admin.lop-initiate-detail',
        ];
        
        $view = $viewMap[$category] ?? 'admin.lop-on-hand-detail';
        
        return view($view, compact('role', 'latestImport', 'adminNote', 'category', 'month', 'year'));
    }
    
    // Scalling Management Page
    public function scalling($role)
    {
        if (!in_array($role, ['gov', 'government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        // Normalize role name
        $roleNormalized = ($role === 'gov') ? 'government' : $role;
        
        // Get upload history with filters
        $uploadHistory = ScallingData::query()
            ->when(request('role_filter'), function($q, $roleFilter) {
                return $q->where('role', $roleFilter);
            })
            ->when(request('date_from'), function($q, $dateFrom) {
                return $q->whereDate('created_at', '>=', $dateFrom);
            })
            ->when(request('date_to'), function($q, $dateTo) {
                return $q->whereDate('created_at', '<=', $dateTo);
            })
            ->latest()
            ->paginate(20);
        
        return view('admin.scalling', compact('role', 'roleNormalized', 'uploadHistory'));
    }
    
    // Upload History Page
    public function uploadHistory($role)
    {
        if (!in_array($role, ['gov', 'government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        // Get upload history for this role
        $roleNormalized = ($role === 'gov') ? 'government' : $role;
        
        $uploadHistory = LopOnHandImport::where('entity_type', $roleNormalized)
            ->when(request('month'), function($q, $month) {
                return $q->where('month', $month);
            })
            ->when(request('year'), function($q, $year) {
                return $q->where('year', $year);
            })
            ->when(request('date_from'), function($q, $dateFrom) {
                return $q->whereDate('created_at', '>=', $dateFrom);
            })
            ->when(request('date_to'), function($q, $dateTo) {
                return $q->whereDate('created_at', '<=', $dateTo);
            })
            ->latest()
            ->paginate(20);
            
        return view('admin.upload-history', compact('role', 'uploadHistory'));
    }
    
    // Progress Tracking Page
    public function progressTracking($role)
    {
        if (!in_array($role, ['gov', 'government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        // Get funnel tracking data with filters
        $roleNormalized = ($role === 'gov') ? 'government' : $role;
        
        $progressData = FunnelTracking::query()
            ->with(['onHandData.import', 'qualifiedData.import', 'koreksiData.import'])
            ->when(request('user_filter'), function($q, $userFilter) {
                return $q->where('updated_by', $userFilter);
            })
            ->when(request('data_type'), function($q, $dataType) {
                return $q->where('data_type', $dataType);
            })
            ->when(request('date_from'), function($q, $dateFrom) {
                return $q->whereDate('last_updated_at', '>=', $dateFrom);
            })
            ->when(request('date_to'), function($q, $dateTo) {
                return $q->whereDate('last_updated_at', '<=', $dateTo);
            })
            ->latest('last_updated_at')
            ->paginate(50);
            
        // Get unique users for filter
        $users = User::where('role', $roleNormalized)->get();
        
        return view('admin.progress-tracking', compact('role', 'progressData', 'users'));
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
        if (!in_array($role, ['government', 'private', 'soe', 'sme'])) {
            abort(404);
        }
        
        // Get PSAK model based on role
        $modelClass = match($role) {
            'government' => PsakGovernment::class,
            'private' => PsakPrivate::class,
            'soe' => PsakSoe::class,
            'sme' => PsakSme::class,
        };
        
        // Get PSAK data with users
        $psakData = $modelClass::with('user')
            ->orderBy('tanggal', 'desc')
            ->orderBy('user_id')
            ->get();
        
        // Get unique dates
        $dates = $modelClass::select('tanggal')
            ->distinct()
            ->orderBy('tanggal', 'desc')
            ->limit(30)
            ->pluck('tanggal');
        
        return view('admin.psak', compact('role', 'psakData', 'dates'));
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
        if (!in_array($entity, ['government', 'private', 'soe', 'sme'])) {
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
            'f0_inisiasi_solusi' => $request->has('f0_inisiasi_solusi'),
            'f1_tech_budget' => $request->has('f1_tech_budget'),
            'f2_p0_p1' => $request->has('f2_p0_p1'),
            'f2_p2' => $request->has('f2_p2'),
            'f2_p3' => $request->has('f2_p3'),
            'f2_p4' => $request->has('f2_p4'),
            'f2_offering' => $request->has('f2_offering'),
            'f2_p5' => $request->has('f2_p5'),
            'f2_proposal' => $request->has('f2_proposal'),
            'f3_p6' => $request->has('f3_p6'),
            'f3_p7' => $request->has('f3_p7'),
            'f3_submit' => $request->has('f3_submit'),
            'f4_negosiasi' => $request->has('f4_negosiasi'),
            'f5_sk_mitra' => $request->has('f5_sk_mitra'),
            'f5_ttd_kontrak' => $request->has('f5_ttd_kontrak'),
            'f5_p8' => $request->has('f5_p8'),
            'delivery_kontrak' => $request->has('delivery_kontrak'),
            'delivery_billing_complete' => $request->has('delivery_billing_complete'),
            'delivery_nilai_billcomp' => $request->delivery_nilai_billcomp,
            'delivery_baut_bast' => $request->delivery_baut_bast,
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
        // Get all LOP data with funnel tracking
        $onHandData = LopOnHandData::with(['funnel'])->get();
        
        $qualifiedData = LopQualifiedData::with(['funnel'])->get();
        
        $koreksiData = LopKoreksiData::with(['funnel'])->get();
        
        $initiateData = LopInitiateData::with(['funnel'])->get();
        
        return view('admin.lop-progress-tracking', compact(
            'onHandData',
            'qualifiedData',
            'koreksiData',
            'initiateData'
        ));
    }

    /**
     * Update Task Progress for Admin (AJAX)
     */
    public function updateTaskProgress(Request $request)
    {
        try {
            $request->validate([
                'funnel_id' => 'required|exists:funnel_tracking,id',
                'delivery_billing_complete' => 'required|boolean',
                'delivery_nilai_billcomp' => 'nullable|numeric',
            ]);

            $funnelId = $request->funnel_id;
            $userId = Auth::id();
            $today = today();

            // Find or create TaskProgress for current admin user and today's date
            $taskProgress = TaskProgress::firstOrCreate(
                [
                    'task_id' => $funnelId,
                    'user_id' => $userId,
                    'tanggal' => $today,
                ],
                [
                    // Initialize all fields to false
                    'f0_inisiasi_solusi' => false,
                    'f1_tech_budget' => false,
                    'f2_p0_p1' => false,
                    'f2_p2' => false,
                    'f2_p3' => false,
                    'f2_p4' => false,
                    'f2_offering' => false,
                    'f2_p5' => false,
                    'f2_proposal' => false,
                    'f3_p6' => false,
                    'f3_p7' => false,
                    'f3_submit' => false,
                    'f4_negosiasi' => false,
                    'f5_sk_mitra' => false,
                    'f5_ttd_kontrak' => false,
                    'f5_p8' => false,
                    'delivery_kontrak' => false,
                ]
            );

            // Update billing complete and nilai
            $taskProgress->delivery_billing_complete = $request->delivery_billing_complete;
            $taskProgress->delivery_nilai_billcomp = $request->delivery_billing_complete 
                ? $request->delivery_nilai_billcomp 
                : 0;
            $taskProgress->save();

            // IMPORTANT: Also update FunnelTracking table (master status)
            $funnelTracking = FunnelTracking::find($funnelId);
            if ($funnelTracking) {
                $funnelTracking->delivery_billing_complete = $request->delivery_billing_complete;
                $funnelTracking->delivery_nilai_billcomp = $request->delivery_billing_complete 
                    ? $request->delivery_nilai_billcomp 
                    : 0;
                $funnelTracking->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Task progress and funnel tracking updated successfully',
                'data' => [
                    'task_progress' => $taskProgress,
                    'funnel_tracking' => $funnelTracking
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task progress: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Special Dashboard for Collection, CTC, and Rising Star
     * Shows user activities with timestamps and filters
     */
    public function specialDashboard(Request $request, $role)
    {
        // Validate role
        if (!in_array($role, ['collection', 'ctc', 'rising-star'])) {
            abort(404);
        }

        // Get users with the specific role
        $users = User::where('role', $role)->get();

        // Get task progress (activities) with filters
        $query = TaskProgress::with(['user', 'task'])
            ->whereHas('user', function($q) use ($role) {
                $q->where('role', $role);
            });

        // Apply user filter
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Apply date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }

        // Get activities with pagination
        $activities = $query->orderBy('updated_at', 'desc')
            ->paginate(20)
            ->through(function ($activity) {
                // Add module and action info
                $activity->module = $this->getModuleFromDataType($activity->task->data_type ?? '');
                $activity->action = 'Data Update';
                $activity->data_id = $activity->task->data_id ?? '-';
                return $activity;
            });

        // Get today's activity count
        $todayActivities = TaskProgress::whereHas('user', function($q) use ($role) {
                $q->where('role', $role);
            })
            ->whereDate('tanggal', today())
            ->count();

        return view('admin.special-dashboard', compact('role', 'users', 'activities', 'todayActivities'));
    }

    /**
     * Helper method to get module name from data type
     */
    private function getModuleFromDataType($dataType)
    {
        $modules = [
            'on_hand' => 'On Hand',
            'qualified' => 'Qualified',
            'koreksi' => 'Koreksi',
            'initiate' => 'Initiate',
            'collection_on_hand' => 'Collection On Hand',
            'collection_qualified' => 'Collection Qualified',
            'collection_koreksi' => 'Collection Koreksi',
            'ctc_on_hand' => 'CTC On Hand',
            'ctc_qualified' => 'CTC Qualified',
            'ctc_koreksi' => 'CTC Koreksi',
            'rising_star_on_hand' => 'Rising Star On Hand',
            'rising_star_qualified' => 'Rising Star Qualified',
            'rising_star_koreksi' => 'Rising Star Koreksi',
        ];

        return $modules[$dataType] ?? ucfirst(str_replace('_', ' ', $dataType));
    }
}

