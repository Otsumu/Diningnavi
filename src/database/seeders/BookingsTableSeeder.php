<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Shop;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $shops = Shop::all();

        foreach ($users as $user) {
            Booking::factory()->create([
                'user_id' => $user->id,
                'shop_id' => $shops->random()->id,
                'booking_date' => now()->addDays(rand(1, 30)),
                'booking_time' => now()->format('H:i:s'),
                'number' => rand(1, 30),
            ]);
        }
    }
}
