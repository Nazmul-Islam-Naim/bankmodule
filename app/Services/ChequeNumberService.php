<?php

namespace App\Services;

use App\Enum\ChequeStatus;
use App\Contracts\Repositories\ChequeNumberRepositoryInterface;
use App\Exceptions\GeneralException;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Arr;

class ChequeNumberService extends CoreService
{
    public $encryptedId = true;
    protected $name = "Cheque Number";

    public function __construct()
    {
        $this->repository = app()->make(ChequeNumberRepositoryInterface::class);
    }


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
        try {
            $data['cheque_book_id'] = Helper::decrypt(Arr::pull($data, 'cheque_book_id'));
            return Parent::store($data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to store Cheque Number");
        }
    }


    /**
     * [Update ChequeNumber]
     *
     * @param array $data
     *
     * @return ChequeNumber $chequeNumber
     *
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        try {
            $data['cheque_book_id'] = Helper::decrypt(Arr::pull($data, 'cheque_book_id'));
            return Parent::update($identifier, $data);
        } catch (Exception $exception) {
            throw new GeneralException($exception, "Failed to update Cheque Number");
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
