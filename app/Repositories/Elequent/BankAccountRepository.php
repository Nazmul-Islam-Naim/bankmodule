<?php

namespace App\Repositories\Elequent;

use App\Enum\TransactionType;
use App\Contracts\Repositories\BankAccountRepositoryInterface;
use App\Helpers\Helper;
use App\Models\BankAccount;
class BankAccountRepository extends BaseRepository  implements BankAccountRepositoryInterface
{

    public $model = BankAccount::class;

        /**
     * [Store BankAccount]
     *
     * @param array $data
     *
     * @return BankAccount $bankAccount
     *
     */

     public function store($data)
     {
         $model = tap(Parent::store($data), function($model) use ($data){
            $model->transaction()->create([
                'bank_account_id' => $model->id,
                'transaction_type' => TransactionType::getFromName('Opening'),
                'reason' => 'opening balance',
                'amount' => $data['balance'],
                'transaction_date' => $data['opening_date'],
             ]);
         });
     }

     
    /**
     * [Update BankAccount]
     *
     * @param array $data
     *
     * @return BankAccount $bankAccount
     *
     */

     public function update($identifier, $data , $options = [], $callback = null){

        $model = tap(Parent::update($identifier, $data , $options), function($model) use ($data){
            $model->transaction()->update([
                'bank_account_id' => $model->id,
                'transaction_type' => TransactionType::getFromName('Opening'),
                'reason' => 'opening balance',
                'amount' => $data['balance'],
                'transaction_date' => $data['opening_date'],
             ]);
        });

        return $model;
    }


    //filters

    public function search($query, $value = null)
    {
        if ($value) {
            $query->where('account_name','LIKE','%'.$value.'%')
                    ->orWhere('account_number','LIKE','%'.$value.'%')
                    ->orWhere('routing_number','LIKE','%'.$value.'%')
                    ->orWhere('branch','LIKE','%'.$value.'%')
                    ->orWhere(function($query) use ($value) {
                        $query ->join('bank_accounts', 'banks.id', '=', 'bank_accounts.bank_id')
                                ->where('banks.title', 'LIKE', '%'.$value.'%');
                    })
                    ->orWhere(function($query) use ($value) {
                        $query ->join('bank_accounts', 'account_types.id', '=', 'bank_accounts.account_type_id')
                                ->where('account_types.title', 'LIKE', '%'.$value.'%');
                    });
        }
    }

         
    /**
     * [Increment BankAccount balance]
     *
     * @param array $data
     *
     * @return BankAccount $bankAccount
     *
     */

     public function deposit($identifier, $data , $options = [], $callback = null){
        $model = tap($this->model::findOrFail(Helper::decrypt($identifier)), function($model) use ($data){
            $model->increment('balance', $data['amount']);
            $model->transaction()->create([
                'bank_account_id' => $model->id,
                'transaction_type' => TransactionType::getFromName('Deposit'),
                'reason' => 'deposit',
                'amount' => $data['amount'],
                'transaction_date' => $data['transaction_date'],
             ]);
        });
        return $model;
    }

}
