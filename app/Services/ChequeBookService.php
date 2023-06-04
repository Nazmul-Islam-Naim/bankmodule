<?php

namespace App\Services;

use App\Contracts\Repositories\ChequeBookRepositoryInterface;
use App\Exceptions\GeneralException;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ChequeBookService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Cheque Book";

    public function __construct()
    {
        $this->repository = app()->make(ChequeBookRepositoryInterface::class);
    }


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
        try {
            $data['bank_id'] = Helper::decrypt(Arr::pull($data, 'bank_id'));
            $data['slug'] = Str::slug($data['title']).'-'.date('his');
            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store Cheque Book");
        }
    }


    /**
     * [Update ChequeBook]
     *
     * @param array $data
     *
     * @return ChequeBook $chequeBook
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        try {
            $data['bank_id'] = Helper::decrypt(Arr::pull($data, 'bank_id'));
            $data['slug'] = Str::slug($data['title']).'-'.date('his');
            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update Cheque Book");
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
