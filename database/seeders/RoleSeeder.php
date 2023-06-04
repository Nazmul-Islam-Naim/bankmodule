<?php

namespace Database\Seeders;

use App\Contracts\Repositories\AuthorizationRepositoryInterface;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = app()->make(AuthorizationRepositoryInterface::class);

        $super = Permission::all()->pluck('id');

        $roles= ['Super'=>['permissions'=>$super], 'Admin', 'Moderator'];

        foreach($roles as $key=>$role){
            $service->store([
                'title'         =>  is_int($key)?$role:$key,
                'slug'          =>  Str::slug(is_int($key)?$role:$key),
                'permissions'   =>  is_int($key)?[]:$role['permissions']
            ]);
        }
    }
}
