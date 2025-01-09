<?php

namespace App\Models;

use App\Models\Traits\HasRouteKey;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasRouteKey;
    
    protected $guarded = [];


    protected $casts = [
        'pages' => 'array',
    ];

    /**
     * Get the ayahs for the surah.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ayahs()
    {
        return $this->hasMany(Ayah::class);
    }

    /**
     * Get the translation for the surah.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function translation()
    {
        return $this->hasOne(SurahTranslation::class)->where('lang', app()->getLocale());
    }
}
