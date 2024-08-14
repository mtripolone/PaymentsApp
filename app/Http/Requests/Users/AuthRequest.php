<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'profile' => ['required', Rule::in(['user', 'retailer'])],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'document' => ['required', 'string', 'unique:users,document'],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ];
    }
}
