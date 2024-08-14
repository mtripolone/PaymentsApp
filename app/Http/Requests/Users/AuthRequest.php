<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
{
    protected Rule $rule;

    public function __construct(Rule $rule)
    {
        parent::__construct();
        $this->rule = $rule;
    }

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'profile' => ['required', $this->rule->in(['user', 'retailer'])],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'document' => ['required', 'string', 'unique:users,document'],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ];
    }
}
