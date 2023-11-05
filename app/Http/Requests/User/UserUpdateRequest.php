<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            "email" => [
                "unique" => "E-mail já utilizado!"
            ],
        ];
    }
}
