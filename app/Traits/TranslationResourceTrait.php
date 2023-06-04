<?php

namespace App\Traits;


trait TranslationResourceTrait {
    
    public function translationresource($translations, $resource){
        $result = [];
        foreach($translations as $translation){
            $result[$translation->local] = new $resource($translation);
        }
        return $result;
    }
}
