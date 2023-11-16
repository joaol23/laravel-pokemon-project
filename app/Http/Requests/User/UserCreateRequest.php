<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:200',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:64|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            "email.unique" =>  "E-mail já utilizado!",
            "password.confirmed" =>  "As senhas não são as mesmas!"
        ];
    }
}
