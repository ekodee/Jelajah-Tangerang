<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'destination'])->latest()->paginate(10);
        return view('review.index', compact('reviews'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('review.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'destination_id' => $request->destination_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('review.index')->with('success', 'Review berhasil ditambahkan');
    }

    public function edit(Review $review)
    {
        $destinations = Destination::all();
        return view('review.edit', compact('review', 'destinations'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review->update([
            'destination_id' => $request->destination_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('review.index')->with('success', 'Review berhasil diperbarui');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('review.index')->with('success', 'Review berhasil dihapus');
    }
}
