<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateVehicleRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand'      => ['sometimes', 'string', 'max:100'],
            'model'      => ['sometimes', 'string', 'max:100'],
            'daily_rate' => ['sometimes', 'numeric', 'min:0'],
            'latitude'   => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude'  => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
            'status'     => ['sometimes', 'in:available,rented,maintenance,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'daily_rate.numeric' => 'Harga sewa harus berupa angka.',
            'daily_rate.min'     => 'Harga sewa tidak boleh negatif.',
            'latitude.between'   => 'Latitude tidak valid.',
            'longitude.between'  => 'Longitude tidak valid.',
            'status.in'          => 'Status tidak valid. Pilih: available, rented, maintenance, inactive.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 400)
        );
    }
}
