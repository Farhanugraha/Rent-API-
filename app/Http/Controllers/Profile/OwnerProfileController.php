<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OwnerKycRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OwnerProfileController extends Controller
{
    // -------------------------------------------------------------------------
    // GET /api/v1/owner/profile
    // -------------------------------------------------------------------------
    public function show(Request $request): JsonResponse
    {
        $owner   = $request->user();
        $profile = $owner->profile;

        if (! $profile) {
            return response()->json([
                'message' => 'Profil belum dibuat.',
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil profil.',
            'data'    => [
                'id'                  => $profile->id,
                'owner_id'            => $profile->owner_id,
                'full_name'           => $profile->full_name,
                'nik'                 => $profile->nik,
                'ktp_image_url'       => $profile->ktp_image_url
                                            ? Storage::url($profile->ktp_image_url)
                                            : null,
                'verification_status' => $profile->verification_status,
            ],
        ], 200);
    }

    // -------------------------------------------------------------------------
    // PUT /api/v1/owner/profile/kyc
    // -------------------------------------------------------------------------
    public function kyc(OwnerKycRequest $request): JsonResponse
    {
        $owner   = $request->user();
        $profile = $owner->profile;

        // Simpan file KTP
        $ktpPath = $request->file('ktp_image')->store('ktp/owner', 'public');

        if (! $profile) {
            // Buat profil baru jika belum ada
            $profile = $owner->profile()->create([
                'full_name'           => $request->full_name,
                'nik'                 => $request->nik,
                'ktp_image_url'       => $ktpPath,
                'verification_status' => 'pending',
            ]);
        } else {
            // Hapus file lama jika ada
            if ($profile->ktp_image_url) {
                Storage::disk('public')->delete($profile->ktp_image_url);
            }

            $profile->update([
                'full_name'           => $request->full_name,
                'nik'                 => $request->nik,
                'ktp_image_url'       => $ktpPath,
                'verification_status' => 'pending',
            ]);
        }

        return response()->json([
            'message' => 'KYC berhasil dikirim, menunggu verifikasi.',
            'data'    => [
                'verification_status' => $profile->verification_status,
            ],
        ], 200);
    }
}
