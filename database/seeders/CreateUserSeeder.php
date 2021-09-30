<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Manolo Garcia',
            'email' => 'user@user.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'User']);
        $permissions = Permission::all();
        $userPermissions = [];
        foreach ($permissions as $val) {
            if ($val->name === 'request-list' || $val->name === 'request-create' || $val->name === 'request-edit') {
                array_push($userPermissions, $val->id);
            }
        }
        $role->syncPermissions($userPermissions);
        $user->assignRole([$role->id]);
    }
}
