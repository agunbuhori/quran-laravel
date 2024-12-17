<?php

namespace App\Http\Transformers;

use App\Models\Ayah;
use Flugg\Responder\Transformers\Transformer;

class SurahAyahsTransformer extends Transformer
{
    public function __construct(private array $fields = [])
    {}

    public function transform(Ayah $ayah)
    {
        $data = [
            'ayah_number'        => $ayah->ayah_number,
            'hizb_number'        => $ayah->hizb_number,
            'juz_number'         => $ayah->juz_number,
            'page_number'        => $ayah->page_number,
            'rub_el_hizb_number' => $ayah->rub_el_hizb_number,
        ];

        foreach ($this->fields as $field) {
            $data[$field] = $ayah->{$field};
        }

        if ($ayah->relationLoaded('translations')) {
            $data['translation'] = $ayah->translations[0]?->translation ?? null;
        }

        return $data;
    }
}