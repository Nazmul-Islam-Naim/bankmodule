<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\BankRepositoryInterface;
use App\Models\Bank;
class BankRepository extends BaseRepository  implements BankRepositoryInterface
{

    public $model = Bank::class;

        /**
     * [Store Bank]
     *
     * @param array $data
     *
     * @return Bank $bank
     *
     */

     public function store($data)
     {
        $model = Parent::store($data);
        
     }

     
    /**
     * [Update Bank]
     *
     * @param array $data
     *
     * @return Bank $bank
     *
     */

     public function update($identifier, $data , $options = [], $callback = null){

        $model = Parent::update($identifier, $data , $options);
        return $model;
    }


    //filters

    public function search($query, $value = null)
    {
        if ($value) {
            $query->where('title','LIKE','%'.$value.'%');
        }
    }

}
