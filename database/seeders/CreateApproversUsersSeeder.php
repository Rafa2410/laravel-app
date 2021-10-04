<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Approver;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateApproversUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyApprovers = [
            'A, S.A' => [
                [
                    'name' => 'Juan García',
                    'email' => 'juan@juan.com',
                    'password' => '123456'
                ],
                [
                    'name' => 'Laura Rodriguez',
                    'email' => 'laura@laura.com',
                    'password' => '123456'
                ]
            ],
            'B, S.A' => [
                [
                    'name' => 'Miguel Ramirez',
                    'email' => 'miguel@miguel.com',
                    'password' => '123456'
                ],
                [
                    'name' => 'Raquel Segura',
                    'email' => 'raquel@raquel.com',
                    'password' => '123456'
                ]
            ],
            'C, S.L' => [
                [
                    'name' => 'Emilio José',
                    'email' => 'emilio@emilio.com',
                    'password' => '123456'
                ],
                [
                    'name' => 'Ester Claros',
                    'email' => 'ester@ester.com',
                    'password' => '123456'
                ]
            ],
            'D, S.L.U' => [
                [
                    'name' => 'Iván Batlle',
                    'email' => 'ivan@ivan.com',
                    'password' => '123456'
                ],
                [
                    'name' => 'Mireia Meló',
                    'email' => 'mireia@mireia.com',
                    'password' => '123456'
                ]
            ]
        ];

        $role = Role::create(['name' => 'Approver']);
        $permissions = Permission::all();
        $approverPermissions = [];
        foreach ($permissions as $val) {
            if ($val->name === 'request-list' || $val->name === 'request-edit') {
                array_push($approverPermissions, $val->id);
            }
        }
        $role->syncPermissions($approverPermissions);
        foreach ($companyApprovers as $key => $approvers) {
            $company = Company::where('name', $key)->first();
            foreach ($approvers as $approver) {
                $user = User::create([
                    'name' => $approver['name'],
                    'email' => $approver['email'],
                    'password' => bcrypt($approver['password'])
                ]);
                Approver::create([
                    'company_id' => $company->id,
                    'user_id' => $user->id
                ]);
                $user->assignRole([$role->id]);
            }
        }
    }
}
