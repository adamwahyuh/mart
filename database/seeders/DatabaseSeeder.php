<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admon',
            'email' => 'test@example.com',
            'password' => bcrypt('pass'),
            'username' => 'admin',
            'role' => 'admin',
        ]);
        Category::create([
            'name' =>'Minuman',
        ]);
        Category::create([
            'name' =>'Makanan',
        ]);
        Category::create([
            'name' =>'Mainan',
        ]);
        Category::create([
            'name' =>'Snack',
        ]);
        Category::create([
            'name' =>'Roti',
        ]);
    }
}
