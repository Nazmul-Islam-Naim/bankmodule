<?php

namespace App\Log\Services;

use App\Log\Template\Template;


class LogService extends Template
{

    /**
     * [Description for set]
     *
     * @return [type]
     * 
     */
    public function set(Array $array){
        if(array_key_exists('template',$array)){
            $template=$this->templates[$array['template']];
            if(count(array_diff($template['validations'],array_keys($array)))<1){
                $method=$array['template'].'Set';
                $this->$method( ...array_values(array_intersect_key($array,array_flip($template['validations']))));
                $class=$template['provider'];
                $method=$array['template'].'Get';
                (new $class())->set($this->$method());
            };
        }
    }

    
}