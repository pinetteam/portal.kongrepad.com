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
        $settings = [
            'timezone' => 'Europe/Istanbul',
            'date-format' => 'd/m/Y',
            'time-format' => 'H:i',
            'address' => 'İçerenköy Mah. Çayır Cad. No:5 Bay Plaza Kat:12 Ataşehir İstanbul',
        ];
        Customer::insert([
            [
                'title' => 'D-Event',
                'description' => 'D-Event Turizm Organizasyon',
                'policy_status' => '1',
                'language' => 'en',
                'settings' => json_encode($settings),
                'status' => '1',
            ],
        ]);

    }
}
