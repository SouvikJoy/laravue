<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $title
 * @property mixed $content
 * @method static findOrFail($id)
 * @method static find($id)
 * @method static orderBy(string $string, string $string1)
 * @method static updateOrCreate(string[] $array, string[] $array1)
 */
class SiteOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'type'
    ];

}
