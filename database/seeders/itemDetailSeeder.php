<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemDetail;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class itemDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemId = Item::pluck('id');
        $faker = Factory::create();

        foreach (range(1,50) as $index) {
            ItemDetail::create([
                'item_id' => $faker->randomElement($itemId),
                'parent_id'=> null,
                'name'=>$faker->word(2),
                'percentage'=>$faker->randomNumber(2)
            ]);
        }   
    }
}
