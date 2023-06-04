<?php

namespace App\Services;

use App\Contracts\Repositories\BankRepositoryInterface;
use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BankService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Bank";

    public function __construct()
    {
        $this->repository = app()->make(BankRepositoryInterface::class);
    }


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
        try {
            $data['slug'] = Str::slug($data['title']);
            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store Bank");
        }
    }


    /**
     * [Update Bank]
     *
     * @param array $data
     *
     * @return Bank $bank
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        try {
            $data['slug'] = Str::slug($data['title']);
            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update Bank");
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

}
