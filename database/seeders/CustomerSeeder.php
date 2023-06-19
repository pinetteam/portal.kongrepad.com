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
                'language' => 'en',
                'status' => '1',
            ],
            [
                'title' => 'P-E',
                'language' => 'tr',
                'status' => '1',
            ],
        ]);

    }
}
