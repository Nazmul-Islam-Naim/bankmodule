<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\ServiceWarrantyRepositoryInterface;
use App\Helpers\Helper;
use App\Models\ServiceWarranty;
use App\Traits\TranslationRepositoryTrait;
use Illuminate\Support\Arr;

class ServiceWarrantyRepository extends BaseRepository  implements ServiceWarrantyRepositoryInterface
{
    use TranslationRepositoryTrait;

    public $model = ServiceWarranty::class;


    /**
     * register
     *
     * @param  mixed $data
     * @return void
     */
    public function registration($data)
    {
        return Parent::store($data);
    }

    /**
     * [Store Admins]
     *
     * @param array $data
     *
     * @return Admin $admin
     *
     */
    public function store($data)
    {
        $translations = Arr::pull($data, 'translations');
        return tap(Parent::store($data), function ($model) use ($data, $translations) {
            if ($translations) {
                foreach ($translations as $translation) {
                    $model->translations()->create($translation);
                }
            }

            if (Arr::has($data, 'logo')) {
                $model->logo()->create($data['logo']);
            }
        });
    }

    /**
     * [Update Admins]
     *
     * @param array $data
     *
     * @return Admin $admin
     *
     */
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
