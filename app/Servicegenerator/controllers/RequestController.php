<?php

namespace App\Servicegenerator\controllers;

use App\Traits\StubTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Services\Commands\Traits\StubHandler;

class RequestController extends Command
{
    use StubTrait;

    public $name;
    public $files;
    public $items;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct($name)
    {
        $this->name=$name;
        $this->files = new Filesystem();
        $this->items=[
            "form"=>[
                "dir"=>app_path('Http/Requests/'.$this->getStubVariables()['PLURAL_NAME']),
                "file"=>'CreateRequest.php',
                "base"=>"Create",
            ],
            "form"=>[
                "dir"=>app_path('Contracts/Requests/'.$this->getStubVariables()['PLURAL_NAME']),
                "file"=>'UpdateRequest.php',
                "base"=>"Update",
            ],
        ];
    }

      /**
    **
    * Map the stub variables present in stub to its value
    *
    * @return array
    *
    */
   public function getStubVariables($path=null)
   {
       return [
           'CLASS_NAME'         => $this->getSingularClassName($this->name),
           'PLURAL_NAME'        => Pluralizer::plural($this->getSingularClassName($this->name)),
           'NAME'               => lcfirst($this->getSingularClassName($this->name)),
           'LOWER_PLURAL_NAME'  => lcfirst(Pluralizer::plural($this->getSingularClassName($this->name))),
           "BASE"               => $path?$path['base']:'BASE'
       ];
   }


    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath($item)
    {
        return app_path('Servicegenerator/stubs/requests/').$item.'.stub';
    }

}
