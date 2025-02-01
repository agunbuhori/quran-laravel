<?php

namespace App\Transformers;

use App\Models\Mosque;
use Flugg\Responder\Transformers\Transformer;

class MosqueTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Mosque $mosque
     * @return array
     */
    public function transform(Mosque $mosque)
    {
        return [
            'id' => (int) $mosque->getSecretKey(),
            'name' => $mosque->name,
        ];
    }
}
