<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['item_name', 'price', 'category', 'description', 'image'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public const CATEGORIES = ['Main Courses', 'Desserts', 'Beverages'];

    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        // Images live in public/storage/products after upload, with legacy fallback to public/images
        if (file_exists(public_path('storage/products/' . $this->image))) {
            return asset('storage/products/' . $this->image);
        }
        return asset('images/' . $this->image);
    }
}
