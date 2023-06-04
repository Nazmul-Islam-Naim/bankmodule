<?php

namespace App\Services;

use Exception;
use Illuminate\Filesystem\Filesystem;

class TranslationService {

  /**
     * [Description for $file]
     *
     * @var [type]
     */
    private $file;

    /**
     * [Description for $structure]
     *
     * @var [type]
     */
    private $structure;

    /**
     * [Description for $lang]
     *
     * @var [type]
     */
    private $lang;


    public function __construct()
    {
        $this->file=new Filesystem();
        $this->setStructure();
    }


    /**
     * [Description for setStructure]
     *
     * @return [type]
     * 
     */
    private function setStructure(){
        $this->structure=[
            'structure_path'=>storage_path('translations/Structure.json'),
            'lang_path'=>storage_path('translations'),
        ];
        return $this;
    }

    /**
     * [Description for getStructure]
     *
     * @return [type]
     * 
     */
    private function translationGenerate(){
        $structure=$this->file->get($this->structure['structure_path']);
        $file_path=$this->structure['lang_path'].'/'.$this->lang.'.json';
        if($this->file->exists($file_path)){
            $translation=json_decode($this->file->get($file_path),true);
            $structure=json_decode($structure,true);
            $translation=array_diff_key($translation,array_flip(array_diff(array_keys($translation),array_keys($structure))));
            if($keys=array_diff(array_keys($structure),array_keys($translation))){
                foreach($keys as $key){
                    $translation[$key]="";
                }
            }
            $this->file->replace($file_path,json_encode($translation,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }else{
            $this->file->copy($this->structure['structure_path'],$this->structure['lang_path'].'/'.$this->lang.'.json'); 
        }
        try{
          
        }catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }



    /**
     * [Description for publish]
     *
     * 
     * @return [type]
     * 
     */
    public function publish(){
        $languages=LanguageService::instance()->getAvailableLanguagesCode();
        foreach($languages as $language){
            $this->lang=$language;
            $this->translationGenerate();
        }
        try{
         
        }
        catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
   
}