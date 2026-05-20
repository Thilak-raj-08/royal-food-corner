<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = ['g1.jpg', 'g3.jpg', 'g4.jpg', 'g5.jpg', 'g6.jpg', 'g7.jpg', 'g8.jpg', 'g9.jpg', 'g10.jpg', 'g11.jpg', 'g12.jpg', 'g13.jpg', 'g14.jpg'];
        foreach ($images as $img) {
            GalleryImage::updateOrCreate(['image' => $img]);
        }
    }
}
