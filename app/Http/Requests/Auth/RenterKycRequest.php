<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RenterKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'  => ['required', 'string', 'max:255'],
            'nik'        => ['required', 'digits:16'],
            'license_no' => ['required', 'string', 'max:20'],
            'sim_image'  => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'  => 'Nama lengkap wajib diisi.',
            'nik.required'        => 'NIK wajib diisi.',
            'nik.digits'          => 'NIK harus 16 digit.',
            'license_no.required' => 'Nomor SIM wajib diisi.',
            'sim_image.required'  => 'Foto SIM wajib diunggah.',
            'sim_image.image'     => 'File harus berupa gambar.',
            'sim_image.mimes'     => 'Format gambar harus jpg, jpeg, atau png.',
            'sim_image.max'       => 'Ukuran gambar maksimal 2MB.',
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
