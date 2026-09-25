@extends('layouts.app')

@section('title', 'Create Fabric')

@section('content')
<div class="mb-4">
    <a href="{{ route('fabrics.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left"></i> Back to Fabrics
    </a>
    <h2 class="fw-bold mt-2">Add New Fabric</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('fabrics.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="fabric_code" class="form-label fw-semibold">Fabric Code <span class="text-danger">*</span></label>
                    <input type="text" name="fabric_code" id="fabric_code" class="form-control @error('fabric_code') is-invalid @enderror" value="{{ old('fabric_code') }}" required placeholder="e.g. FAB-001">
                    @error('fabric_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_name" class="form-label fw-semibold">Fabric Name <span class="text-danger">*</span></label>
                    <input type="text" name="fabric_name" id="fabric_name" class="form-control @error('fabric_name') is-invalid @enderror" value="{{ old('fabric_name') }}" required placeholder="e.g. Cotton Single Jersey">
                    @error('fabric_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_type" class="form-label fw-semibold">Fabric Type <span class="text-danger">*</span></label>
                    <select name="fabric_type" id="fabric_type" class="form-select @error('fabric_type') is-invalid @enderror" required>
                        <option value="">-- Select Type --</option>
                        <option value="Knitted" {{ old('fabric_type') == 'Knitted' ? 'selected' : '' }}>Knitted</option>
                        <option value="Woven" {{ old('fabric_type') == 'Woven' ? 'selected' : '' }}>Woven</option>
                        <option value="Non-Woven" {{ old('fabric_type') == 'Non-Woven' ? 'selected' : '' }}>Non-Woven</option>
                    </select>
                    @error('fabric_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="composition" class="form-label fw-semibold">Composition</label>
                    <input type="text" name="composition" id="composition" class="form-control @error('composition') is-invalid @enderror" value="{{ old('composition') }}" placeholder="e.g. 100% Cotton">
                    @error('composition')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="color" class="form-label fw-semibold">Color</label>
                    <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color') }}" placeholder="e.g. Black">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="gsm" class="form-label fw-semibold">GSM</label>
                    <input type="number" step="0.01" min="0" name="gsm" id="gsm" class="form-control @error('gsm') is-invalid @enderror" value="{{ old('gsm') }}" placeholder="e.g. 180">
                    @error('gsm')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="width" class="form-label fw-semibold">Width</label>
                    <input type="number" step="0.01" min="0" name="width" id="width" class="form-control @error('width') is-invalid @enderror" value="{{ old('width') }}" placeholder="e.g. 72">
                    @error('width')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="unit" class="form-label fw-semibold">Unit</label>
                    <select name="unit" id="unit" class="form-select @error('unit') is-invalid @enderror">
                        <option value="KG" {{ old('unit', 'KG') == 'KG' ? 'selected' : '' }}>KG</option>
                        <option value="Meter" {{ old('unit') == 'Meter' ? 'selected' : '' }}>Meter</option>
                        <option value="Yard" {{ old('unit') == 'Yard' ? 'selected' : '' }}>Yard</option>
                    </select>
                    @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Fabric notes or specifications...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('fabrics.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="bi bi-save me-1"></i> Save Fabric
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
