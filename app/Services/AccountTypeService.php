<?php

namespace App\Services;

use App\Contracts\Repositories\AccountTypeRepositoryInterface;
use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Support\Str;

class AccountTypeService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Account Type";

    public function __construct()
    {
        $this->repository = app()->make(AccountTypeRepositoryInterface::class);
    }


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
        try {
            $data['slug'] = Str::slug($data['title']);
            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store Account Type");
        }
    }


    /**
     * [Update AccountType]
     *
     * @param array $data
     *
     * @return AccountType $accountType
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        try {
            $data['slug'] = Str::slug($data['title']);
            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update Account Type");
        }
    }

}
