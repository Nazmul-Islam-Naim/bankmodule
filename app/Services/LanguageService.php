<?php
namespace App\Services;

use Illuminate\Support\Arr;


class LanguageService {

    public $default = 'en';

    protected $languages = ['en','bn'];

    protected $key = 'lang';

    protected $langlist = null;

    public function __construct(  )
    {
        $this->langlist = new JsonService('json/Language');
    } 


    public function getAvailableLanguages(){
        return  $this->langlist->whereIN('code',$this->languages)->values();
    }

    public function getAvailableLanguagesCode(){
        return $this->langlist->whereIN('code',$this->languages)->pluck('code')->toArray();
    }

    public function getAvailableLanguagesName($param){
        return $this->langlist->whereIN('code',$this->languages)->pluck($param)->toArray();
    }

    public function setLocale($code){
        if(Arr::has($this->languages, $code)){
            config(['app.locale'=>$code]);
        }
    }

    public function setLocalFromRequest($request){
        $code = $request->query($this->key);

        if (empty($code)) {
            $code = $request->header($this->key, '');
        }

        if($code && $this->getLocale() != $code){
            $this->setLocale($code);
        }
    }

    public function getLocale(){
        return config('app.locale');
    }

    public function getTranslation(){
        return (new JsonService('translations/'.$this->getLocale()))->content();
    }

    public static  function instance()
    {
       return  app()->make(Self::class);
    }
}