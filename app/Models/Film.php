<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'director',
        'release_year',
        'price',
        'duration',
        'video_url',
        'cover_image_url',
    ];

    public static function genreList()
    {
        return ['Action',
        'Adventure',
        'Comedy',
        'Drama',
        'Fantasy',
        'Horror',
        'Sci-Fi',
        'Romance',
        'Thriller',
        'Mystery',
        'Crime',
        'Western',
        'Animation',
        'Documentary',
        'Musical',
        'Historical',
        'War',
        'Biographical',
        'Family',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
