<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'name' => 'Company 1',
            'email' => Str::random(10).'@example.com',
        ]);

        DB::table('companies')->insert([
            'name' => 'Company 2',
            'address' => Str::random(150),
            'email' => Str::random(10).'@example.com',
        ]);

        DB::table('companies')->insert([
            'name' => 'Company 3',
            'email' => Str::random(10).'@example.com',
        ]);
    }
}
