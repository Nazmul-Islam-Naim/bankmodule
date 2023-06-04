<?php

namespace App\Log\Actions;

trait UserAction 
{
    

    /**
     * [Description for userAction]
     *
     * @return [type]
     * 
     */
    protected function userActionGet()
    {
        return [
            'type'=>$this->type,
            'info'=>[
                'message'=>$this->message,
                'model'=>$this->model,
                'id'=>$this->causerBy,
                'properties'=>$this->properties
            ]
        ];
    }

    /**
     * [Description for userActionSet]
     *
     * @return [type]
     * 
     */
    protected function userActionSet($type,$message,$model,$causerBy,$properties){
        $this->setType($type)
        ->setMessage($message)
        ->setModel($model)
        ->setCauserBy($causerBy)
        ->setProperties($properties);
    }

}