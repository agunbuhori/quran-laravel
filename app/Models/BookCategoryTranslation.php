<?php

namespace App\Models;

use App\Models\Traits\HasRouteKey;
use Illuminate\Database\Eloquent\Model;

class BookCategoryTranslation extends Model
{
    use HasRouteKey;
    
    protected $guarded = [];

    public $timestamps = false;

    public function bookCategory()
    {
        return $this->belongsTo(BookCategory::class);
    }
}
