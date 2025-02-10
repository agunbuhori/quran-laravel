<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Audience extends Model
{
    /** @use HasFactory<\Database\Factories\AudienceFactory> */
    use HasFactory;

    protected $guarded = [];

    public function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::title($value)
        );
    }
}
