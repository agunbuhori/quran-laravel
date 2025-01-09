<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kalimah extends Model
{
    public function translations()
    {
        return $this->hasMany(KalimahTranslation::class);
    }
}
