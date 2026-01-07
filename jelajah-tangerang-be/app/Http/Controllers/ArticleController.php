<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['user', 'category'])->latest()->paginate(10);
        return view('article.index', compact('articles'));
    }

    public function create()
    {
        // Ambil data kategori untuk dropdown
        $categories = Category::all();
        return view('article.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:200',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required',
            'thumbnail'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        Article::create([
            'user_id'      => Auth::id(),
            // SIMPAN ID KATEGORI
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'content'      => $request->content,
            'thumbnail'    => $thumbnailPath,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(Article $artikel)
    {
        $categories = Category::all();
        return view('article.edit', compact('artikel', 'categories'));
    }

    public function update(Request $request, Article $artikel)
    {
        $request->validate([
            'title'       => 'required|max:200',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'content'      => $request->content,
            'published_at' => $request->published_at,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($artikel->thumbnail && !Str::startsWith($artikel->thumbnail, 'http')) {
                if (Storage::disk('public')->exists($artikel->thumbnail)) {
                    Storage::disk('public')->delete($artikel->thumbnail);
                }
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $artikel->update($data);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $artikel)
    {
        if ($artikel->thumbnail && !Str::startsWith($artikel->thumbnail, 'http')) {
            if (Storage::disk('public')->exists($artikel->thumbnail)) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
        }

        $artikel->delete();

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dihapus');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array(strtolower($file->getClientOriginalExtension()), $validExtensions)) {
                return response()->json(['error' => 'Format file tidak valid.'], 400);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('article-content', $filename, 'public');

            return response()->json(['url' => asset('storage/' . $path)]);
        }

        return response()->json(['error' => 'Tidak ada file yang diunggah.'], 400);
    }
}
