<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        User::create([
            'name' => $faker->name,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => $faker->name,
            'email' => 'operator@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
            'telpon' => $faker->phoneNumber()
        ]);

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => "crew$i@gmail.com",
                'password' => Hash::make('password'),
                'role' => 'crew',
                'telpon' => $faker->phoneNumber()
            ]);
        }

        $category = ['Kamera', 'Audio', 'Lampu'];

        foreach($category as $c){
            Category::create([
                'name' => $c
            ]);
        }
    }
}
