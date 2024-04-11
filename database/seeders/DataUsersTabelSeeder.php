<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataUsersTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $master_users = DB::table('master_users')->pluck('id')->toArray();

        for ($i = 0; $i < 5; $i++) {
            DB::table('data_users')->insert([
                'user_id' => $master_users[$i],
                'first_name' => fake()->lastName(),
                'last_name' => fake()->firstName(),
                'email' => 'user' . $i + 1 . '@example.com',
                'birthday' => fake()->date('Y-m-d'),
                'nickname' => fake()->firstName(),
                'zipcode' => fake()->postcode(),
                'prefcode' => fake()->numberBetween(1, 47),
                'city' => fake()->city(),
                'address' => fake()->streetAddress(),
                'tel' => fake()->phoneNumber(),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => NULL,
            ]);
        }
    }
}
