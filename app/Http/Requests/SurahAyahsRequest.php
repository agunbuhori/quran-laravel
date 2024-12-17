<?php

namespace App\Http\Requests;

use App\Enums\AyahFields;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SurahAyahsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fields'        => ['array', Rule::in(AyahFields::cases())],
            'translator_id' => ['exists:translators,id'],
        ];
    }
}
