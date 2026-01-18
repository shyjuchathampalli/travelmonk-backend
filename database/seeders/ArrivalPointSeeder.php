<?php

namespace Database\Seeders;

use App\Models\ArrivalPoint;
use Illuminate\Database\Seeder;

class ArrivalPointSeeder extends Seeder
{
    public function run(): void
    {
        $arrivalPoints = [
            [
                'state_id' => 12,
                'name' => 'Thiruvananthapuram',
                'type' => 'airport',
                'code' => 'TRV',
                'status' => true,
            ],
            [
                'state_id' => 12,
                'name' => 'Kochi',
                'type' => 'airport',
                'code' => 'COK',
                'status' => true,
            ],
            [
                'state_id' => 12,
                'name' => 'Calicut',
                'type' => 'airport',
                'code' => 'CCJ',
                'status' => true,
            ],
            [
                'state_id' => 12,
                'name' => 'Kannur',
                'type' => 'airport',
                'code' => 'CNN',
                'status' => true,
            ],
        ];

        foreach ($arrivalPoints as $point) {
            ArrivalPoint::updateOrCreate(
                [
                    'state_id' => $point['state_id'],
                    'code' => $point['code'],
                ],
                $point
            );
        }
    }
}
