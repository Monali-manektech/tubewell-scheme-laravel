<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;
    public function definition()
    {
        return [
            'item_no' => $this->faker->randomNumber(4),
            'parent_id' => 0,
            'link' => $this->faker->randomDigit(),
            'discipline' => $this->faker->word(),
            'legend' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(4),
            'quantity' => $this->faker->randomDigit(),
            'units' => $this->faker->randomDigit(),
            'rate' => $this->faker->randomNumber(4)
        ];
    }
}
