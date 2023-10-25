<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class FeedbacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        $categories = ['Bug Report', 'Feature Request', 'Improvement', 'User Experience', 'Performance', 'Security', 'Content', 'General Comment', 'Other'];

        foreach (range(1, 20) as $index) {
            Feedback::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'category' => $faker->randomElement($categories),
                'vote_count' => $faker->numberBetween(0, 100),
                'client_id' => $faker->numberBetween(1, 100),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
