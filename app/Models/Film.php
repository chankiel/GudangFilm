<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'slug',
    ];

    public static function genreList()
    {
        return ['Action',
        'Adventure',
        'Comedy',
        'Drama',
        'Fantasy',
        'Horror',
        'Science Fiction',
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

    public static function createFilm($data){
        $genres = $data['genres'];
        unset($data['genres']);
        $film = Film::create($data);
        foreach($genres as $genre){
            DB::table('film_genres')->insert([
                'film_id' => $film->id,
                'genre' => $genre,
            ]);
        }
        return $film;
    }

    public function genres(){
        return $this->hasMany(FilmGenre::class,'film_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
