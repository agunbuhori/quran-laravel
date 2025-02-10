<?php

namespace App\Transformers;

use App\Models\Quiz;
use Flugg\Responder\Transformers\Transformer;

class QuizTransformer extends Transformer
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
     * @param  \App\Models\Quiz $quiz
     * @return array
     */
    public function transform(Quiz $quiz)
    {
        return [
            'id' => (int) $quiz->id,
        ];
    }
}
