<?php

namespace App\Http\Transformers;

use App\Models\Surah;
use Flugg\Responder\Transformers\Transformer;

class SurahIndexTransformer extends Transformer
{
    public function transform(Surah $surah)
    {
        return [
            'id'               => $surah->id,
            'revelation_place' => $surah->revelation_place,
            'revelation_order' => $surah->revelation_order,
            'bismillah_pre'    => $surah->bismillah_pre,
            'name_simple'      => $surah->name_simple,
            'name_complex'     => $surah->name_complex,
            'name_arabic'      => $surah->name_arabic,
            'ayahs_count'      => $surah->ayahs_count,
            'pages'            => $surah->pages,
            'translation'      => $surah->translation?->name
        ];
    }
}