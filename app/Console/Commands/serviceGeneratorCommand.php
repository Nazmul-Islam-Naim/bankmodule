<?php

namespace App\Console\Commands;

use App\Servicegenerator\controllers\GenerateController;
use App\Servicegenerator\controllers\ModelController;
use App\Servicegenerator\controllers\RepositoryController;
use App\Servicegenerator\controllers\RepositoryInterfaceControllers;
use App\Servicegenerator\controllers\RequestController;
use App\Servicegenerator\controllers\ServiceController;
use Illuminate\Console\Command;

class serviceGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:generate {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate all files related to a service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name=$this->argument('name');
        (new ModelController($name))->handle();
        (new RepositoryInterfaceControllers($name))->handle();
        (new RepositoryController($name))->handle();
        (new ServiceController($name))->handle();
        (new GenerateController($name))->handle();
        (new RequestController($name))->handle();
    }
}
