<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RenterKycRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RenterProfileController extends Controller
{
    // -------------------------------------------------------------------------
    // GET /api/v1/renter/profile
    // -------------------------------------------------------------------------
    public function show(Request $request): JsonResponse
    {
        $renter  = $request->user();
        $profile = $renter->profile;

        if (! $profile) {
            return response()->json([
                'message' => 'Profil belum dibuat.',
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil profil.',
            'data'    => [
                'id'                  => $profile->id,
                'renter_id'           => $profile->renter_id,
                'full_name'           => $profile->full_name,
                'nik'                 => $profile->nik,
                'license_no'          => $profile->license_no,
                'sim_image_url'       => $profile->sim_image_url
                                            ? Storage::url($profile->sim_image_url)
                                            : null,
                'verification_status' => $profile->verification_status,
            ],
        ], 200);
    }

    // -------------------------------------------------------------------------
    // PUT /api/v1/renter/profile/kyc
    // -------------------------------------------------------------------------
    public function kyc(RenterKycRequest $request): JsonResponse
    {
        $renter  = $request->user();
        $profile = $renter->profile;

        // Simpan file SIM
        $simPath = $request->file('sim_image')->store('sim/renter', 'public');

        if (! $profile) {
            // Buat profil baru jika belum ada
            $profile = $renter->profile()->create([
                'full_name'           => $request->full_name,
                'nik'                 => $request->nik,
                'license_no'          => $request->license_no,
                'sim_image_url'       => $simPath,
                'verification_status' => 'pending',
            ]);
        } else {
            // Hapus file lama jika ada
            if ($profile->sim_image_url) {
                Storage::disk('public')->delete($profile->sim_image_url);
            }

            $profile->update([
                'full_name'           => $request->full_name,
                'nik'                 => $request->nik,
                'license_no'          => $request->license_no,
                'sim_image_url'       => $simPath,
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
