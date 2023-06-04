<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cheque_number_id')->constrained('cheque_numbers')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('approver_id')->constrained('users')->onDelete('cascade');
            $table->string('payee_name')->nullable()->comment('receiver name');
            $table->string('payer_name')->nullable()->comment('sender name');
            $table->decimal('amount', 15, 2);
            $table->date('cheque_date')->default(DB::raw('CURRENT_DATE'));
            $table->string('signature')->nullable();
            $table->string('note')->nullable();
            $table->tinyInteger('status')->default(3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheque_transactions');
    }
};
