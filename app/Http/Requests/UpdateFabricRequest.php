<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFabricRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $fabricId = $this->route('fabric') ? $this->route('fabric')->id ?? $this->route('fabric') : null;

        return [
            'fabric_code' => ['required', 'string', 'max:50', Rule::unique('fabrics', 'fabric_code')->ignore($fabricId)],
            'fabric_name' => ['required', 'string', 'max:255'],
            'fabric_type' => ['required', 'string', 'max:100'],
            'composition' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:100'],
            'gsm' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:Active,Inactive'],
        ];
    }
}
