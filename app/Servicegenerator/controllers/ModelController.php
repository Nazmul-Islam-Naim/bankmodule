<?php

namespace App\Servicegenerator\controllers;

use App\Traits\StubTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use Services\Commands\Traits\StubHandler;

class ModelController extends Command
{
    use StubTrait;

    public $name;
    public $files;
    public $items;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct( $name)
    {
        $this->name=$name;
        $this->files = new Filesystem();
        $this->items=[
            "model"=>[
                "dir"=>app_path('Models/'),
                "file"=>$this->getStubVariables()['CLASS_NAME'] .'.php'
            ],
        ];
    }


    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath($item)
    {
        return app_path('Servicegenerator/stubs/model/').$item.'.stub';
    }

}
