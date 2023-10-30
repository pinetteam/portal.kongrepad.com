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
        $faker2 = Factory::create();
        User::insert([
            [
                'customer_id' => '1',
                'user_role_id' => '1',
                'username' => 'manager1',
                'first_name' => 'Manager',
                'last_name' => 'D-Event',
                'email' => 'manager@devent.com.tr',
                'email_verified_at' => now(),
                'phone_country_id' => '223',
                'phone' => '5432109871',
                'phone_verified_at' => now(),
                'password' => bcrypt('manager1'),
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
                'username' => 'operator1',
                'first_name' => 'Operator',
                'last_name' => 'D-Event',
                'email' => 'operator@devent.com.tr',
                'email_verified_at' => now(),
                'phone_country_id' => '223',
                'phone' => '5432109872',
                'phone_verified_at' => now(),
                'password' => bcrypt('operator1'),
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
                'username' => 'user1',
                'first_name' => 'User',
                'last_name' => 'D-Event',
                'email' => 'user@devent.com.tr',
                'email_verified_at' => now(),
                'phone_country_id' => '223',
                'phone' => '5432109873',
                'phone_verified_at' => now(),
                'password' => bcrypt('user1'),
                'register_ip' => $faker1->ipv4,
                'register_user_agent' => $faker1->userAgent,
                'last_login_ip' => $faker1->ipv4,
                'last_login_agent' => $faker1->userAgent,
                'last_login_datetime' => date('Y-m-d H:i:s'),
                'status' => 1,
            ],
            [
                'customer_id' => '2',
                'user_role_id' => '1',
                'username' => 'testmanager',
                'first_name' => 'Manager',
                'last_name' => 'T-Event',
                'email' => 'manager@test.com.tr',
                'email_verified_at' => now(),
                'phone_country_id' => '223',
                'phone' => '549750530',
                'phone_verified_at' => now(),
                'password' => bcrypt('testmanager'),
                'register_ip' => $faker2->ipv4,
                'register_user_agent' => $faker2->userAgent,
                'last_login_ip' => $faker2->ipv4,
                'last_login_agent' => $faker2->userAgent,
                'last_login_datetime' => date('Y-m-d H:i:s'),
                'status' => 1,
            ],
        ]);


    }
}
