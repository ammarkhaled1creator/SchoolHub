<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'mariam',
            'email' => 'mariam@gmail.com',
            'password' => bcrypt('Pass123'),
            'phone' => '01011111111',
            'role_id' => Role::where('name', 'Admin')->first()->id,
        ]);

        User::factory(10)->create();

        $this->call([
            SchoolSeeder::class,
            LocationSeeder::class,
            TuitionFeesSeeder::class,
            ReviewSeeder::class,
            FavoriteSeeder::class,
        ]);
    }
}