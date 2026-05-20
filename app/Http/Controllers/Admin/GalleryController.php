<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.gallery', ['images' => GalleryImage::latest()->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:4096',
        ]);

        $file = $request->file('image');
        $name = Str::random(8) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
        $file->storeAs('gallery', $name, 'public');
        GalleryImage::create(['image' => $name]);

        return redirect()->route('admin.gallery.index')->with('success', 'Image uploaded.');
    }

    public function destroy(GalleryImage $image)
    {
        $image->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Image deleted.');
    }
}
