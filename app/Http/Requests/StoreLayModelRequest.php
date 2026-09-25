<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreLayModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lay_model_code' => ['required', 'string', 'max:50', 'unique:lay_models,lay_model_code'],
            'lay_model_name' => ['required', 'string', 'max:255'],
            'fabric_group_id' => ['required', 'integer', 'exists:fabric_groups,id'],
            'fabric_id' => ['required', 'integer', 'exists:fabrics,id'],
            'lay_length' => ['required', 'numeric', 'min:0'],
            'lay_width' => ['required', 'numeric', 'min:0'],
            'number_of_plies' => ['required', 'integer', 'min:0'],
            'garment_size' => ['nullable', 'string', 'max:50'],
            'marker_length' => ['nullable', 'numeric', 'min:0'],
            'marker_width' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:Active,Inactive'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->fabric_group_id && $this->fabric_id) {
                $belongs = DB::table('fabric_group_fabric')
                    ->where('fabric_group_id', $this->fabric_group_id)
                    ->where('fabric_id', $this->fabric_id)
                    ->exists();

                if (!$belongs) {
                    $validator->errors()->add('fabric_id', 'The selected fabric does not belong to the selected fabric group.');
                }
            }
        });
    }
}
