<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::insert([
            [
                'name' => 'Acai Zero Cup',
                'price' => 12,
                'count' => 10,
                'photo_path' => 'AcaiCup.png',
                'vending_machine_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tiramisu Dark Chocolate',
                'price' => 6,
                'count' => 15,
                'photo_path' => 'Chocolate.png',
                'vending_machine_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ice Cream Cup',
                'price' => 8,
                'count' => 12,
                'photo_path' => 'ice.png',
                'vending_machine_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monster Energy',
                'price' => 10,
                'count' => 20,
                'photo_path' => 'MonsterEnergy.png',
                'vending_machine_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Takis Chips',
                'price' => 7,
                'count' => 25,
                'photo_path' => 'takis.png',
                'vending_machine_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
