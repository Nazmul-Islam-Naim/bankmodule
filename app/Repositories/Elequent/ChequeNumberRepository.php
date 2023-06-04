<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\ChequeNumberRepositoryInterface;
use App\Models\ChequeNumber;
class ChequeNumberRepository extends BaseRepository  implements ChequeNumberRepositoryInterface
{

    public $model = ChequeNumber::class;

        /**
     * [Store ChequeNumber]
     *
     * @param array $data
     *
     * @return ChequeNumber $chequeNumber
     *
     */

     public function store($data)
     {
        $model = Parent::store($data);
        
     }

     
    /**
     * [Update ChequeNumber]
     *
     * @param array $data
     *
     * @return ChequeNumber $chequeNumber
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
            $query->where('title','LIKE','%'.$value.'%')
                    ->orWhere(function($query) use ($value) {
                        $query ->join('cheque_numbers', 'cheque_books.id', '=', 'cheque_numbers.cheque_book_id')
                                ->where('cheque_books.title', 'LIKE', '%'.$value.'%');
                    });
        }
    }

}
