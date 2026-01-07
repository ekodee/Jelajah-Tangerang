<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->get();

        $data = $destinations->map(function ($item) {
            return [
                'id'          => $item->id,
                'slug'        => $item->slug,
                'name'        => $item->name,
                'category'    => $item->category->name ?? 'Umum',
                'image'       => Str::startsWith($item->photo, 'http')
                    ? $item->photo
                    : asset('storage/' . $item->photo),
                'lat'         => (float) $item->latitude,
                'lng'         => (float) $item->longitude,
                'description' => $item->description,
                'address'     => $item->address,
                'openTime'    => $item->open_hours,
                'rating'      => $item->reviews_avg_rating ? (float) number_format($item->reviews_avg_rating, 1) : 0,
                'reviewCount' => $item->reviews_count,
                'price'      => $item->ticket_price ?? 'Gratis',
                'facilities' => $item->facilities ? array_map('trim', explode(',', $item->facilities)) : [],
            ];
        });

        return response()->json($data);
    }

    public function show($slug)
    {
        $item = Destination::with(['category', 'reviews.user'])
            ->withAvg('reviews', 'rating')
            ->where('slug', $slug)
            ->first();

        if (!$item) {
            return response()->json(['message' => 'Destinasi tidak ditemukan'], 404);
        }

        $reviewsList = $item->reviews->map(function ($review) {
            return [
                'id'      => $review->id,
                'user'    => $review->user->name,
                'rating'  => $review->rating,
                'comment' => $review->comment,
                'date'    => $review->created_at->format('d M Y'),
            ];
        });

        return response()->json([
            'id'          => $item->id,
            'slug'        => $item->slug,
            'name'        => $item->name,
            'category'    => $item->category->name ?? 'Umum',
            'image'       => Str::startsWith($item->photo, 'http')
                ? $item->photo
                : asset('storage/' . $item->photo),
            'lat'         => (float) $item->latitude,
            'lng'         => (float) $item->longitude,
            'description' => $item->description,
            'address'     => $item->address,
            'openTime'    => $item->open_hours,
            'price'       => 'Lihat di lokasi',
            'rating'      => $item->reviews_avg_rating ? (float) number_format($item->reviews_avg_rating, 1) : 0,
            'facilities'  => ['Parkir', 'Toilet', 'Musholla'],
            'reviews'     => $reviewsList,
            'price'      => $item->ticket_price ?? 'Gratis',
            'facilities' => $item->facilities ? array_map('trim', explode(',', $item->facilities)) : [],
        ]);
    }
}
