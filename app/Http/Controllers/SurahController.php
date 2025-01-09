<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurahAyahsRequest;
use App\Http\Requests\SurahIndexRequest;
use App\Http\Transformers\SurahAyahsTransformer;
use App\Http\Transformers\SurahIndexTransformer;
use App\Models\Ayah;
use App\Models\Surah;
use App\Models\Translator;

class SurahController extends Controller
{
    public function index(SurahIndexRequest $request)
    {
        return responder()->success(Surah::with('translation')->get(), SurahIndexTransformer::class)->respond();
    }

    public function ayahs(SurahAyahsRequest $request, int $surahId)
    {
        $query = Ayah::query()->where('surah_id', $surahId);

        if ($request->translator_id) {
            $query->with(['translations' => fn ($query) => $query->where('translator_id', $request->translator_id)]);
        } 

        return responder()->success($query->get(), new SurahAyahsTransformer($request->fields ?? []))->respond();
    }

    public function translators()
    {
        return responder()->success(Translator::cursorPaginate(15))->respond();
    }
}
