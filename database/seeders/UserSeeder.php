<?php

namespace Database\Seeders;

use App\Models\User\User;
use Faker\Factory;
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
        $faker1 = Factory::create();
        User::insert([
            [
                'customer_id' => '1',
                'user_role_id' => '1',
                'username' => 'manager',
                'first_name' => 'Manager',
                'last_name' => 'KongrePad',
                'email' => 'info@kongrepad.com',
                'email_verified_at' => now(),
                'phone_country_id' => '223',
                'phone' => '5308266897',
                'phone_verified_at' => now(),
                'password' => bcrypt('A679e297s'),
                'register_ip' => $faker1->ipv4,
                'register_user_agent' => $faker1->userAgent,
                'last_login_ip' => $faker1->ipv4,
                'last_login_agent' => $faker1->userAgent,
                'last_login_datetime' => date('Y-m-d H:i:s'),
                'status' => 1,
            ],
        ]);
    }
}
