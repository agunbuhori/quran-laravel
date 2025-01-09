<?php

namespace App\Models;

use App\Models\Traits\HasRouteKey;
use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    use HasRouteKey;
    
    protected $guarded = [];

    /**
     * Get the translation for the surah.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function translation()
    {
        return $this->hasOne(BookCategoryTranslation::class)->where('lang', app()->getLocale());
    }

    /**
     * Get the books for the category.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(BookCategoryTranslation::class);
    }
}
