<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\TuitionFees;
use Illuminate\Database\Seeder;

class TuitionFeesSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            'KG',
            'Primary',
            'Preparatory',
            'Secondary',
        ];

        foreach (School::all() as $school) {

            foreach ($grades as $grade) {

                $price = match ($grade) {
                    'KG' => rand(10000, 30000),
                    'Primary' => rand(15000, 45000),
                    'Preparatory' => rand(18000, 50000),
                    'Secondary' => rand(20000, 60000),
                };

                TuitionFees::create([
                    'school_id' => $school->id,
                    'grade' => $grade,
                    'price' => $price,
                    'academic_year' => '2026/2027',
                ]);
            }
        }
    }
}