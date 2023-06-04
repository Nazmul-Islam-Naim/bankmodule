<?php

namespace App\Actions;

class DbTransaction{
    
    /**
     * transaction
     *
     * @var mixed
     */
    protected $transaction;


   /**
    * isExist
    *
    * @return void
    */
    public function isExist(){
        return $this->transaction !=null;
    }

   
   /**
    * setTransaction
    *
    * @return void
    */
    public function setTransaction(){
        return $this->transaction = !$this->transaction;
    }
    
}
