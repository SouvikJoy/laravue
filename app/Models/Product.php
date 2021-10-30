<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail($id)
 * @method static find($id)
 * @method static updateOrCreate(string[] $array, array $array1)
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'brief',
        'description',
        'materials',
        'colors',
        'sizes',
        'price',
        'featured_image',
        'images',
        'image',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'images'         => 'array',
        'image'          => 'array',
        'materials'      => 'array',
        'colors'         => 'array',
        'sizes'          => 'array',
        'price'          => 'double',
    ];

    /**
     * @param string|null $value
     *
     * @return string|null
     */
    public function getFeaturedImageAttribute (?string $value) : ?string
    {
        if ($value) {
            return \Storage::disk('cloudinary')->url($value);
        }
        return null;
    }


    /**
     * @param array|null $value
     *
     * @return array
     */
    public function getImagesAttribute (?array $value) : array
    {
        if (empty($value)) {
            return [];
        }
        return array_map(function ($img) {
            return \Storage::disk('cloudinary')->url($img);
        }, $value);
    }

}
