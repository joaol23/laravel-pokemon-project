<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(request()->route()->user, 'id')
            ],
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
