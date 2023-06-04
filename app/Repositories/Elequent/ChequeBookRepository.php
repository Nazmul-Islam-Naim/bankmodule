<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\ChequeBookRepositoryInterface;
use App\Models\ChequeBook;
class ChequeBookRepository extends BaseRepository  implements ChequeBookRepositoryInterface
{

    public $model = ChequeBook::class;

        /**
     * [Store ChequeBook]
     *
     * @param array $data
     *
     * @return ChequeBook $chequeBook
     *
     */

     public function store($data)
     {
        $model = Parent::store($data);
        
     }

     
    /**
     * [Update ChequeBook]
     *
     * @param array $data
     *
     * @return ChequeBook $chequeBook
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
                        $query ->join('cheque_books', 'banks.id', '=', 'cheque_books.bank_id')
                                ->where('banks.title', 'LIKE', '%'.$value.'%');
                    });
        }
    }

}
