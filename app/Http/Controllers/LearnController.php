<?php

namespace App\Http\Controllers;

use App\Http\Transformers\LearnIndexTransformer;
use App\Models\Learn;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function index()
    {
        request()->validate([
            'tag' => ['required', 'string']
        ]);

        $tag = request()->tag;

        $data = Learn::where('tag', $tag)
                        ->when(is_numeric($tag), fn ($query) => $query->orWhere('learn_id', optimus()->decode($tag)))
                        ->get();

        return responder()->success($data, LearnIndexTransformer::class);
    }
}
