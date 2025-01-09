<?php

namespace App\Rules;

use App\Enums\Lang;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TranslationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
    }

    public function passes($attribute, $value)
    {
        return in_array($value, Lang::cases());
    }
}
