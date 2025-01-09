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
            $data[$field] = $this->getData($field, $ayah);
        }

        return $data;
    }

    private function getData($field, Ayah $ayah)
    {
        return match ($field) {
            'translation' =>  $ayah->translations[0]?->translation ?? null,
            'words' => $ayah->kalimahs->map(fn ($kalimah) => (new AyahKalimahsTransformer())->transform($kalimah)),
            default => $ayah->{$field},
        };
    }
}