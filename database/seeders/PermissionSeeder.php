<?php

namespace Database\Seeders;

use App\Services\AuthorizationService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $service = new AuthorizationService();

         // Authorization management
        $moduleAuthorization = $service->storeModules(['title' => 'Authorization','slug'=>Str::slug('Authorization')]);
        $service->storePermissions([
             'module_id' => $moduleAuthorization->id,
             'title' => 'Select Roles',
             'slug' => 'app.roles.select',
        ]);

        $service->storePermissions([
            'module_id' => $moduleAuthorization->id,
            'title' => 'Access Roles',
            'slug' => 'app.roles.index',
        ]);

        $service->storePermissions([
            'module_id' => $moduleAuthorization->id,
            'title' => 'Create Roles',
            'slug' => 'app.roles.create',
        ]);

        $service->storePermissions([
            'module_id' => $moduleAuthorization->id,
            'title' => 'Update Roles',
            'slug' => 'app.roles.update',
        ]);


        $service->storePermissions([
            'module_id' => $moduleAuthorization->id,
            'title' => 'Delete Roles',
            'slug' => 'app.roles.destroy',
        ]);

    }
}
