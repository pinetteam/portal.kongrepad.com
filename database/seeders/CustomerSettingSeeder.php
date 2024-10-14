<?php

namespace Database\Seeders;

use App\Models\Customer\Setting\Setting;
use Illuminate\Database\Seeder;

class CustomerSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::insert([
            [
                'customer_id' => '1',
                'variable_id' => '1',
                'value' => 'https://www.kongrepad.com/',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '2',
                'value' => 'info@kongrepad.com',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '3',
                'value' => '+90 (312) 911 9113',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '4',
                'value' => 'Bahçelievler Mah. 323/1 Cadde 10/50C No: 65, Gölbaşı/Ankara',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '5',
                'value' => 'Europe/Istanbul',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '6',
                'value' => 'Y-m-d',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '7',
                'value' => '24H',
            ],

            [
                'customer_id' => '1',
                'variable_id' => '8',
                'value' => '#',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '9',
                'value' => '#',
            ],
            [
                'customer_id' => '1',
                'variable_id' => '10',
                'value' => '#',
            ],
        ]);
    }
}
