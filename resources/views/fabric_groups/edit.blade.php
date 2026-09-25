@extends('layouts.app')

@section('title', 'Edit Fabric Group')

@section('content')
<div class="mb-4">
    <a href="{{ route('fabric-groups.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left"></i> Back to Fabric Groups
    </a>
    <h2 class="fw-bold mt-2">Edit Fabric Group: {{ $fabricGroup->group_code }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('fabric-groups.update', $fabricGroup) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="group_code" class="form-label fw-semibold">Group Code <span class="text-danger">*</span></label>
                    <input type="text" name="group_code" id="group_code" class="form-control @error('group_code') is-invalid @enderror" value="{{ old('group_code', $fabricGroup->group_code) }}" required>
                    @error('group_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="group_name" class="form-label fw-semibold">Group Name <span class="text-danger">*</span></label>
                    <input type="text" name="group_name" id="group_name" class="form-control @error('group_name') is-invalid @enderror" value="{{ old('group_name', $fabricGroup->group_name) }}" required>
                    @error('group_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="2" class="form-control @error('description') is-invalid @enderror">{{ old('description', $fabricGroup->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Select Fabrics <span class="text-danger">*</span></label>
                    <p class="small text-muted mb-2">Check all fabrics that belong to this group (at least 1 required).</p>
                    <div class="card border bg-light p-3">
                        <div class="row g-2" style="max-height: 250px; overflow-y: auto;">
                            @forelse($fabrics as $fabric)
                                @php
                                    $isChecked = is_array(old('fabrics')) 
                                        ? in_array($fabric->id, old('fabrics')) 
                                        : in_array($fabric->id, $selectedFabricIds);
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check p-2 bg-white rounded border">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" name="fabrics[]" value="{{ $fabric->id }}" id="fabric_{{ $fabric->id }}" {{ $isChecked ? 'checked' : '' }}>
                                        <label class="form-check-label d-block text-truncate" for="fabric_{{ $fabric->id }}">
                                            <strong>{{ $fabric->fabric_code }}</strong> - {{ $fabric->fabric_name }}
                                            <span class="badge bg-light text-dark border ms-1">{{ $fabric->gsm ? $fabric->gsm . ' GSM' : $fabric->fabric_type }}</span>
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted py-3">
                                    No fabrics available.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    @error('fabrics')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Active" {{ old('status', $fabricGroup->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $fabricGroup->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('fabric-groups.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="bi bi-check-lg me-1"></i> Update Group
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
