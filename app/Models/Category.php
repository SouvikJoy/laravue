<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $image
 * @property mixed $title
 * @property mixed $content
 * @property mixed $slug
 * @property mixed $description
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail($id)
 * @method static find($id)
 */
class Category extends Model
{
    use HasFactory;
}
