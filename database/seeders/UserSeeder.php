<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'customer_id' => '1',
                'user_role_id' => '1',
                'first_name' => 'Manager',
                'last_name' => 'Manager',
                'username' => 'manager',
                'email' => 'manager@kongrepad.com',
                'password' => bcrypt('manager'),
                'status' => 1,
            ],
            [
                'customer_id' => '1',
                'user_role_id' => '2',
                'first_name' => 'Operator',
                'last_name' => 'Operator',
                'username' => 'operator',
                'email' => 'operator@kongrepad.com',
                'password' => bcrypt('operator'),
                'status' => 1,
            ],
            [
                'customer_id' => '1',
                'user_role_id' => '3',
                'first_name' => 'User',
                'last_name' => 'User',
                'username' => 'user',
                'email' => 'user@kongrepad.com',
                'password' => bcrypt('user'),
                'status' => 1,
            ],
        ]);
    }
}
