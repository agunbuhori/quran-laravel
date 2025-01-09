<?php

namespace App\Http\Transformers\Traits;

trait HasTranslation
{
    public function translation(string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations->firstWhere('locale', $locale);
    }
}