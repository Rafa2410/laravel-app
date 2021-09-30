<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plant;
use App\Models\CostCenter;

class CreateCostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            'A, S.A' => [
                'Planta 1' => ['Centro 1', 'Centro 2', 'Centro 3'],
                'Planta 2' => ['Centro 1', 'Centro 2'],
                'Planta 3' => ['Centro 1']
            ],
            'B, S.A' => [
                'Planta 1' => ['Centro 1', 'Centro 2'],
                'Planta 2' => ['Centro 1']
            ],
            'C, S.L' => [
                'Planta 1' => ['Centro 1', 'Centro 2', 'Centro 3'],
                'Planta 2' => ['Centro 1'],
                'Planta 3' => ['Centro 1', 'Centro 2']
            ],
            'D, S.L.U' => [
                'Planta 1' => ['Centro 1', 'Centro 2'],
                'Planta 2' => ['Centro 1'],
                'Planta 3' => ['Centro 1', 'Centro 2', 'Centro 3'],
                'Planta 4' => ['Centro 1', 'Centro 2']
            ]
        ];
        
        $plants = Plant::all();
        foreach ($plants as $plant) {
            foreach ($rooms[$plant->getCompany($plant->company_id)->name][$plant->name] as $room) {
                CostCenter::create([
                    'name' => $room,
                    'plant_id' => $plant->id
                ]);
            }
        }
    }
}
