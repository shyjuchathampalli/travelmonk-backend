<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'India', 'iso_code' => 'IN', 'status' => true],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso_code' => $country['iso_code']],
                $country
            );
        }
    }
}
