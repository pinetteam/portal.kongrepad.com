<?php

namespace Database\Seeders;

use App\Models\User\Role\Scope\UserRoleScope;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRoleScope::insert(
            [
                [
                    'code' => 'show-dashboard',
                    'route' => 'portal.dashboard.index',
                ],
            ]
        );
    }
}
