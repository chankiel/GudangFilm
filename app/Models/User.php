<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'firstname',
        'lastname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bought(): BelongsToMany
    {
        return $this->belongsToMany(Film::class,'film_user');
    }

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Film::class,'wishlist');
    }

    public function rated(): BelongsToMany
    {
        return $this->belongsToMany(Film::class,'ratings')
        ->withPivot('rating');
    }

    public function commented(): BelongsToMany
    {
        return $this->belongsToMany(Film::class,'comments')
        ->withPivot('comment');
    }
}
