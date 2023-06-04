<?php

namespace Database\Seeders;

use App\Services\QuestionAnswerService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionAnswerService = new QuestionAnswerService();

        $questionAnswerService->store([
            'product_id' => 1,
            'customer_id' => 1,
            'vendor_id' => 1,
            'question' => "Xl is available?",
            'answer' => 'yes',
        ]);
    }
}
