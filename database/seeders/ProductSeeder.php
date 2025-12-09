<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 3, // Classic
                'name' => 'Cheeseburger',
                'description' => 'Double beef cheeseburger with lettuce and onions.',
                'img' => 'images/cheese1.png',
                'price' => 120.00,
                'rating' => 4.9,
            ],
            [
                'category_id' => 5, // Veggie
                'name' => 'Veggie Burger',
                'description' => 'Fresh vegetarian burger with tomatoes and lettuce.',
                'img' => 'images/veggie.png',
                'price' => 95.00,
                'rating' => 4.8,
            ],
            [
                'category_id' => 4, // Chicken
                'name' => 'Chicken Burger',
                'description' => 'Grilled chicken burger with lettuce and tomatoes.',
                'img' => 'images/chicken1.png',
                'price' => 110.00,
                'rating' => 4.6,
            ],
            [
                'category_id' => 4, // Chicken
                'name' => 'Fried Chicken Burger',
                'description' => 'Crispy fried chicken burger with mayo.',
                'img' => 'images/chicken2.png',
                'price' => 115.00,
                'rating' => 4.5,
            ],
            [
                'category_id' => 1, // Combos
                'name' => 'Burger Combo',
                'description' => 'Burger + Fries + Drink.',
                'img' => 'images/combo1.png',
                'price' => 160.00,
                'rating' => 4.7,
            ],
            [
                'category_id' => 1, // Combos
                'name' => 'Chicken Combo',
                'description' => 'Chicken burger combo meal.',
                'img' => 'images/combo2.png',
                'price' => 170.00,
                'rating' => 4.6,
            ],
            [
                'category_id' => 2, // Sliders
                'name' => 'Mini Beef Slider',
                'description' => 'Small beef slider with cheese.',
                'img' => 'images/slider1.png',
                'price' => 55.00,
                'rating' => 4.3,
            ],
            [
                'category_id' => 2, // Sliders
                'name' => 'Mini Chicken Slider',
                'description' => 'Small crispy chicken slider.',
                'img' => 'images/slider2.png',
                'price' => 50.00,
                'rating' => 4.2,
            ],
            [
                'category_id' => 3, // Classic
                'name' => 'Double Beef Burger',
                'description' => 'Two beef patties with cheese and veggies.',
                'img' => 'images/beef2.png',
                'price' => 140.00,
                'rating' => 4.7,
            ],
            [
                'category_id' => 5, // Veggie
                'name' => 'Mushroom Veggie Burger',
                'description' => 'Veggie burger with grilled mushroom.',
                'img' => 'images/veggie2.png',
                'price' => 100.00,
                'rating' => 4.4,
            ],
        ]);
    }
}
