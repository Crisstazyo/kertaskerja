@extends('layouts.app')

@section('title', 'Government - Add LOP Initiate Project')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle"></i> Add New LOP Initiate Project
                    </h4>
                    <a href="{{ route('government.lop.initiate.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('government.lop.initiate.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project">Project Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('project') is-invalid @enderror" 
                                           id="project" name="project" value="{{ old('project') }}" 
                                           placeholder="Enter project name" required>
                                    @error('project')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_lop">ID LOP</label>
                                    <input type="text" class="form-control @error('id_lop') is-invalid @enderror" 
                                           id="id_lop" name="id_lop" value="{{ old('id_lop') }}" 
                                           placeholder="Enter ID LOP">
                                    @error('id_lop')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cc">CC</label>
                                    <input type="text" class="form-control @error('cc') is-invalid @enderror" 
                                           id="cc" name="cc" value="{{ old('cc') }}" 
                                           placeholder="Enter CC">
                                    @error('cc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nipnas">NIPNAS</label>
                                    <input type="text" class="form-control @error('nipnas') is-invalid @enderror" 
                                           id="nipnas" name="nipnas" value="{{ old('nipnas') }}" 
                                           placeholder="Enter NIPNAS">
                                    @error('nipnas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="am">AM</label>
                                    <input type="text" class="form-control @error('am') is-invalid @enderror" 
                                           id="am" name="am" value="{{ old('am') }}" 
                                           placeholder="Enter AM">
                                    @error('am')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mitra">Mitra <span class="text-danger">*</span></label>
                                    <select class="form-control @error('mitra') is-invalid @enderror" 
                                            id="mitra" name="mitra" required>
                                        <option value="" {{ old('mitra') == '' ? 'selected' : '' }}>-- Pilih Mitra --</option>
                                        <option value="Tanpa Mitra" {{ old('mitra') == 'Tanpa Mitra' ? 'selected' : '' }}>Tanpa Mitra</option>
                                        <option value="Dengan Mitra" {{ old('mitra') == 'Dengan Mitra' ? 'selected' : '' }}>Dengan Mitra</option>
                                    </select>
                                    @error('mitra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plan_bulan_billcom_p_2025">Plan Bulan Billcom P 2025</label>
                                    <input type="text" class="form-control @error('plan_bulan_billcom_p_2025') is-invalid @enderror" 
                                           id="plan_bulan_billcom_p_2025" name="plan_bulan_billcom_p_2025" 
                                           value="{{ old('plan_bulan_billcom_p_2025') }}" 
                                           placeholder="e.g., January 2025">
                                    @error('plan_bulan_billcom_p_2025')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="est_nilai_bc">EST Nilai BC</label>
                                    <input type="number" step="0.01" class="form-control @error('est_nilai_bc') is-invalid @enderror" 
                                           id="est_nilai_bc" name="est_nilai_bc" value="{{ old('est_nilai_bc') }}" 
                                           placeholder="Enter estimated value">
                                    @error('est_nilai_bc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="month">Month <span class="text-danger">*</span></label>
                                    <select class="form-control @error('month') is-invalid @enderror" id="month" name="month" required>
                                        <option value="">Select Month</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ old('month') == $i ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="year">Year <span class="text-danger">*</span></label>
                                    <select class="form-control @error('year') is-invalid @enderror" id="year" name="year" required>
                                        <option value="">Select Year</option>
                                        @for($i = date('Y') - 2; $i <= date('Y') + 5; $i++)
                                            <option value="{{ $i }}" {{ old('year', date('Y')) == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Note:</strong> This project will be added to your LOP Initiate data and will be visible to administrators. 
                                You can track and update the progress of this project after creation.
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
