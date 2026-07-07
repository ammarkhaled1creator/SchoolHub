<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\SchoolType;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {

        $types = [
            'International' => SchoolType::firstOrCreate(['name' => 'International'])->id,
            'National'      => SchoolType::firstOrCreate(['name' => 'National'])->id,
            'Language'      => SchoolType::firstOrCreate(['name' => 'Language'])->id,
            'Azhari'        => SchoolType::firstOrCreate(['name' => 'Azhari'])->id,
        ];

        $schools = [
            [
                'school_type_id' => $types['International'],
                'name' => 'Future International School',
                'description' => 'An international school offering an accredited British curriculum from kindergarten through high school.',
                'phone' => '01012345601',
                'website' => 'https://future-international.edu.eg',
                'image' => 'schools/future-international.jpg',
            ],
            [
                'school_type_id' => $types['National'],
                'name' => 'Al Nasr Official School',
                'description' => 'A public school following the official Egyptian curriculum with symbolic tuition fees.',
                'phone' => '01012345602',
                'website' => 'https://alnasr-official.edu.eg',
                'image' => 'schools/alnasr-official.jpg',
            ],
            [
                'school_type_id' => $types['Language'],
                'name' => 'Al Amal Language School',
                'description' => 'A language school teaching the Egyptian curriculum in English with an additional French activity track.',
                'phone' => '01012345603',
                'website' => 'https://alamal-languages.edu.eg',
                'image' => 'schools/alamal-languages.jpg',
            ],
            [
                'school_type_id' => $types['Azhari'],
                'name' => 'Al Noor Azhari Institute',
                'description' => 'An Azhari institute combining Islamic studies with the standard government curriculum.',
                'phone' => '01012345604',
                'website' => 'https://alnoor-azhari.edu.eg',
                'image' => 'schools/alnoor-azhari.jpg',
            ],
            [
                'school_type_id' => $types['International'],
                'name' => 'Nile International Academy',
                'description' => 'Follows the International Baccalaureate (IB) system with a wide range of sports and arts activities.',
                'phone' => '01012345605',
                'website' => 'https://nile-academy.edu.eg',
                'image' => 'schools/nile-academy.jpg',
            ],
            [
                'school_type_id' => $types['National'],
                'name' => 'Al Geel Al Waed Official School',
                'description' => 'A public school with newly equipped classrooms and weekly extracurricular activities.',
                'phone' => '01012345606',
                'website' => 'https://algeel-alwaed.edu.eg',
                'image' => 'schools/algeel-alwaed.jpg',
            ],
            [
                'school_type_id' => $types['Language'],
                'name' => 'Al Ferdaws Language School',
                'description' => 'A language school focusing on German as a second foreign language.',
                'phone' => '01012345607',
                'website' => 'https://alferdaws-languages.edu.eg',
                'image' => 'schools/alferdaws-languages.jpg',
            ],
            [
                'school_type_id' => $types['International'],
                'name' => 'Cambridge International School Cairo',
                'description' => 'Accredited by Cambridge Assessment International Education.',
                'phone' => '01012345608',
                'website' => 'https://cambridge-cairo.edu.eg',
                'image' => 'schools/cambridge-cairo.jpg',
            ],
            [
                'school_type_id' => $types['Azhari'],
                'name' => 'Al Rahma Azhari Primary Institute',
                'description' => 'An Azhari institute specialized in the primary stage with Quran memorization circles.',
                'phone' => '01012345609',
                'website' => 'https://alrahma-azhari.edu.eg',
                'image' => 'schools/alrahma-azhari.jpg',
            ],
            [
                'school_type_id' => $types['National'],
                'name' => 'Al Amir Official Basic Education School',
                'description' => 'A public school covering both kindergarten and primary stages.',
                'phone' => '01012345610',
                'website' => 'https://alamir-official.edu.eg',
                'image' => 'schools/alamir-official.jpg',
            ],
            [
                'school_type_id' => $types['Language'],
                'name' => 'Al Rowad Language School',
                'description' => 'An accredited language school offering a STEM program alongside the Egyptian curriculum.',
                'phone' => '01012345611',
                'website' => 'https://alrowad-languages.edu.eg',
                'image' => 'schools/alrowad-languages.jpg',
            ],
            [
                'school_type_id' => $types['International'],
                'name' => 'Shorouk American Academy',
                'description' => 'Teaches the American Diploma curriculum across all grade levels.',
                'phone' => '01012345612',
                'website' => 'https://shorouk-american.edu.eg',
                'image' => 'schools/shorouk-american.jpg',
            ],
            [
                'school_type_id' => $types['National'],
                'name' => 'Al Salam Official Experimental School',
                'description' => 'An official experimental language school with reduced fees compared to international schools.',
                'phone' => '01012345613',
                'website' => 'https://alsalam-tagrba.edu.eg',
                'image' => 'schools/alsalam-tagrba.jpg',
            ],
            [
                'school_type_id' => $types['Azhari'],
                'name' => 'Al Fath Azhari Secondary Institute',
                'description' => 'An Azhari institute for the secondary stage with both scientific and literary tracks.',
                'phone' => '01012345614',
                'website' => 'https://alfath-azhari.edu.eg',
                'image' => 'schools/alfath-azhari.jpg',
            ],
            [
                'school_type_id' => $types['Language'],
                'name' => 'Al Nahda Modern Language School',
                'description' => 'A modern language school with smart classrooms and interactive projectors.',
                'phone' => '01012345615',
                'website' => 'https://alnahda-modern.edu.eg',
                'image' => 'schools/alnahda-modern.jpg',
            ],
            [
                'school_type_id' => $types['International'],
                'name' => 'Al Andalus International School',
                'description' => 'Follows the IGCSE system with a strong focus on sports activities.',
                'phone' => '01012345616',
                'website' => 'https://alandalus-international.edu.eg',
                'image' => 'schools/alandalus-international.jpg',
            ],
            [
                'school_type_id' => $types['National'],
                'name' => 'Al Orouba Official Mixed School',
                'description' => 'A public mixed-gender school covering the preparatory and secondary stages.',
                'phone' => '01012345617',
                'website' => 'https://alorouba-official.edu.eg',
                'image' => 'schools/alorouba-official.jpg',
            ],
            [
                'school_type_id' => $types['Language'],
                'name' => 'Al Fagr Al Jadid Language School',
                'description' => 'A language school focused on developing language and computer skills.',
                'phone' => '01012345618',
                'website' => 'https://alfagr-aljadid.edu.eg',
                'image' => 'schools/alfagr-aljadid.jpg',
            ],
            [
                'school_type_id' => $types['Azhari'],
                'name' => 'Bilal Ibn Rabah Azhari Institute',
                'description' => 'A full Azhari institute covering from primary through secondary stages.',
                'phone' => '01012345619',
                'website' => 'https://bilal-azhari.edu.eg',
                'image' => 'schools/bilal-azhari.jpg',
            ],
            [
                'school_type_id' => $types['International'],
                'name' => 'Gulf International School Giza',
                'description' => 'An international school with a British curriculum and weekly arts and music activities.',
                'phone' => '01012345620',
                'website' => 'https://alkhaleej-giza.edu.eg',
                'image' => 'schools/alkhaleej-giza.jpg',
            ],
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}
