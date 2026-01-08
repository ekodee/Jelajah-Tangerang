<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'required|string|max:500',
            // Validasi: Salah satu HARUS diisi (destination_id ATAU article_id)
            'destination_id' => 'required_without:article_id|nullable|exists:destinations,id',
            'article_id'     => 'required_without:destination_id|nullable|exists:articles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review = Review::create([
            'user_id'        => $request->user()->id,
            'destination_id' => $request->destination_id,
            'article_id'     => $request->article_id, // Simpan ID Artikel
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);
        $review->load('user');

        return response()->json(['message' => 'Ulasan berhasil dikirim', 'data' => $review], 201);
    }
}
