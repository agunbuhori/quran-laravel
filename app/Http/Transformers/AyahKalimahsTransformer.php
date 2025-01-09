<?php

namespace App\Http\Transformers;

use App\Models\Kalimah;
use Flugg\Responder\Transformers\Transformer;

class AyahKalimahsTransformer extends Transformer
{
    public function __construct(private array $fields = [])
    {}

    public function transform(Kalimah $ayah)
    {
        return [
            'position' => $ayah->position
        ];
    }
}