<?php

namespace App\Log\Actions;

trait LoginAction 
{
    

    /**
     * [Description for userAction]
     *
     * @return [type]
     * 
     */
    protected function loginActionGet()
    {
        return [
            'type'=>$this->type,
            'info'=>[
                'ip'=>$this->ip,
                'agent'=>$this->agent,
                'username'=>$this->username,
                'message'=>$this->message,
                'status'=>$this->status
            ]
        ];
    }

    /**
     * [Description for userActionSet]
     *
     * @return [type]
     * 
     */
    protected function loginActionSet($type,$message,$ip,$agent,$username,$status){
        $this->setType($type)
        ->setMessage($message)
        ->setAgent($agent)
        ->setIp($ip)
        ->setUsername($username)
        ->setStatus($status);
    }

}