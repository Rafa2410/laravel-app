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
            'Launcheons and Barbecues',
            'Conventions, Tradeshows and Conferences',
            'Board Meeting',
            'Product Launches'
        ];

        foreach ($types as $type) {
            ServiceType::create(['name' => $type]);
        }
    }
}
