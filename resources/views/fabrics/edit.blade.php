@extends('layouts.app')

@section('title', 'Edit Fabric')

@section('content')
<div class="mb-4">
    <a href="{{ route('fabrics.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left"></i> Back to Fabrics
    </a>
    <h2 class="fw-bold mt-2">Edit Fabric: {{ $fabric->fabric_code }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('fabrics.update', $fabric) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="fabric_code" class="form-label fw-semibold">Fabric Code <span class="text-danger">*</span></label>
                    <input type="text" name="fabric_code" id="fabric_code" class="form-control @error('fabric_code') is-invalid @enderror" value="{{ old('fabric_code', $fabric->fabric_code) }}" required>
                    @error('fabric_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_name" class="form-label fw-semibold">Fabric Name <span class="text-danger">*</span></label>
                    <input type="text" name="fabric_name" id="fabric_name" class="form-control @error('fabric_name') is-invalid @enderror" value="{{ old('fabric_name', $fabric->fabric_name) }}" required>
                    @error('fabric_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_type" class="form-label fw-semibold">Fabric Type <span class="text-danger">*</span></label>
                    <select name="fabric_type" id="fabric_type" class="form-select @error('fabric_type') is-invalid @enderror" required>
                        <option value="Knitted" {{ old('fabric_type', $fabric->fabric_type) == 'Knitted' ? 'selected' : '' }}>Knitted</option>
                        <option value="Woven" {{ old('fabric_type', $fabric->fabric_type) == 'Woven' ? 'selected' : '' }}>Woven</option>
                        <option value="Non-Woven" {{ old('fabric_type', $fabric->fabric_type) == 'Non-Woven' ? 'selected' : '' }}>Non-Woven</option>
                    </select>
                    @error('fabric_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="composition" class="form-label fw-semibold">Composition</label>
                    <input type="text" name="composition" id="composition" class="form-control @error('composition') is-invalid @enderror" value="{{ old('composition', $fabric->composition) }}">
                    @error('composition')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="color" class="form-label fw-semibold">Color</label>
                    <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $fabric->color) }}">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="gsm" class="form-label fw-semibold">GSM</label>
                    <input type="number" step="0.01" min="0" name="gsm" id="gsm" class="form-control @error('gsm') is-invalid @enderror" value="{{ old('gsm', $fabric->gsm) }}">
                    @error('gsm')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="width" class="form-label fw-semibold">Width</label>
                    <input type="number" step="0.01" min="0" name="width" id="width" class="form-control @error('width') is-invalid @enderror" value="{{ old('width', $fabric->width) }}">
                    @error('width')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="unit" class="form-label fw-semibold">Unit</label>
                    <select name="unit" id="unit" class="form-select @error('unit') is-invalid @enderror">
                        <option value="KG" {{ old('unit', $fabric->unit) == 'KG' ? 'selected' : '' }}>KG</option>
                        <option value="Meter" {{ old('unit', $fabric->unit) == 'Meter' ? 'selected' : '' }}>Meter</option>
                        <option value="Yard" {{ old('unit', $fabric->unit) == 'Yard' ? 'selected' : '' }}>Yard</option>
                    </select>
                    @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Active" {{ old('status', $fabric->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $fabric->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $fabric->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('fabrics.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="bi bi-check-lg me-1"></i> Update Fabric
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
