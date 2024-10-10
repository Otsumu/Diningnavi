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
            Booking::factory()->count(3)->create([
                'user_id' => $user->id,
                'shop_id' => $shops->random()->id, // ランダムにショップを選択
                'booking_date' => now()->addDays(rand(1, 30)), // 1～30日後の日付を設定
                'booking_time' => now()->format('H:i:s'), // 現在の時刻を設定
                'number' => rand(1, 10), // 1～10人の人数を設定
            ]);
        }
    }
}
