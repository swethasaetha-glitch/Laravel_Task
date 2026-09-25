<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFabricGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $groupId = $this->route('fabric_group') ? ($this->route('fabric_group')->id ?? $this->route('fabric_group')) : null;

        return [
            'group_code' => ['required', 'string', 'max:50', Rule::unique('fabric_groups', 'group_code')->ignore($groupId)],
            'group_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'fabrics' => ['required', 'array', 'min:1'],
            'fabrics.*' => ['required', 'integer', 'exists:fabrics,id'],
            'status' => ['required', 'in:Active,Inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'fabrics.required' => 'At least one fabric must be selected for the fabric group.',
            'fabrics.min' => 'At least one fabric must be selected for the fabric group.',
        ];
    }
}
