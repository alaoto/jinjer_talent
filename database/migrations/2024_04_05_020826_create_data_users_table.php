<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('data_users')) {
            Schema::create('data_users', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('first_name', 255)->nullable();
                $table->string('last_name', 255)->nullable();
                $table->string('email', 255);
                $table->dateTime('birthday')->nullable();
                $table->string('nickname', 255)->nullable();
                $table->string('zipcode', 255)->nullable();
                $table->tinyInteger('prefcode')->nullable();
                $table->string('city', 255)->nullable();
                $table->string('address1', 255)->nullable();
                $table->string('tel', 255)->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrentOnUpdate();
                $table->timestamp('deleted_at')->nullable();

                $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_users');
    }
};
