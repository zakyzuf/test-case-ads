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
        //
        DB::table('products')->insert([
            [
                'category_id' => '1',
                'name' => 'Logitech H111 Headset Stereo Single Jack 3.5mm',
                'slug' => 'logitech-h111-headset-stereo-single-jack-3-5mm',
                'price' => '80000'
            ],
            [
                'category_id' => '1',
                'name' => 'Philips Rice Cooker - Inner Pot 2L Bakuhanseki - HD3110/33',
                'slug' => 'philips-rice-cooker -inner-pot-2l-bakuhanseki-hd3110-33',
                'price' => '249000'
            ],
            [
                'category_id' => '4',
                'name' => 'Iphone 12 64Gb/128Gb/256Gb Garansi Resmi IBOX/TAM - Hitam, 64Gb',
                'slug' => 'iphone-12-64gb-128gb-256gb-garansi-resmi-ibox-tam-hitam-64gb',
                'price' => '11340000'
            ],
            [
                'category_id' => '5',
                'name' => 'Papan alat bantu Push Up Rack Board Fitness Workout Gym',
                'slug' => 'papan-alat-bantu-push-up-rack-board-fitness-workout-gym',
                'price' => '90000'
            ],
            [
                'category_id' => '2',
                'name' => 'Jim Joker - Sandal Slide Kulit Pria Bold 2S Hitam - Hitam',
                'slug' => 'jim-joker-sandal-slide-kulit-pria-bold-2s-hitam-hitam',
                'price' => '305000'
            ],

        ]);
    }
}
