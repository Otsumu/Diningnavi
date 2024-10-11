<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use App\Models\User; 

class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');
        return [
            'name' => $faker->company,
            'image_url' => $this->faker->imageUrl(),
            'intro' => $faker->paragraph,
            'genre_id' => Genre::factory(),
            'area_id' => Area::factory(),
            'user_id' => User::factory(),
            'shop_owner_id' => User::factory()->shopOwner(),
        ];
    }
}
