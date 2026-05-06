<?php
// phpcs:ignoreFile
namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Requests\Booking\UpdateBookingStatusRequest;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // -------------------------------------------------------------------------
    // POST /api/v1/renter/bookings
    // -------------------------------------------------------------------------
    public function store(StoreBookingRequest $request): JsonResponse
    {
        $vehicle   = Vehicle::where('id', $request->vehicle_id)->first();
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        if (! $vehicle || $vehicle->status !== 'available') {
            return response()->json(['message' => 'Kendaraan tidak tersedia.'], 409);
        }

        if ($this->hasConflict($vehicle->id, $startDate, $endDate)) {
            return response()->json(['message' => 'Jadwal kendaraan sudah dipesan pada tanggal tersebut.'], 409);
        }

        $days    = (int) ((strtotime($endDate) - strtotime($startDate)) / 86400);
        $booking = Booking::create([
            'renter_id'   => $request->user()->id,
            'vehicle_id'  => $vehicle->id,
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'total_price' => $days * $vehicle->daily_rate,
            'status'      => 'pending',
        ]);

        return response()->json([
            'message' => 'Reservasi berhasil dibuat.',
            'data'    => $this->formatBooking($booking),
        ], 201);
    }

    // -------------------------------------------------------------------------
    // GET /api/v1/renter/bookings
    // -------------------------------------------------------------------------
    public function renterIndex(Request $request): JsonResponse
    {
        $bookings = Booking::with('vehicle')
            ->where('renter_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Berhasil mengambil riwayat sewa.',
            'data'    => $bookings->map(fn ($b) => $this->formatBooking($b, withVehicle: true)),
        ], 200);
    }

    // -------------------------------------------------------------------------
    // GET /api/v1/owner/bookings
    // -------------------------------------------------------------------------
    public function ownerIndex(Request $request): JsonResponse
    {
        $ownerId  = $request->user()->id;
        $bookings = Booking::with(['vehicle', 'renter.profile'])
            ->whereHas('vehicle', fn ($q) => $q->where('owner_id', $ownerId))
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Berhasil mengambil daftar pesanan masuk.',
            'data'    => $bookings->map(fn ($b) => $this->formatBooking($b, withVehicle: true, withRenter: true)),
        ], 200);
    }

    // -------------------------------------------------------------------------
    // PATCH /api/v1/owner/bookings/{id}/status
    // -------------------------------------------------------------------------
    public function updateStatus(UpdateBookingStatusRequest $request, string $id): JsonResponse
    {
        $ownerId = $request->user()->id;
        $booking = Booking::whereHas('vehicle', fn ($q) => $q->where('owner_id', $ownerId))
            ->where('id', $id)
            ->first();

        if (! $booking) {
            return response()->json(['message' => 'Booking tidak ditemukan.'], 404);
        }

        $booking->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Status booking berhasil diupdate.',
            'data'    => ['id' => $booking->id, 'status' => $booking->status],
        ], 200);
    }

    // -------------------------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------------------------
    private function hasConflict(int $vehicleId, string $startDate, string $endDate): bool
    {
        return Booking::where('vehicle_id', $vehicleId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '>=', $startDate)
                      ->where('start_date', '<=', $endDate);
                })
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('end_date', '>=', $startDate)
                      ->where('end_date', '<=', $endDate);
                })
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                      ->where('end_date', '>=', $endDate);
                });
            })->exists();
    }

    private function formatBooking(Booking $booking, bool $withVehicle = false, bool $withRenter = false): array
    {
        $data = [
            'id'          => $booking->id,
            'start_date'  => $booking->start_date,
            'end_date'    => $booking->end_date,
            'total_price' => $booking->total_price,
            'status'      => $booking->status,
        ];

        if ($withVehicle && $booking->relationLoaded('vehicle')) {
            $data['vehicle'] = [
                'brand' => $booking->vehicle->brand,
                'model' => $booking->vehicle->model,
            ];
        }

        if ($withRenter && $booking->relationLoaded('renter')) {
            $data['renter'] = [
                'full_name' => $booking->renter?->profile?->full_name,
            ];
        }

        return $data;
    }
}