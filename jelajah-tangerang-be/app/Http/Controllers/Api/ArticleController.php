<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['user', 'category'])->latest()->get();

        $data = $articles->map(function ($article) {
            return [
                'id'          => $article->id,
                'slug'        => $article->slug, // TAMBAHAN: Slug dikirim di list
                'title'       => $article->title,
                'summary'     => Str::limit(strip_tags($article->content), 150),
                'image'       => Str::startsWith($article->thumbnail, 'http') 
                                    ? $article->thumbnail 
                                    : asset('storage/' . $article->thumbnail),
                'category'    => $article->category->name ?? 'Umum',
                'date'        => $article->created_at->format('d M Y'),
                'author'      => $article->user->name ?? 'Admin',
            ];
        });

        return response()->json($data);
    }

    // Ubah parameter jadi $slug
    public function show($slug)
    {
        // Cari berdasarkan slug
        $article = Article::with(['user', 'category'])
            ->where('slug', $slug)
            ->first();

        if (!$article) {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }

        return response()->json([
            'id'          => $article->id,
            'slug'        => $article->slug,
            'title'       => $article->title,
            'summary'     => Str::limit(strip_tags($article->content), 150),
            'image'       => Str::startsWith($article->thumbnail, 'http') 
                                ? $article->thumbnail 
                                : asset('storage/' . $article->thumbnail),
            'category'    => $article->category->name ?? 'Umum',
            'date'        => $article->created_at->format('d M Y'),
            'author'      => $article->user->name ?? 'Admin',
            'fullContent' => $article->content, 
        ]);
    }
}