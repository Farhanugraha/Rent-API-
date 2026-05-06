<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SearchVehicleController extends Controller
{
    // -------------------------------------------------------------------------
    // GET /api/v1/renter/vehicles/search?latitude=&longitude=&radius=
    // -------------------------------------------------------------------------
    public function search(SearchVehicleRequest $request): JsonResponse
    {
        $latitude  = (float) $request->latitude;
        $longitude = (float) $request->longitude;
        $radius    = (float) ($request->radius ?? 10);

        $vehicles = DB::table('vehicles')
            ->where('status', 'available')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select([
                'id', 'brand', 'model', 'daily_rate',
                'latitude', 'longitude', 'status',
                DB::raw("(6371 * acos(
                    cos(radians({$latitude})) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians({$longitude})) +
                    sin(radians({$latitude})) *
                    sin(radians(latitude))
                )) AS distance"),
            ])
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

        return response()->json([
            'message' => 'Berhasil mencari kendaraan terdekat.',
            'data'    => $vehicles->map(fn ($vehicle) => [
                'id'         => $vehicle->id,
                'brand'      => $vehicle->brand,
                'model'      => $vehicle->model,
                'daily_rate' => $vehicle->daily_rate,
                'latitude'   => $vehicle->latitude,
                'longitude'  => $vehicle->longitude,
                'status'     => $vehicle->status,
                'distance'   => round($vehicle->distance, 2) . ' km',
            ]),
        ], 200);
    }

    // -------------------------------------------------------------------------
    // GET /api/v1/renter/vehicles/{id}
    // -------------------------------------------------------------------------
    public function show(string $id): JsonResponse
    {
        $vehicle = Vehicle::with('owner.profile')->find($id);

        if (! $vehicle) {
            return response()->json([
                'message' => 'Kendaraan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil detail kendaraan.',
            'data'    => [
                'id'         => $vehicle->id,
                'brand'      => $vehicle->brand,
                'model'      => $vehicle->model,
                'daily_rate' => $vehicle->daily_rate,
                'latitude'   => $vehicle->latitude,
                'longitude'  => $vehicle->longitude,
                'status'     => $vehicle->status,
                'owner'      => [
                    'full_name'           => $vehicle->owner?->profile?->full_name,
                    'verification_status' => $vehicle->owner?->profile?->verification_status,
                ],
            ],
        ], 200);
    }
}