<?php

namespace App\Log\Template;

use App\Log\Actions\LoginAction;
use App\Log\Actions\UserAction;
use App\Log\Drivers\Database;

class Template
{
    use UserAction;
    use LoginAction;

    /**
     * [Description for $type]
     *
     * @var [type]
     */
    protected $type;
    /**
     * [Description for $message]
     *
     * @var [type]
     */
    protected $message;
    /**
     * [Description for $model]
     *
     * @var [type]
     */
    protected $model;
    /**
     * [Description for $id]
     *
     * @var [type]
     */
    protected $causerBy;

    /**
     * [Description for $id]
     *
     * @var [type]
     */
    protected $properties;

    /**
     * [Description for $username]
     *
     * @var [type]
     */
    protected $username;
    /**
     * [Description for $agent]
     *
     * @var [type]
     */
    protected $agent;
    /**
     * [Description for $ip]
     *
     * @var [type]
     */
    protected $ip;
    /**
     * [Description for $status]
     *
     * @var [type]
     */
    protected $status;

    /**
     * [Description for $templates]
     *
     * @var array
     */
    protected $templates=[

        "userAction"=>[
            'provider'=>Database::class,
            'validations'=>['type','message','model','causer_by','properties']
        ],
        "loginAction"=>[
            'provider'=>\App\Log\Drivers\Gelf::class,
            'validations'=>['type','message','ip','agent','status','username']
        ],

    ];


    /**
     * [Description for setType]
     *
     * @param Array $array
     * 
     * @return [type]
     * 
     */
    private function setType($type){
        $this->type=$type;
        return $this;
    }
    
    /**
     * [Description for setMessage]
     *
     * @param Array $array
     * 
     * @return [type]
     * 
     */
    private function setMessage($message){
        $this->message=$message;
        return $this;
    }

    /**
     * [Description for setModel]
     *
     * @param Array $array
     * 
     * @return [type]
     * 
     */
    private function setModel($model){
        $this->model=$model;
        return $this;
    }

    /**
     * [Description for setId]
     *
     * @param Array $array
     * 
     * @return [type]
     * 
     */
    private function setCauserBy($causerBy){
        $this->causerBy=$causerBy;
        return $this;
    }

    /**
     * [Description for setProperties]
     *
     * @param mixed $properties
     * 
     * @return [type]
     * 
     */
    private function setProperties($properties){
        $this->properties=$properties;
        return $this;
    }

    /**
     * [Description for setUsername]
     *
     * @param mixed $username
     * 
     * @return [type]
     * 
     */
    private function setUsername($username){
        $this->username=$username;
        return $this;
    }

    /**
     * [Description for setIp]
     *
     * @param mixed $ip
     * 
     * @return [type]
     * 
     */
    private function setIp($ip){
        $this->ip=$ip;
        return $this;
    }

    /**
     * [Description for setStatus]
     *
     * @param mixed $status
     * 
     * @return [type]
     * 
     */
    private function setStatus($status){
        $this->status=$status;
        return $this;
    }

    /**
     * [Description for setAgent]
     *
     * @param mixed $agent
     * 
     * @return [type]
     * 
     */
    private function setAgent($agent){
        $this->agent=$agent;
        return $this;
    }
}