<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\AccountTypeRepositoryInterface;
use App\Models\AccountType;
class AccountTypeRepository extends BaseRepository  implements AccountTypeRepositoryInterface
{

    public $model = AccountType::class;

        /**
     * [Store AccountType]
     *
     * @param array $data
     *
     * @return AccountType $accountType
     *
     */

     public function store($data)
     {
         $model = Parent::store($data);
     }

     
    /**
     * [Update AccountType]
     *
     * @param array $data
     *
     * @return AccountType $accountType
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
