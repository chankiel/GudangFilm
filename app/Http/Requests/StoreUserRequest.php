<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:255|min:3',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'balance' => 'nullable|numeric|min:0',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ]
        ]; 
    }

    public function messages(): array{
        return [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',
            'password.regex:/[a-z]/' => 'The password must contain at least one lowercase letter.',
            'password.regex:/[A-Z]/' => 'The password must contain at least one uppercase letter.',
            'password.regex:/[0-9]/' => 'The password must contain at least one digit.',
            'password.regex:/[@$!%*?&]/' => 'The password must contain at least one special character (@, $, !, %, *, ?, &).',
        ];
    }

}
