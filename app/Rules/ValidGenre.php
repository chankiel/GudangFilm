<?php

namespace App\Rules;

use App\Models\Film;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidGenre implements ValidationRule
{

    private $validGenres;

    public function __construct()
    {
        $this->validGenres = Film::genreList();
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!is_array($value)){
            $fail('The :attribute must be an array of genres.');
            return;
        }
        
        $invalidGenres = array_diff($value, $this->validGenres);

        if (!empty($invalidGenres)) {
            $invalidGenresList = implode(', ', $invalidGenres);
            $fail("The following genres are invalid: $invalidGenresList.");
        }
    }
}
