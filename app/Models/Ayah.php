<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayah extends Model
{
    protected $guarded = [];

    /**
     * Get the surah that owns the ayah.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function surah()
    {
        return $this->belongsTo(Surah::class);
    }

    public function translations()
    {
        return $this->hasMany(AyahTranslation::class);
    }

    public function kalimahs()
    {
        return $this->hasMany(Kalimah::class);
    }
}
