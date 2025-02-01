<?php

namespace App\Transformers;

use App\Models\Ustadz;
use Flugg\Responder\Transformers\Transformer;

class UstadzTransformer extends Transformer
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
     * @param  \App\Models\Ustadz $ustadz
     * @return array
     */
    public function transform(Ustadz $ustadz)
    {
        return [
            'id'                => (int) $ustadz->getSecretKey(),
            'name'              => $this->getNameWithDegree($ustadz),
            'total_subscribers' => $ustadz->total_subscribers
        ];
    }

    public function getNameWithDegree(Ustadz $ustadz)
    {
        return ($ustadz->front_degree ? "{$ustadz->front_degree} " : null)
            .$ustadz->name
            .($ustadz->back_degree ? ", {$ustadz->back_degree}" : null);

    }
}
