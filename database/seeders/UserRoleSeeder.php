<?php

namespace Database\Seeders;

use App\Models\User\Role\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $access_scopes = [
            'portal.dashboard.index',
        ];

        UserRole::insert([
            [
                'customer_id' => 1,
                'title' => 'Manager',
                'access_scopes' => json_encode($access_scopes),
                'status' => 1,
            ],
            [
                'customer_id' => 1,
                'title' => 'Operator',
                'access_scopes' => json_encode($access_scopes),
                'status' => 1,
            ],
            [
                'customer_id' => 1,
                'title' => 'User',
                'access_scopes' => json_encode($access_scopes),
                'status' => 1,
            ],
        ]);
    }
}
