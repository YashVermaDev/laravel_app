<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        
        'published_at',
        'featured_image',
        'meta_title',
        'meta_description',
        'is_published',
        'views_count',
    ];

    protected $dates = ['published_at'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
