<?php

namespace App\Traits;

use App\Services\LanguageService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait TranslationRepositoryTrait
{

    public $translateModel;
    public $translationModel;
    public $translateId;

    /**
     * [Check translation is base or not]
     *
     * @param object $instance
     *
     * @return Boolean $boolean
     *
     */
    public function isBase($instance)
    {
        return $instance->local === LanguageService::instance()->default;
    }

    /**
     * [Get base translation object]
     *
     * @param object $instance
     *
     * @return Object $instance
     *
     */
    public function getBase($instance)
    {
        return $instance->translations->where('local' === LanguageService::instance()->default);
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
        return tap(Parent::store($data), function ($model) use ($translations) {
            foreach ($translations as $translation) {
                $model->translations()->create($translation);
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
        return tap(Parent::update($identifier, $data, $options), function ($model) use ($translations) {
            $this->deleteTranslation($model, $translations);
            foreach ($translations as $translation) {
                $model->translations()->updateOrCreate(['local' => Arr::pull($translation, 'local')], $translation);
            }
        });
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param mixed $data
     * @return void
     */
    public function deleteTranslation($obj, $translations)
    {
        $obj->translations()->whereNotIn('local', array_map(fn ($lang) => $lang['local'], $translations))->delete();
    }
}
