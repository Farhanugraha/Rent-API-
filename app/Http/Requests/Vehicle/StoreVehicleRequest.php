<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreVehicleRequest extends FormRequest
{
       public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand'      => ['required', 'string', 'max:100'],
            'model'      => ['required', 'string', 'max:100'],
            'daily_rate' => ['required', 'numeric', 'min:0'],
            'latitude'   => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'  => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    public function messages(): array
    {
        return [
            'brand.required'      => 'Merek kendaraan wajib diisi.',
            'model.required'      => 'Model kendaraan wajib diisi.',
            'daily_rate.required' => 'Harga sewa per hari wajib diisi.',
            'daily_rate.numeric'  => 'Harga sewa harus berupa angka.',
            'daily_rate.min'      => 'Harga sewa tidak boleh negatif.',
            'latitude.between'    => 'Latitude tidak valid.',
            'longitude.between'   => 'Longitude tidak valid.',
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
