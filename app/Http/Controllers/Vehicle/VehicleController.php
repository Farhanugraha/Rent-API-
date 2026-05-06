<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
      // -------------------------------------------------------------------------
    // POST /api/v1/owner/vehicles
    // -------------------------------------------------------------------------
    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $vehicle = $request->user()->vehicles()->create([
            'brand'      => $request->brand,
            'model'      => $request->model,
            'daily_rate' => $request->daily_rate,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'status'     => 'available',
        ]);

        return response()->json([
            'message' => 'Kendaraan berhasil ditambahkan.',
            'data'    => $vehicle,
        ], 201);
    }

    // -------------------------------------------------------------------------
    // GET /api/v1/owner/vehicles
    // -------------------------------------------------------------------------
    public function index(Request $request): JsonResponse
    {
        $vehicles = $request->user()->vehicles()->latest()->get();

        return response()->json([
            'message' => 'Berhasil mengambil daftar kendaraan.',
            'data'    => $vehicles,
        ], 200);
    }

    // -------------------------------------------------------------------------
    // PATCH /api/v1/owner/vehicles/{id}
    // -------------------------------------------------------------------------
    public function update(UpdateVehicleRequest $request, string $id): JsonResponse
    {
        $vehicle = $request->user()->vehicles()->find($id);

        if (! $vehicle) {
            return response()->json([
                'message' => 'Kendaraan tidak ditemukan.',
            ], 404);
        }

        $vehicle->update($request->only([
            'brand',
            'model',
            'daily_rate',
            'latitude',
            'longitude',
            'status',
        ]));

        return response()->json([
            'message' => 'Kendaraan berhasil diupdate.',
            'data'    => $vehicle->fresh(),
        ], 200);
    }

    // -------------------------------------------------------------------------
    // DELETE /api/v1/owner/vehicles/{id}
    // -------------------------------------------------------------------------
    public function destroy(Request $request, string $id): JsonResponse
    {
        $vehicle = $request->user()->vehicles()->find($id);

        if (! $vehicle) {
            return response()->json([
                'message' => 'Kendaraan tidak ditemukan.',
            ], 404);
        }

        $vehicle->delete();

        return response()->json(null, 204);
    }
}
