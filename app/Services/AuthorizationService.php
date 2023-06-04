<?php

namespace App\Services;

use App\Contracts\Repositories\AuthorizationRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AuthorizationService extends CoreService
{
    protected $name = "authorization";
    public $encryptedId = true;
    
    public function __construct()
    {

        $this->repository = app()->make(AuthorizationRepositoryInterface::class);
    }

    /**
     * [Get roles for select]
     *
     *
     * @return Role $roles
     */
    public function getRolesForSelect(){
        return $this->repository->index([
            'select'=>['id','title','slug']
        ]);
    }

    /**
     * [Get roles for select]
     *
     *
     * @return Role $roles
     */
    public function getModulesForSelect(){
        return $this->repository->modules();
    }


     /**
     * [Store Modules]
     *
     * @param array $data
     *
     * @return Module $modules
     *
     */
    public function storeModules($data){
        return $this->repository->storeModules($data);
    }


    /**
     * [Store permissions]
     *
     * @param array $data
     *
     * @return Permission $permission
     *
     */
    public function storePermissions(Array $data){
        return $this->repository->storePermissions($data);
    }

    /**
     * [Store roles]
     *
     * @param array $data
     *
     * @return Role $role
     *
     */
    public function store($data){
        $data['slug'] = Str::slug(Arr::get($data, 'title'));
        return parent::store($data);
    }


    /**
     * [Update roles]
     *
     * @param array $data
     *
     * @return Role $role
     *
     */
    public function update($identifier, $data, $options = [], $callback = null){
        $data['slug'] = Str::slug(Arr::get($data, 'title'));
        return parent::update($identifier, $data);
    }

}