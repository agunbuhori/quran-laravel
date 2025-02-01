<?php

namespace App\Models;

use App\Models\Traits\HasRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Learn extends Model
{
    /** @use HasFactory<\Database\Factories\LearnFactory> */
    use HasFactory, HasRouteKey;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            
        });
        
        static::updated(function ($model) {
            
        });

    }

    public function learns()
    {
        return $this->hasMany(Learn::class);
    }
}
