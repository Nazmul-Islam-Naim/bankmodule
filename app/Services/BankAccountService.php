<?php

namespace App\Services;

use App\Contracts\Repositories\BankAccountRepositoryInterface;
use App\Exceptions\GeneralException;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BankAccountService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Bank Account";

    public function __construct()
    {
        $this->repository = app()->make(BankAccountRepositoryInterface::class);
    }


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
        try {
            $data['bank_id'] = Helper::decrypt(Arr::pull($data, 'bank_id'));
            $data['account_type_id'] = Helper::decrypt(Arr::pull($data, 'account_type_id'));
            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store Bank Account");
        }
    }


    /**
     * [Update BankAccount]
     *
     * @param array $data
     *
     * @return BankAccount $bankAccount
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        try {
            $data['bank_id'] = Helper::decrypt(Arr::pull($data, 'bank_id'));
            $data['account_type_id'] = Helper::decrypt(Arr::pull($data, 'account_type_id'));
            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update Bank Account");
        }
    }

        
    /**
     * updateStatus
     *
     * @param  mixed $identifier
     * @param  mixed $data
     * @param  mixed $options
     * @param  mixed $callback
     * @return void
     */
    public function updateStatus($identifier, $data, $options = [], $callback = null)
    {
        $data['status'] = Arr::pull($data, 'status');
        $model = Parent::update($identifier, $data, $options, $callback = null);
        return $model!=null;
    }

    
    /**
     * [Increment BankAccount balance]
     *
     * @param array $data
     *
     * @return BankAccount $bankAccount
     *
     */
    public function deposit($identifier, $data, $options = [], $callback = null)
    {
        try {
            return $this->repository->deposit($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to Deposit");
        }
    }
}
