<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Side_optionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('side_options')->insert([
        [
            'name' => 'Fries',
            'price' => 10,
            'img'   => 'side_options/fries.png'
        ],
        [
            'name' => 'Salad',
            'price' => 15,
            'img'   => 'side_options/salad.png'
        ],
        [
            'name' => 'Coleslow',
            'price' => 20,
            'img'   => 'side_options/coleslow.png'
        ],
    ]);
}
}
