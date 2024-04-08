<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterAdminsTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $master_admin = [
            ['admin_name' => 'admin01', 'password' => Hash::make('admin01'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['admin_name' => 'admin02', 'password' => Hash::make('admin02'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['admin_name' => 'admin03', 'password' => Hash::make('admin03'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['admin_name' => 'admin04', 'password' => Hash::make('admin04'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
            ['admin_name' => 'admin05', 'password' => Hash::make('admin05'), 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL],
        ];

        foreach ($master_admin as $admin) {
            DB::table('master_admins')->insert($admin);
        }
    }
}
