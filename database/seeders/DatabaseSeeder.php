<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // 'admin', 'stocker', 'operator', 'owner'
        User::factory()->create([
            'name' => 'admon',
            'email' => 'test@example.com',
            'password' => bcrypt('pass'),
            'username' => 'admin',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Adam',
            'email' => 'test1@example.com',
            'password' => bcrypt('pass'),
            'username' => 'adam',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'ploren',
            'email' => 'test2@example.com',
            'password' => bcrypt('pass'),
            'username' => 'ploren',
            'role' => 'operator',
        ]);
        User::factory()->create([
            'name' => 'Nathan',
            'email' => 'test3@example.com',
            'password' => bcrypt('pass'),
            'username' => 'nathan',
            'role' => 'stocker',
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


        Vendor::create([
            'name' =>'Pt sigma Jaya',
            'email'=> 'Sigma@jaya.co.id',
            'phone' => '12930128',
            'address' => 'azz',
        ]);
    }
}
