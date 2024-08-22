<?php

namespace App\Http\Requests;

use App\Rules\ValidGenre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreFilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $contentType = $this->header('Content-Type');
        if (strpos($contentType, 'multipart/form-data') === false) {
            return false;
        }
        return true;
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
            'genre' => ['required', 'array','distinct','min:1'],
            'genre.*' => ['string','max:255'],
            'release_year' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
            'video' => $videoConstraint,
            'cover_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return[
            'genres.*.in' => 'One or more input genres are invalid',
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors(),
            'data' => null,
        ], 422));
    }
}
