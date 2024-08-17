<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmGenre extends Model
{
    use HasFactory;
    protected $table = 'film_genres';

    public function film(){
        return $this->belongsTo(Film::class,'film_id');
    }
}
