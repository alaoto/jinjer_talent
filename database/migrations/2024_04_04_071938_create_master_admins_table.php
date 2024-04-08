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
        if (!Schema::hasTable('master_admins')) {
            Schema::create('master_admins', function (Blueprint $table) {
                $table->id();
                $table->string('admin_name');
                $table->string('password');
                $table->dateTime('last_login')->nullable();
                $table->dateTime('failure_start_datetime')->nullable();
                $table->tinyInteger('failure_cnt')->nullable();
                $table->dateTime('failure_stop_datatime')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrentOnUpdate();
                $table->dateTime('deleted_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_admins');
    }
};
