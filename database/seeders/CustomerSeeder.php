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
        Customer::insert([
            [
                'title' => 'D-Event',
                'description' => 'D-Event Turizm Organizasyon',
                'policy_status' => '1',
                'language' => 'en',
                'status' => '1',
            ],
        ]);

    }
}
