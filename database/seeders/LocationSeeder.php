<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\School;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['city' => 'Cairo', 'address' => 'Nasr City', 'google_maps_link' => 'https://maps.google.com/?q=Nasr+City'],
            ['city' => 'Giza', 'address' => 'Dokki', 'google_maps_link' => 'https://maps.google.com/?q=Dokki'],
            ['city' => 'Alexandria', 'address' => 'Smouha', 'google_maps_link' => 'https://maps.google.com/?q=Smouha'],
            ['city' => 'Cairo', 'address' => 'Heliopolis', 'google_maps_link' => 'https://maps.google.com/?q=Heliopolis'],
            ['city' => 'Giza', 'address' => '6th of October', 'google_maps_link' => 'https://maps.google.com/?q=6th+of+October'],
            ['city' => 'Cairo', 'address' => 'Maadi', 'google_maps_link' => 'https://maps.google.com/?q=Maadi'],
            ['city' => 'Giza', 'address' => 'Sheikh Zayed', 'google_maps_link' => 'https://maps.google.com/?q=Sheikh+Zayed'],
            ['city' => 'Alexandria', 'address' => 'Miami', 'google_maps_link' => 'https://maps.google.com/?q=Miami+Alexandria'],
            ['city' => 'Cairo', 'address' => 'New Cairo', 'google_maps_link' => 'https://maps.google.com/?q=New+Cairo'],
            ['city' => 'Giza', 'address' => 'Haram', 'google_maps_link' => 'https://maps.google.com/?q=Haram'],
            ['city' => 'Cairo', 'address' => 'Shorouk', 'google_maps_link' => 'https://maps.google.com/?q=Shorouk'],
            ['city' => 'Cairo', 'address' => 'Obour', 'google_maps_link' => 'https://maps.google.com/?q=Obour'],
            ['city' => 'Alexandria', 'address' => 'Gleem', 'google_maps_link' => 'https://maps.google.com/?q=Gleem'],
            ['city' => 'Cairo', 'address' => 'Ain Shams', 'google_maps_link' => 'https://maps.google.com/?q=Ain+Shams'],
            ['city' => 'Giza', 'address' => 'Mohandessin', 'google_maps_link' => 'https://maps.google.com/?q=Mohandessin'],
            ['city' => 'Cairo', 'address' => 'El Rehab', 'google_maps_link' => 'https://maps.google.com/?q=El+Rehab'],
            ['city' => 'Giza', 'address' => 'Faisal', 'google_maps_link' => 'https://maps.google.com/?q=Faisal'],
            ['city' => 'Alexandria', 'address' => 'Sidi Gaber', 'google_maps_link' => 'https://maps.google.com/?q=Sidi+Gaber'],
            ['city' => 'Cairo', 'address' => 'Mokattam', 'google_maps_link' => 'https://maps.google.com/?q=Mokattam'],
            ['city' => 'Giza', 'address' => 'Agouza', 'google_maps_link' => 'https://maps.google.com/?q=Agouza'],
        ];

        $schools = School::all();

        foreach ($schools as $index => $school) {
            Location::create([
                'school_id' => $school->id,
                'city' => $locations[$index]['city'],
                'address' => $locations[$index]['address'],
                'google_maps_link' => $locations[$index]['google_maps_link'],
            ]);
        }
    }
}