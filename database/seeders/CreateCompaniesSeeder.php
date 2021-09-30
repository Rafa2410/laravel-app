<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CreateCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            'A, S.A',
            'B, S.A',
            'C, S.L',
            'D, S.L.U'
        ];

        foreach ($companies as $company) {
            Company::create(['name' => $company]);
        }
    }
}
