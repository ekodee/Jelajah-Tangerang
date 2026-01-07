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
        // Load relasi User dan Category
        $articles = Article::with(['user', 'category'])->latest()->get();

        $data = $articles->map(function ($article) {
            return [
                'id'          => $article->id,
                'title'       => $article->title,
                'summary'     => Str::limit(strip_tags($article->content), 150),
                'image'       => asset('storage/' . $article->thumbnail),
                'category'    => $article->category->name ?? 'Umum',
                'date'        => $article->created_at->format('d M Y'),
                'author'      => $article->user->name ?? 'Admin',
            ];
        });

        return response()->json($data);
    }

    public function show($id)
    {
        $article = Article::with(['user', 'category'])->find($id);

        if (!$article) {
            return response()->json(['message' => 'Artikel tidak ditemukan'], 404);
        }

        return response()->json([
            'id'          => $article->id,
            'title'       => $article->title,
            'summary'     => Str::limit(strip_tags($article->content), 150),
            'image'       => asset('storage/' . $article->thumbnail),
            'category'    => $article->category->name ?? 'Umum',
            'date'        => $article->created_at->format('d M Y'),
            'author'      => $article->user->name ?? 'Admin',
            'fullContent' => $article->content, 
        ]);
    }
}
