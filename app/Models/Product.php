<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'item_name', 'price', 'category', 'description', 'image',
        'is_vegetarian', 'spice_level', 'is_featured', 'prep_minutes',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'is_vegetarian' => 'boolean',
        'is_featured'   => 'boolean',
        'prep_minutes'  => 'integer',
    ];

    public const CATEGORIES = ['Main Courses', 'Desserts', 'Beverages'];
    public const SPICE_LEVELS = ['none', 'mild', 'medium', 'hot'];

    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        if (file_exists(public_path('storage/products/' . $this->image))) {
            return asset('storage/products/' . $this->image);
        }
        return asset('images/' . $this->image);
    }
}
