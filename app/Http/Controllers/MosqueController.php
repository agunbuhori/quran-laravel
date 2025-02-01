<?php

namespace App\Http\Controllers;

use App\Models\Mosque;
use App\Transformers\MosqueTransformer;
use Illuminate\Http\Request;

class MosqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return responder()->success(Mosque::simplePaginate(request()->get('per_page', 15)), MosqueTransformer::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosque $mosque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosque $mosque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosque $mosque)
    {
        //
    }
}
