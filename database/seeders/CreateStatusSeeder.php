<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class CreateStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            'Draft',
            'Pending',
            'Approved',
            'Cancelled',
            'Rejected'
        ];

        foreach ($status as $value) {
            Status::create(['name' => $value]);
        }
    }
}
