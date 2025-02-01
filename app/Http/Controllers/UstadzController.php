<?php

namespace App\Http\Controllers;

use App\Models\Ustadz;
use App\Transformers\UstadzTransformer;
use Illuminate\Http\Request;

class UstadzController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        request()->validate([
            'per_page' => ['min:1', 'max:15']
        ]);

        return responder()->success(Ustadz::simplePaginate(request()->get('per_page', 15)), UstadzTransformer::class);
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
    public function show(Ustadz $ustadz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ustadz $ustadz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ustadz $ustadz)
    {
        //
    }
}
