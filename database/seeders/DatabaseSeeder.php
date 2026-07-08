<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SchoolSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'mariam',
            'email' => 'mariam@gmail.com',
            'password'=> bcrypt('Pass123'),
            'phone' => '01011111111',
            'role_id' => \App\Models\Role::firstOrCreate(['name' => 'Admin'])->id,
        ]);

        User::factory(10)->create();
        Review::factory(30)->create();
    }
}
