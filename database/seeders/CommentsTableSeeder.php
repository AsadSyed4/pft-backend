<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        $visibility = [true, false];

        foreach (range(1, 50) as $index) {
            Comment::create([
                'client_id' => $faker->numberBetween(1, 100),
                'feedback_id' => $faker->numberBetween(1, 20),
                'content' => $faker->sentence,
                'visible' => $faker->randomElement($visibility),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
