<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CreateUserSeeder::class);
        $this->call(CreateCompaniesSeeder::class);
        $this->call(CreatePlantsSeeder::class);
        $this->call(CreateRoomsSeeder::class);
        $this->call(CreateCostCenterSeeder::class);
        $this->call(CreateStatusSeeder::class);
        $this->call(CreateServiceTypesSeeder::class);
        $this->call(CreateApproversUsersSeeder::class);
    }
}
