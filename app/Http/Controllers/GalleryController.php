<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::latest()->get();
        return view('user.gallery', compact('images'));
    }
}
