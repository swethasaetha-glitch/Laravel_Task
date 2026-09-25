@extends('layouts.app')

@section('title', 'Create Lay Model')

@section('content')
<div class="mb-4">
    <a href="{{ route('lay-models.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left"></i> Back to Lay Models
    </a>
    <h2 class="fw-bold mt-2">Create Lay Model</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('lay-models.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="lay_model_code" class="form-label fw-semibold">Lay Model Code <span class="text-danger">*</span></label>
                    <input type="text" name="lay_model_code" id="lay_model_code" class="form-control @error('lay_model_code') is-invalid @enderror" value="{{ old('lay_model_code') }}" required placeholder="e.g. LM-001">
                    @error('lay_model_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="lay_model_name" class="form-label fw-semibold">Lay Model Name <span class="text-danger">*</span></label>
                    <input type="text" name="lay_model_name" id="lay_model_name" class="form-control @error('lay_model_name') is-invalid @enderror" value="{{ old('lay_model_name') }}" required placeholder="e.g. Men's T-Shirt Lay">
                    @error('lay_model_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_group_id" class="form-label fw-semibold">Fabric Group <span class="text-danger">*</span></label>
                    <select name="fabric_group_id" id="fabric_group_id" class="form-select @error('fabric_group_id') is-invalid @enderror" required>
                        <option value="">-- Select Fabric Group --</option>
                        @foreach($fabricGroups as $group)
                            <option value="{{ $group->id }}" {{ old('fabric_group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->group_code }} - {{ $group->group_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('fabric_group_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fabric_id" class="form-label fw-semibold">Fabric <span class="text-danger">*</span></label>
                    <select name="fabric_id" id="fabric_id" class="form-select @error('fabric_id') is-invalid @enderror" required>
                        <option value="">-- Select Fabric Group First --</option>
                    </select>
                    @error('fabric_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="lay_length" class="form-label fw-semibold">Lay Length <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="lay_length" id="lay_length" class="form-control @error('lay_length') is-invalid @enderror" value="{{ old('lay_length') }}" required placeholder="e.g. 12.50">
                    @error('lay_length')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="lay_width" class="form-label fw-semibold">Lay Width <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="lay_width" id="lay_width" class="form-control @error('lay_width') is-invalid @enderror" value="{{ old('lay_width') }}" required placeholder="e.g. 72">
                    @error('lay_width')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="number_of_plies" class="form-label fw-semibold">Number of Plies <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="number_of_plies" id="number_of_plies" class="form-control @error('number_of_plies') is-invalid @enderror" value="{{ old('number_of_plies') }}" required placeholder="e.g. 50">
                    @error('number_of_plies')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="garment_size" class="form-label fw-semibold">Garment Size</label>
                    <input type="text" name="garment_size" id="garment_size" class="form-control @error('garment_size') is-invalid @enderror" value="{{ old('garment_size') }}" placeholder="e.g. L">
                    @error('garment_size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="marker_length" class="form-label fw-semibold">Marker Length</label>
                    <input type="number" step="0.01" min="0" name="marker_length" id="marker_length" class="form-control @error('marker_length') is-invalid @enderror" value="{{ old('marker_length') }}" placeholder="e.g. 11.80">
                    @error('marker_length')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="marker_width" class="form-label fw-semibold">Marker Width</label>
                    <input type="number" step="0.01" min="0" name="marker_width" id="marker_width" class="form-control @error('marker_width') is-invalid @enderror" value="{{ old('marker_width') }}" placeholder="e.g. 68">
                    @error('marker_width')
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
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Laying and cutting instructions...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('lay-models.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-info text-white px-4 fw-bold">
                    <i class="bi bi-save me-1"></i> Save Lay Model
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const groupsData = @json($fabricGroups);
        const groupSelect = document.getElementById('fabric_group_id');
        const fabricSelect = document.getElementById('fabric_id');
        const selectedFabricId = @json(old('fabric_id'));

        function updateFabricOptions(groupId, selectedId = null) {
            fabricSelect.innerHTML = '<option value="">-- Select Fabric --</option>';

            if (!groupId) {
                fabricSelect.innerHTML = '<option value="">-- Select Fabric Group First --</option>';
                return;
            }

            const group = groupsData.find(g => g.id == groupId);
            if (group && group.fabrics && group.fabrics.length > 0) {
                group.fabrics.forEach(fabric => {
                    const option = document.createElement('option');
                    option.value = fabric.id;
                    option.textContent = `${fabric.fabric_code} - ${fabric.fabric_name}`;
                    if (selectedId && fabric.id == selectedId) {
                        option.selected = true;
                    }
                    fabricSelect.appendChild(option);
                });
            } else {
                fabricSelect.innerHTML = '<option value="">-- No fabrics found in this group --</option>';
            }
        }

        groupSelect.addEventListener('change', function () {
            updateFabricOptions(this.value);
        });

        // Initialize on page load if group selected
        if (groupSelect.value) {
            updateFabricOptions(groupSelect.value, selectedFabricId);
        }
    });
</script>
@endpush
