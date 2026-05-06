<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\OwnerAccount;
use App\Models\RenterAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     
    private function resolveModel(string $type): string
    {
        return match ($type) {
            'owner'  => OwnerAccount::class,
            'renter' => RenterAccount::class,
            default  => abort(400, 'Tipe akun tidak valid. Gunakan owner atau renter.'),
        };
    }

    // -------------------------------------------------------------------------
    // POST /api/v1/auth/{type}/register
    // -------------------------------------------------------------------------
    public function register(RegisterRequest $request, string $type): JsonResponse
    {
        $model = $this->resolveModel($type);

        // Cek apakah email sudah digunakan
        if ($model::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'Email sudah digunakan.',
            ], 409);
        }

        $account = $model::create([
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'is_active'     => true,
        ]);

        $token = $account->createToken("$type-token")->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'data'    => [
                'id'    => $account->id,
                'email' => $account->email,
                'token' => $token,
            ],
        ], 201);
    }

    // -------------------------------------------------------------------------
    // POST /api/v1/auth/{type}/login
    // -------------------------------------------------------------------------
    public function login(LoginRequest $request, string $type): JsonResponse
    {
        $model   = $this->resolveModel($type);
        $account = $model::where('email', $request->email)->first();

        // Cek akun & password
        if (! $account || ! Hash::check($request->password, $account->password_hash)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Cek apakah akun aktif
        if (! $account->is_active) {
            return response()->json([
                'message' => 'Akun Anda tidak aktif.',
            ], 403);
        }

        // Hapus token lama, buat token baru
        $account->tokens()->delete();
        $token = $account->createToken("$type-token")->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'data'    => [
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ],
        ], 200);
    }

    // -------------------------------------------------------------------------
    // POST /api/v1/auth/logout
    // -------------------------------------------------------------------------
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil.',
        ], 200);
    }
}
