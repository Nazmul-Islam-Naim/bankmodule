<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\QuestionAnswerRepositoryInterface;
use App\Models\QuestionAnswer;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class QuestionAnswerRepository extends BaseRepository  implements QuestionAnswerRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = QuestionAnswer::class;

    /**
     * [Store QuestionAnswer]
     *
     * @param array $data
     *
     * @return QuestionAnswer $questionAnswer
     *
     */
    public function store($data){
        return Parent::store($data);
    }
}