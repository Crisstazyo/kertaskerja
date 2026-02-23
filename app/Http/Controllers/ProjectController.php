<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CustomColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function menu()
    {
        $role = Auth::user()->role;
        
        return view('dashboard.menu', compact('role'));
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        
        $query = Project::where('role', $role);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by project name
        if ($request->filled('search')) {
            $query->where('project_name', 'like', '%' . $request->search . '%');
        }

        $projects = $query->orderBy('created_at', 'desc')->get();
        $customColumns = CustomColumn::where('role', $role)->orderBy('order')->get();

        return view('dashboard.index', compact('projects', 'customColumns', 'role'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['user_id'] = Auth::id();
        $data['role'] = Auth::user()->role;

        // Determine if this is a user-added row or admin-created row
        $isUserAdded = $request->boolean('is_user_added', false);
        $data['is_user_added'] = $isUserAdded;

        // If user is not admin
        if (Auth::user()->role !== 'admin') {
            if ($isUserAdded) {
                // New row added by user - can only fill F1-F2
                $allowedFields = [
                    'project_name', 'id_lop', 'worksheet_id',
                    'f1_technical_budget',
                    'f2_p0_p1_jukbok', 'f2_p3_permintaan_penawaran', 
                    'f2_p4_rapat_penjelasan', 'f2_p5_evaluasi_sph',
                    'p2_evaluasi_bakal_calon', 'offering_harga_final',
                ];
            } else {
                // Existing admin-created row - can fill F1 to Delivery
                $allowedFields = [
                    'project_name', 'id_lop', 'cc', 'nipnas', 'am', 'mitra', 
                    'phn_bulan_billcomp', 'est_nilai_bc',
                    'f1_technical_budget',
                    'f2_p0_p1_jukbok', 'f2_p3_permintaan_penawaran', 
                    'f2_p4_rapat_penjelasan', 'f2_p5_evaluasi_sph',
                    'p2_evaluasi_bakal_calon', 'offering_harga_final',
                    'f3_p6_klarifikasi_negosiasi', 'f3_p7_penetapan_mitra', 'f3_submit_proposal',
                    'negosiasi',
                    'surat', 'tanda', 'f5_p8_surat_penetapan',
                    'del_kontrak_layanan', 'baut', 'del_baso',
                    'billing_complete', 'keterangan'
                ];
            }
            
            $data = array_filter($data, function($key) use ($allowedFields) {
                return in_array($key, $allowedFields) || in_array($key, ['user_id', 'role', 'worksheet_id', 'is_user_added']);
            }, ARRAY_FILTER_USE_KEY);
        }

        // Handle custom fields
        $customFields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'custom_') === 0) {
                $customFields[$key] = $value;
                unset($data[$key]);
            }
        }
        $data['custom_fields'] = $customFields;

        Project::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, Project $project)
    {
        // Check if user owns this project or has same role
        if ($project->role !== Auth::user()->role) {
            abort(403);
        }

        $data = $request->except('_token', '_method');

        // Handle custom fields
        $customFields = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'custom_') === 0) {
                $customFields[$key] = $value;
                unset($data[$key]);
            }
        }
        $data['custom_fields'] = $customFields;

        // Handle boolean fields (checkboxes) - set to null if not present
        $booleanFields = ['f1_technical_budget', 'f2_p5_evaluasi_sph', 'negosiasi', 'f5_p8_surat_penetapan'];
        foreach ($booleanFields as $field) {
            if (!isset($data[$field])) {
                $data[$field] = null;
            }
        }

        $project->update($data);

        return redirect()->route('dashboard')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(Project $project)
    {
        // Check if user owns this project or has same role (or is admin)
        if (Auth::user()->role !== 'admin' && $project->role !== Auth::user()->role) {
            abort(403);
        }

        $project->delete();

        // If request from admin panel, redirect back to admin view
        if (request()->header('referer') && str_contains(request()->header('referer'), '/admin/')) {
            return back()->with('success', 'Project berhasil dihapus!');
        }

        return redirect()->route('dashboard')->with('success', 'Data berhasil dihapus!');
    }

    public function addColumn(Request $request)
    {
        $request->validate([
            'column_label' => 'required|string',
            'column_type' => 'required|in:text,number,date,textarea',
        ]);

        $role = Auth::user()->role;
        $columnName = 'custom_' . strtolower(str_replace(' ', '_', $request->column_label));

        CustomColumn::create([
            'role' => $role,
            'column_name' => $columnName,
            'column_label' => $request->column_label,
            'column_type' => $request->column_type,
            'order' => CustomColumn::where('role', $role)->count(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Kolom baru berhasil ditambahkan!');
    }

    public function deleteColumn(CustomColumn $column)
    {
        if ($column->role !== Auth::user()->role) {
            abort(403);
        }

        $column->delete();

        return redirect()->route('dashboard')->with('success', 'Kolom berhasil dihapus!');
    }
}
