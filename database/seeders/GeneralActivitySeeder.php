<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\Vendor;

class GeneralActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Get any existing vendor safely
        $vendor = Vendor::first();

        // If no vendor exists, do NOT seed activities
        if (! $vendor) {
            $this->command?->warn('No vendors found. Skipping GeneralActivitySeeder.');
            return;
        }

        $activities = [
            'Candle Light Dinner',
            'Private Beach Dinner',
            'Spa Therapy',
            'Ayurvedic Massage',
            'Couple Massage',
            'Yoga Session',
            'Meditation Session',
            'Wellness Consultation',
            'Private Photographer',
            'Surprise Decoration',
            'Anniversary Celebration',
            'Birthday Celebration',
            'Romantic Room Decoration',
            'Flower Bed Decoration',
            'Airport Assistance',
            'VIP Lounge Access',
            'Personal Chauffeur',
            'Baby Care Services',
            'Elderly Assistance',
            'Travel Insurance',
        ];

        foreach ($activities as $activity) {
            Activity::updateOrCreate(
                [
                    'name' => $activity,
                    'type' => 'general',
                ],
                [
                    'destination_id' => null,
                    'vendor_id' => $vendor->id,
                    'base_price' => 0,
                    'status' => true,
                ]
            );
        }
    }
}
