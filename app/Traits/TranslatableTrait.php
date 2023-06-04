<?php

namespace App\Traits;

use App\Services\LanguageService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait TranslatableTrait
{

    public function translateable()
    {
        return $this->hasOne($this->getTranslationModel())
            ->where('local', $this->localeOrFallback());
    }

    public function translations()
    {
        return $this->hasMany($this->getTranslationModel());
    }

    public function availabletanslations()
    {
        $language = LanguageService::instance();
        return $this->translations()->wherein('local', $language->getAvailableLanguagesCode())->orderBy(DB::raw("CASE WHEN local = '" . $language->default . "' THEN 0 ELSE 1 END"))->get();
    }

    public function getTranslationModel(): string
    {
        $modelName = get_class($this) . 'Translation';
        return $modelName;
    }

    public function localeOrFallback()
    {
        return LanguageService::instance()->getLocale();
    }

    public function translation()
    {
        return $this->translateable ?? $this->translations()->where('local', LanguageService::instance()->default)->first();
    }

    public function __get($key)
    {
        if ($key == "translation") {
            return $this->$key();
        } else {
            return parent::__get($key);
        }
    }
}
