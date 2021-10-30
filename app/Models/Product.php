<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail($id)
 * @method static find($id)
 */
class Product extends Model
{
    use HasFactory;
}
