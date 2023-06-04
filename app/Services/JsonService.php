<?php
namespace App\Services;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class JsonService
{

    protected $jsonpath;

    protected $json;

    protected $filesystem;

    protected $select = null;

    protected $collection = null;

    protected $data = [];


    public function __construct($name, $path=null)
    {   $path = $path?$path:storage_path('/');
        $this->jsonpath = $path;
        $this->json = $name.'.json';
        $this->filesystem = new Filesystem();
    }

    public function  path(){
        return $this->jsonpath.$this->json;
    }

    public function content(){
        if($this->filesystem->exists($this->path())){
            return $this->filesystem->get($this->path());
        }
        throw new FileNotFoundException($this->path().' file doesnt exist');
    }

    public function setData(){
        return $this->data = json_decode($this->content(),true);
    }

    public function pharse(){
        if(! count($this->data)){
            return $this->setData();
        }
        return $this->data;
    }

    private function setSelect($key){
        $this->select = $key;
        return $this;
    }

    private function setCollection(){
        $this->collection = collect($this->pharse());
        return $this;
    }

    public function select($key){
        if(! is_string($key)){
            throw new Exception('select key must be a string');
        }
        if($key){
            $this->setSelect($key);
        }
        throw new Exception('select key required');
    }

    public function get($key = null, $checkselect = false){
        if($key){
            $this->setSelect($key);
        }
        if($checkselect){
            return Arr::get($this->pharse(), $this->select);
        }
        return $this->pharse();
    }

    public function collect(){
        return $this->setCollection()->collection;
    }


    public function __call( string $method , array $arguments ) {
        return $this->setCollection()->collection->$method(...$arguments);
    }
}
