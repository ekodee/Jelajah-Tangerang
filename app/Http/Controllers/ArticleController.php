<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        // Mengambil data artikel terbaru + pagination
        $articles = Article::with('user')->latest()->paginate(10);
        return view('article.index', compact('articles'));
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|max:200',
            'content'   => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Upload Thumbnail
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        Article::create([
            'user_id'      => Auth::id(), // Mengambil ID user yang login
            'title'        => $request->title,
            'slug'         => Str::slug($request->title), // Generate slug otomatis
            'content'      => $request->content,
            'thumbnail'    => $thumbnailPath,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'     => 'required|max:200',
            'content'   => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'content'      => $request->content,
            'published_at' => $request->published_at,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($data);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $artikel)
    {
        if ($artikel->thumbnail && Storage::disk('public')->exists($artikel->thumbnail)) {
            Storage::disk('public')->delete($artikel->thumbnail);
        }

        $artikel->delete();

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}
