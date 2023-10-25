<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        foreach (range(1, 100) as $index) {
            Client::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'username' => $faker->userName,
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
