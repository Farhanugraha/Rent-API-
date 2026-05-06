<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    // -------------------------------------------------------------------------
    // POST /api/v1/renter/reviews
    // -------------------------------------------------------------------------
    public function store(StoreReviewRequest $request): JsonResponse
    {
        /** @var Booking|null $booking */
        $booking = Booking::query()
            ->where('id', $request->booking_id)
            ->where('renter_id', $request->user()->id)
            ->where('status', 'completed')
            ->first();

        // Cek booking milik renter & sudah completed
        if (! $booking) {
            return response()->json([
                'message' => 'Booking tidak ditemukan atau belum selesai.',
            ], 400);
        }

        // Cek apakah sudah pernah review
        $alreadyReviewed = Review::query()
            ->where('booking_id', $booking->id)
            ->exists();

        if ($alreadyReviewed) {
            return response()->json([
                'message' => 'Anda sudah memberikan ulasan untuk booking ini.',
            ], 400);
        }

        $review = Review::query()->create([
            'booking_id' => $booking->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return response()->json([
            'message' => 'Ulasan berhasil ditambahkan.',
            'data'    => [
                'id'         => $review->id,
                'booking_id' => $review->booking_id,
                'rating'     => $review->rating,
                'comment'    => $review->comment,
            ],
        ], 201);
    }
}
