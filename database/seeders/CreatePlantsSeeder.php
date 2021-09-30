<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Plant;

class CreatePlantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plants = [
            'A, S.A' => ['Planta 1', 'Planta 2', 'Planta 3'],
            'B, S.A' => ['Planta 1', 'Planta 2'],
            'C, S.L' => ['Planta 1', 'Planta 2', 'Planta 3'],
            'D, S.L.U' => ['Planta 1', 'Planta 2', 'Planta 3', 'Planta 4']
        ];

        $companies = Company::all();
        foreach ($companies as $company) {
            foreach ($plants[$company->name] as $plant) {
                Plant::create([
                    'name' => $plant,
                    'company_id' => $company->id
                ]);
            }
        }
    }
}
