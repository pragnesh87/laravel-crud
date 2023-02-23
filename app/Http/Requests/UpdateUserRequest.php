<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'phone' => [
                'required',
                Rule::unique('users', 'phone')->ignore($this->id),
            ],
            'gender' => ['required'],
            'image' => ['nullable', 'mimes:png,jpg,bmp,webp'],
            'file' => ['nullable', 'max:10240'],
        ];
    }
}