<?php

namespace App\Http\Transformers;

use App\Models\BookCategory;
use Flugg\Responder\Transformers\Transformer;

class BookCategoryIndexTransformer extends Transformer
{
    public function transform(BookCategory $bookCategory)
    {
        return [
            'id'   => $bookCategory->getRouteKey(),
            'name' => $bookCategory->translation ? $bookCategory->translation->name : $bookCategory->name,
        ];
    }
}