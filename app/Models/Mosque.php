<?php

namespace App\Models;

use App\Models\Traits\HasRouteKey;
use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    use HasRouteKey;
    
    protected $guarded = [];
}
