<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu')->insert([
            'nombre' => 'Menu 1',
            'precio' => 80,
        ]);

        DB::table('menu')->insert([
            'nombre' => 'Menu 2',
            'precio' => 120,
        ]);

        DB::table('menu')->insert([
            'nombre' => 'Menu 3',
            'precio' => 150,
        ]);
    }
}
