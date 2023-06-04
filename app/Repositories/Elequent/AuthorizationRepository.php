<?php

namespace App\Repositories\Elequent;

use App\Contracts\Repositories\AuthorizationRepositoryInterface;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;

class AuthorizationRepository extends BaseRepository  implements AuthorizationRepositoryInterface
{
    public $model = Role::class;


    public function modules(){
        return Module::with('permissions')->get();
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
        return Module::updateOrCreate($data);
    }


     /**
     * [Store permissions]
     *
     * @param array $data
     *
     * @return Permission $permission
     *
     */
    public function storePermissions($data){
        return Permission::updateOrCreate($data);
    }

    /**
     * [Store Roles]
     *
     * @param array $data
     *
     * @return Role $role
     *
     */
    public function store($data){
        $permissions = Arr::pull($data,'permissions');
        return tap(Parent::store($data), function($role) use($permissions){
            $role->permissions()->sync($permissions);
        });
    }


    /**
     * [Update Roles]
     *
     * @param array $data
     *
     * @return Role $role
     *
     */
    public function update($identifier, $data , $options = [], $callback = null){
        $permissions = Arr::pull($data,'permissions');
        return tap(Parent::update($identifier,$data), function($role) use($permissions){
            $role->permissions()->sync($permissions);
        });
    }


    public function search($query, $value = null){
        if($value){
            $query->where('title','LIKE',"%".$value."%");
        }
    }
}