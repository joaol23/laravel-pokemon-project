<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileImageRequest extends FormRequest
{
    private int $SIZE_KB = 3072; //3 Mb's

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "photo" => "required|max:{$this->SIZE_KB}|mimes:jpeg,png,jpg,gif"
        ];
    }
}
