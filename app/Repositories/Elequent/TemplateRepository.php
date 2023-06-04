<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\TemplateRepositoryInterface;
use App\Models\Template;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class TemplateRepository extends BaseRepository  implements TemplateRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Template::class;

    /**
     * [Store Templete]
     *
     * @param array $data
     *
     * @return Templete $templete
     *
     */
    public function store($data){
        Parent::store($data);
    }
}