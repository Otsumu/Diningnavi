<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ShopOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '店舗一郎',
            'email' => 'ichiro@tenpo.com',
            'password' => Hash::make('ichiropassword'),
            'role' => 'shop_owner',
        ]);

        User::create([
            'name' => '店舗二郎',
            'email' => 'jiro@tenpo.com',
            'password' => Hash::make('jiropassword'),
            'role' => 'shop_owner',
        ]);

        User::create([
            'name' => '店舗三郎',
            'email' => 'saburo@tenpo.com',
            'password' => Hash::make('saburopassword'),
            'role' => 'shop_owner',
        ]);
    }
}
