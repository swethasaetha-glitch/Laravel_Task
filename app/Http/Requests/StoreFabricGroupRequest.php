<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFabricGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'group_code' => ['required', 'string', 'max:50', 'unique:fabric_groups,group_code'],
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
            'fabrics.required' => 'At least one fabric must be selected when creating a fabric group.',
            'fabrics.min' => 'At least one fabric must be selected when creating a fabric group.',
        ];
    }
}
