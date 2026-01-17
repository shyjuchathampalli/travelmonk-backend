<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TravelPurpose;

class TravelPurposeSeeder extends Seeder
{
    public function run(): void
    {
        $purposes = [
            'Honeymoon',
            'Family Trip',
            'Friends Getaway',
            'Solo Travel',
            'Adventure Trip',
            'Backpacking',
            'Pilgrimage',
            'Leisure Vacation',
            'Luxury Travel',
            'Budget Travel',
            'Wildlife Exploration',
            'Beach Holiday',
            'Hill Station Retreat',
            'Cultural Exploration',
            'Heritage Tour',
            'Photography Tour',
            'Wellness & Yoga',
            'Ayurveda Treatment',
            'Medical Tourism',
            'Romantic Getaway',
            'Corporate Retreat',
            'Team Outing',
            'Educational Tour',
            'Festival Travel',
            'Eco Tourism',
            'Road Trip',
            'Cruise Holiday',
            'Spiritual Retreat',
            'Weekend Escape',
            'Slow Travel',
        ];

        foreach ($purposes as $purpose) {
            TravelPurpose::updateOrCreate(
                ['name' => $purpose],
                ['status' => true]
            );
        }
    }
}
