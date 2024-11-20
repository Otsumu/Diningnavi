<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.

     * @return void
     */
    public function run()
    {
        $this->call([
            AreasTableSeeder::class,
            GenresTableSeeder::class,
            ShopsTableSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            BookingsTableSeeder::class,
        ]);

        Comment::factory(20)->create();
    }
}
