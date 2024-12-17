<?php

namespace App\Http\Requests;

use App\Enums\Lang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SurahIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lang' => ['size:2', Rule::in(Lang::cases())],
        ];
    }
}
