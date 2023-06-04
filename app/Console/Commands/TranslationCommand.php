<?php

namespace App\Console\Commands;

use App\Services\TranslationService;
use Illuminate\Console\Command;

class TranslationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This conndwillgenerate available languages translation json file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Generating translation!");
        $translation=new TranslationService();
        $translation->publish();

        $this->info("Translator Generated!");
    }
}
