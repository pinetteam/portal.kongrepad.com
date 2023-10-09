<?php

namespace Database\Seeders;

use App\Models\Customer\Customer;
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
                'code' => 'devent',
                'title' => 'D-Event',
                'language' => 'en',
                'status' => '1',
            ],
        ]);
    }
}
