<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use App\Models\Film;
use Illuminate\Foundation\Http\FormRequest;

class StoreFilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $admin = AuthController::check($this,true,true);
        if($admin){
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   
        $videoConstraint = 'file|mimes:mp4|max:51200';
        if ($this->isMethod('post')) {
            $videoConstraint = $videoConstraint . '|required';
        }

        return [
            'title' => 'required|string|unique:films,title',
            'description' => 'required|string',
            'director' => 'required|string',
            'genres' => ['required', 'array','distinct'],
            'genres.*' => ['required', 'in:' . implode(',', Film::genreList())],
            'release_year' => 'required|numeric',
            'price' => 'numeric',
            'duration' => 'numeric',
            'video' => $videoConstraint,
            'cover_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
