<?php

namespace Database\Seeders;

use App\Actions\DispatchService;
use App\Services\AdminService;
use App\Services\AuthorizationService;
use App\Services\LanguageService;
use App\Services\LocationService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\Foreach_;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorizationService = new AuthorizationService();
        $adminService         = new AdminService();
        $dispatchService      = new DispatchService($adminService);
        $languages            = LanguageService::instance()->getAvailableLanguagesCode();
        $roles                = $authorizationService->getRolesForSelect();


        foreach ($roles as $role) {
            $dispatchService->store([
                'phone' => '0123456789' . rand(2, 10),
                'email' => $role->slug . '@mail.com',
                'password' => 'password',
                'role_id' => $role->slug,
                'translations' => $this->getTranslations($languages, $role),
            ]);
        }
    }




    private function getTranslations($languages, $role)
    {
        $translations = [];
        foreach ($languages as $language) {
            array_push($translations, [
                'local' => $language,
                'firstname' => $language . '' . $role->title,
                'lastname' => $language . ' doe',
            ]);
        }

        return $translations;
    }
}
