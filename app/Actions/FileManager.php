<?php

namespace App\Actions;

class FileManager{

    public $instances = [];

    
    /**
     * store
     *
     * @param  mixed $instance
     * @return void
     */
    public function store($instance){
       array_push($this->instances, $instance);
    }


    public function unlink(){
        foreach($this->instances as $instance){
            $instance->unlink();
        }
    }

    
}
