<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');
        $schoolIds = School::pluck('id');

        foreach ($userIds as $userId) {

            $favorites = $schoolIds
                ->shuffle()
                ->take(rand(3, 6));

            foreach ($favorites as $schoolId) {

                Favorite::firstOrCreate([
                    'user_id'   => $userId,
                    'school_id' => $schoolId,
                ]);
            }
        }
    }
}