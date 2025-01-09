<?php

namespace App\Http\Controllers;

use App\Http\Transformers\BookCategoryIndexTransformer;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    public function index()
    {
        $query = BookCategory::with('translation')->get();

        return responder()->success($query, BookCategoryIndexTransformer::class)->respond();
    }
}
