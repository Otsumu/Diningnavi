<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Shop;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = FakerFactory::create('ja_JP');
        $shop = Shop::inRandomOrder()->first();

        return [
            'user_id' => User::factory(),
            'shop_id' => $shop ? $shop->id : Shop::factory(),
            'content' => 'これはダミーの口コミです、これはダミーの口コミです、これは口コミです、これは口コミです、これは口コミです、
            これは口コミです、これは口コミです、これは口コミです、これは口コミです、これは口コミです、これは口コミです、これは口こみです、
            これは口コミです、これは口コミです、これは口コミです、これは口コミです、これは口コミです、これは口コミです、これは口コミです。',
            'rating' => $faker->numberBetween(1, 5),
            'image' => $faker->imageUrl(),
        ];
    }
}
