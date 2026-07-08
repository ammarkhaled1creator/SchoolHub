<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            'Excellent school with great teachers.',
            'Very good educational environment.',
            'The administration is cooperative.',
            'Clean classrooms and modern facilities.',
            'Highly recommended.',
            'Needs improvement in activities.',
            'Good value for money.',
            'Friendly staff and qualified teachers.',
            'Students receive great attention.',
            'One of the best schools in the area.',
        ];

        $userIds = User::pluck('id');

        foreach (School::all() as $school) {

            $users = $userIds->shuffle()->take(rand(2, 5));

            foreach ($users as $userId) {

                Review::create([
                    'user_id'   => $userId,
                    'school_id' => $school->id,
                    'rating'    => rand(3, 5),
                    'comment'   => $comments[array_rand($comments)],
                ]);
            }
        }
    }
}