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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('phone_verified_at')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('admins');
    }
};
