<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\PropertiesParamsRepositoryInterface;
use App\Models\PropertiesParams;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class PropertiesParamsRepository extends BaseRepository  implements PropertiesParamsRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = PropertiesParams::class;

    /**
     * [Store PropertiesParams]
     *
     * @param array $data
     *
     * @return PropertiesParams $propertiesParams
     *
     */
    public function store($data){
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::store($data), function($brnad) use($translations){
            foreach($translations as $translation){
            $brnad->translations()->create($translation);
            }
        });
    }
}