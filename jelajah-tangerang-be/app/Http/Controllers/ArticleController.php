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

    public function edit(Article $artikel)
    {
        return view('article.edit', compact('artikel'));
    }

    public function update(Request $request, Article $artikel)
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
            if ($artikel->thumbnail && Storage::disk('public')->exists($artikel->thumbnail)) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $artikel->update($data);

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

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Validasi ekstensi
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array(strtolower($file->getClientOriginalExtension()), $validExtensions)) {
                return response()->json(['error' => 'Format file tidak valid.'], 400);
            }

            // Simpan gambar ke storage/app/public/article-content
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('article-content', $filename, 'public');

            // Kembalikan URL gambar agar bisa dibaca Summernote
            return response()->json(['url' => asset('storage/' . $path)]);
        }

        return response()->json(['error' => 'Tidak ada file yang diunggah.'], 400);
    }
}
