<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with('category')->latest()->paginate(10);
        return view('destination.index', compact('destinations'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('destination.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:150|unique:destinations,name',
            'description' => 'required',
            'address'     => 'required',
            'open_hours'  => 'required|max:100',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'photo'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'ticket_price' => 'required|string|max:150',
            'facilities'   => 'nullable|string',
        ]);

        $photoPath = $request->file('photo')->store('destinations', 'public');

        Destination::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'address'     => $request->address,
            'open_hours'  => $request->open_hours,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'photo'       => $photoPath,
            'ticket_price' => $request->ticket_price,
            'facilities'   => $request->facilities,
        ]);

        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil ditambahkan');
    }

    public function edit(Destination $destinasi)
    {
        $categories = Category::all();
        return view('destination.edit', compact('destinasi', 'categories'));
    }

    public function update(Request $request, Destination $destinasi)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:150|unique:destinations,name,' . $destinasi->id,
            'description' => 'required',
            'address'     => 'required',
            'open_hours'  => 'required|max:100',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ticket_price' => 'required|string|max:150',
            'facilities'   => 'nullable|string',
        ]);

        $data = $request->except(['photo', '_token', '_method']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('photo')) {
            if ($destinasi->photo && !Str::startsWith($destinasi->photo, 'http')) {
                if (Storage::disk('public')->exists($destinasi->photo)) {
                    Storage::disk('public')->delete($destinasi->photo);
                }
            }
            $data['photo'] = $request->file('photo')->store('destinations', 'public');
        }

        $destinasi->update($data);

        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil diperbarui');
    }

    public function destroy(Destination $destinasi)
    {
        if ($destinasi->photo && !Str::startsWith($destinasi->photo, 'http')) {
            if (Storage::disk('public')->exists($destinasi->photo)) {
                Storage::disk('public')->delete($destinasi->photo);
            }
        }

        $destinasi->delete();
        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil dihapus');
    }
}
