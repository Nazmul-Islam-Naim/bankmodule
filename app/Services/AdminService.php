<?php

namespace App\Services;

use App\Contracts\Repositories\AdminRepositoryInterface;
use App\Enum\Status;
use App\Exceptions\GeneralException;
use App\Models\Role;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;


class AdminService extends CoreService
{
    protected $name = "admin";

    public $encryptedId = true;

    protected $slugables=['role_id'=>Role::class];

    public function __construct()
    {

        $this->repository = app()->make(AdminRepositoryInterface::class);
    }

    /**
     * [get Status]
     *
     * @param array $data
     *
     * @return Module $modules
     *
     */
    public function getStatus()
    {
        return Status::getCases();
    }


    /**
     * [Store Modules]
     *
     * @param array $data
     *
     * @return Admin $modules
     *
     */
    public function store($data)
    {
        $this->begin();
        if(Arr::has($data, 'avatar')){
            $data['avatar'] = $this->upload(Arr::pull($data, 'avatar'), 'avatar/admins');
        }

        if(Arr::has($data,'status')){
            $data['status'] = Status::getFromName(Arr::pull($data, 'status'))->value;
        }

        $data['password'] = Hash::make(Arr::pull($data, 'password'));
        $model =  Parent::store($data);
        try{

            $this->commit();
            return $model;
        } catch (Exception $exception) {
            $this->rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param array $update
     * @param int $id
     * @return Bool
     */
    public function update($identifier, $data, $options = [], $callback = null)
    {
        $this->begin();
        try {
            $options['model'] = $this->repository->getModel($identifier, $options, $callback);
            if (Arr::has($data, 'avatar')) {
                $data['avatar'] = $this->cleanAndUpload(Arr::pull($data, 'avatar'), 'avatar/admins', $options['model']->avatar);
            }

            if (Arr::has($data, 'status')) {
                $data['status'] = Status::getFromName(Arr::pull($data, 'status'))->value;
            }

            if (Arr::has($data, 'password')) {
                $data['password'] = Hash::make(Arr::pull($data, 'password'));
            }
            $model = Parent::update($identifier, $data, $options, $callback = null);

            $this->commit();
            return $model;
        } catch (Exception $exception) {

            $this->rollBack();
            throw new GeneralException($exception, 'Admin update failed');
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
        $data['status'] = Status::getFromName(Arr::pull($data, 'status'))->value;
        $model = Parent::update($identifier, $data, $options, $callback = null);
        return $model!=null;
    }
}
