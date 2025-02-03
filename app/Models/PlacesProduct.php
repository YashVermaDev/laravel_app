<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacesProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'thumbnail_image',
        'lat',
        'lng',
        'direction_enum'
    ];
}
