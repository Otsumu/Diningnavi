<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    try {
        User::create([
            'name' => '管理太郎',
            'email' => 'kanri@kanri.com',
            'password' => Hash::make('adminpassword'),
            'role' => 'admin',
        ]);
    } catch (\Exception $e) {
        \Log::error('シーダー実行中にエラーが発生しました: '.$e->getMessage());
    }
}
}