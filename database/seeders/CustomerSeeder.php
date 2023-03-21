<?php

namespace Database\Seeders;

use App\Models\Customer\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer_setting = [
            'timezone' => 'Europe/Istanbul',
            'address' => 'İçerenköy Mah. Çayır Cad. No:5 Bay Plaza Kat:12 Ataşehir İstanbul',
        ];
        Customer::insert([
            [
                'title' => 'D Event',
                'description' => 'D Event Turizm Organizasyon',
                'policy_status' => '1',
                'language' => 'en',
                'setting' => json_encode($customer_setting),
                'status' => '1',
            ],
        ]);

    }
}
