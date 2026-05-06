<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'latitude'  => $this->query('latitude'),
            'longitude' => $this->query('longitude'),
            'radius'    => $this->query('radius'),
        ]);
    }

    public function rules(): array
    {
        return [
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius'    => ['nullable', 'numeric', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required'  => 'Latitude wajib diisi.',
            'latitude.between'   => 'Latitude tidak valid.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.between'  => 'Longitude tidak valid.',
            'radius.min'         => 'Radius minimal 1 km.',
            'radius.max'         => 'Radius maksimal 100 km.',
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