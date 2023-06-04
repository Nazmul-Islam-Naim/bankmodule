<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\UnitRepositoryInterface;
use App\Models\Unit;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class UnitRepository extends BaseRepository  implements UnitRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = Unit::class;

    /**
     * [Store Unit]
     *
     * @param array $data
     *
     * @return Unit $unit
     *
     */
    public function store($data)
    {
        return Parent::store($data);
    }

    public function update($identifier, $data, $options = [], $callback = null)
    {
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::update($identifier, $data, $options), function ($model) use ($data, $translations) {

            if ($translations) {
                $this->deleteTranslation($model, $translations);
                foreach ($translations as $translation) {
                    $model->translations()->updateOrCreate(['local' => Arr::pull($translation, 'local')], $translation);
                }
            }
        });
    }


    public function search($query, $value = null)
    {
        if ($value) {
            $query->where("title", "Like", "%" . $value . "%");
        }
    }
}
