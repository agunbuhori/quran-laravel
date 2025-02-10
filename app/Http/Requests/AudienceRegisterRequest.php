<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudienceRegisterRequest extends FormRequest
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
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'max:100', 'unique:users,email'],
            'gender'   => ['required', 'in:male,female'],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'size:6'],
            'phone'    => ['required', 'string', 'max:14', 'min:9']
        ];
    }
}
