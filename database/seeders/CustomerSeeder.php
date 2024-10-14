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
                'code' => 'kongrepad',
                'title' => 'KongrePad',
                'credit' => 10000,
                'language' => 'tr',
                'status' => '1',
            ],
        ]);
    }
}
