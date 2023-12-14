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
                'last_name' => 'D-Event',
                'email' => 'manager@devent.com.tr',
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
            [
                'customer_id' => '1',
                'user_role_id' => '2',
                'username' => 'operator',
                'first_name' => 'Operator',
                'last_name' => 'D-Event',
                'email' => 'operator@devent.com.tr',
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
            [
                'customer_id' => '1',
                'user_role_id' => '3',
                'username' => 'user',
                'first_name' => 'User',
                'last_name' => 'D-Event',
                'email' => 'user@devent.com.tr',
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
            [
                'customer_id' => '3',
                'user_role_id' => '1',
                'username' => 'educcon',
                'first_name' => 'Admin',
                'last_name' => 'Educcon',
                'email' => 'admin@educcon.com.tr',
                'email_verified_at' => now(),
                'phone_country_id' => '223',
                'phone' => '5555555555',
                'phone_verified_at' => now(),
                'password' => bcrypt('A679e297s'),
                'register_ip' => $faker1->ipv4,
                'register_user_agent' => $faker1->userAgent,
                'last_login_ip' => $faker1->ipv4,
                'last_login_agent' => $faker1->userAgent,
                'last_login_datetime' => date('Y-m-d H:i:s'),
                'status' => 1,
            ],
            [
                'customer_id' => '4',
                'user_role_id' => '1',
                'username' => 'test_admin',
                'first_name' => 'Admin',
                'last_name' => 'Test',
                'email' => 'admin@test.com.tr',
                'email_verified_at' => now(),
                'phone_country_id' => '223',
                'phone' => '5555555555',
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
