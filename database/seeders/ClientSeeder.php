<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
            'first_name' => 'Ivan',
            'last_name' => 'Ivanov',
            'email' => Str::random(10).'@example.com',
        ]);

        DB::table('clients')->insert([
            'first_name' => 'Petar',
            'last_name' => 'Petrov',
            'email' => Str::random(10).'@example.com',
        ]);

        DB::table('clients')->insert([
            'first_name' => 'Hristo',
            'last_name' => 'Hristov',
            'email' => Str::random(10).'@example.com',
        ]);
    }
}
