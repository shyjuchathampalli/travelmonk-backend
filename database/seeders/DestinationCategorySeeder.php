<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DestinationCategory;

class DestinationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Beaches',
            'Hill Stations',
            'Backwaters',
            'Wildlife Sanctuaries',
            'Waterfalls',
            'Lakes',
            'National Parks',
            'Forest Reserves',
            'Tea Gardens',
            'Coffee Plantations',
            'Heritage Sites',
            'Historical Monuments',
            'Pilgrimage Centers',
            'Temple Towns',
            'Coastal Towns',
            'Island Destinations',
            'Desert Landscapes',
            'Snow Destinations',
            'Adventure Zones',
            'Trekking Trails',
            'Camping Spots',
            'River Side',
            'Cultural Villages',
            'Art & Craft Hubs',
            'Tribal Areas',
            'Urban Getaways',
            'Luxury Retreats',
            'Eco Resorts',
            'Wellness Retreats',
            'Ayurveda Centers',
            'Yoga Retreats',
            'Romantic Getaways',
            'Family Friendly',
            'Kids Friendly',
            'Photography Spots',
            'Sunrise Points',
            'Sunset Points',
            'Marine Life Zones',
            'Coral Reefs',
            'Houseboat Areas',
            'Bird Sanctuaries',
            'Mangrove Forests',
            'Grasslands',
            'Volcanic Landscapes',
            'Caves',
            'Cliff Views',
            'Plateaus',
            'Glacier Regions',
            'Forts & Palaces',
            'Sacred Groves',
        ];

        foreach ($categories as $category) {
            DestinationCategory::updateOrCreate(
                ['name' => $category],
                ['status' => true]
            );
        }
    }
}
