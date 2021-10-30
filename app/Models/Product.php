<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['image_url'];

    function getImageUrlAttribute(?array $value) : array
    {
        if (empty($value)) {
            return [];
        }
        return array_map(function ($img) {
            return \Storage::disk('cloudinary')->url($img);
        }, $value);
    }

}
