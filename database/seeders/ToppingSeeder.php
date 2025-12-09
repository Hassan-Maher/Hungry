<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('toppings')->insert([
            [
                'name' => 'Tomato',
                'price' => 10,
                'img'   => 'toppings/tomato.png'
            ],
            [
                'name' => 'Onions',
                'price' => 15,
                'img'   => 'toppings/onions.png'
            ],
            [
                'name' => 'Pickles',
                'price' => 20,
                'img'   => 'toppings/pickles.png'
            ],
            [
                'name' => 'Bacons',
                'price' => 20,
                'img'   => 'toppings/bacons.png'
            ],

        ]);
    }
}
