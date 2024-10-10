<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\User;
use App\Models\Shop;

class BookingFactory extends Factory
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
            'user_id' => User::factory(),
            'shop_id' => Shop::factory(),
            'booking_date' => $faker->dateTimeBetween('+1 days', '+30 days')->format('Y-m-d'), 
            'booking_time' => $faker->time(),
            'number' => $faker->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
