<?php

namespace App\Traits;

use App\Services\DBTS;

trait DBTSTRAIT
{
    protected $transactionInstance;
    
    /**
     * begin
     *
     * @return void
     */
    protected function begin(){
        $this->transactionInstance = DBTS::begin();
    }
    
    /**
     * commit
     *
     * @return void
     */
    protected function commit(){
        $this->transactionInstance->commit();
    }
    
    /**
     * rollback
     *
     * @return void
     */
    protected function rollback(){
        $this->transactionInstance->rollback();
    }
}