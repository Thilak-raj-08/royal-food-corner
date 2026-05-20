<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['image'];

    public function getImageUrlAttribute(): string
    {
        if (file_exists(public_path('storage/gallery/' . $this->image))) {
            return asset('storage/gallery/' . $this->image);
        }
        return asset('images/' . $this->image);
    }
}
