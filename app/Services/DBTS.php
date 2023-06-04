<?php

namespace App\Services;

use App\Actions\DbTransaction;
use App\Actions\FileManager;
use BadMethodCallException;
use Illuminate\Support\Facades\DB;

class DBTS
{
    
        
    /**
     * instance
     *
     * @var mixed
     */
    protected $instance;

        
    /**
     * commitable
     *
     * @var mixed
     */
    protected $commitable;

        
    /**
     * rollbackable
     *
     * @var mixed
     */
    protected $rollbackable;

    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $transaction = app()->make(DbTransaction::class);

        if(! $transaction->isExist()){
            $this->instance = $transaction;
            $transaction->setTransaction();
        }
    }
    
    
    /**
     * begin
     *
     * @return void
     */
    public function DBbegin(){
        if($this->instance){
            DB::beginTransaction();
            $this->setValus();
        }
    }
    
    /**
     * commit
     *
     * @return void
     */
    public function commit(){
        if($this->commitable){
            DB::commit();
        }
    }
    
    /**
     * rollback
     *
     * @return void
     */
    public function rollback(){
        if($this->rollbackable){
            DB::rollBack();
            (app()->make(FileManager::class))->unlink();
        }
    }

    
    /**
     * setValus
     *
     * @return void
     */
    private function setValus(){
        $this->commitable = true;
        $this->rollbackable = true;
    }

    
    /**
     * __callStatic
     *
     * @param  mixed $name
     * @param  mixed $arguments
     * @return void
     */
    static function __callStatic($name, $arguments)
    {
        if($name ==='begin'){
            $name = 'DB'.$name;
            $self = new static();
            $self->DBbegin(...$arguments);
            return $self;
        }

        throw new BadMethodCallException();
    }
}