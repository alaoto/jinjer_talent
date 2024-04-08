<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DataAdminsTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $master_admins = DB::table('master_admins')->pluck('id')->toArray();

        for ($i = 0; $i < 5; $i++) {
            DB::table('data_admins')->insert([
                'admin_id' => $master_admins[$i],
                'permission_code' => 'all',
                'first_name' => fake()->lastName(),
                'last_name' => fake()->firstName(),
                'email' => 'admin' . $i + 1 . '@example.com',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => NULL,
            ]);
        }

    }
}
