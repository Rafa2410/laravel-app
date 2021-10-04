<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceType;

class CreateServiceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Breakfast',
            'Luncheons and Barbecues',
            'Coffees',
            'Foods'
        ];

        foreach ($types as $type) {
            ServiceType::create(['name' => $type]);
        }
    }
}
