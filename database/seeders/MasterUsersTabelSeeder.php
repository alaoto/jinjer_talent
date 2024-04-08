<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterUsersTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $master_user = [
            ['user_name' => 'user01', 'password' => Hash::make('user01'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['user_name' => 'user02', 'password' => Hash::make('user02'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['user_name' => 'user03', 'password' => Hash::make('user03'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['user_name' => 'user04', 'password' => Hash::make('user04'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['user_name' => 'user05', 'password' => Hash::make('user05'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
        ];

        foreach ($master_user as $user) {
            DB::table('master_users')->insert($user);
        }
    }
}
