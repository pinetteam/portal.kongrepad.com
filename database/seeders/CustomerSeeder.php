<?php

namespace Database\Seeders;

use App\Models\Customer\Customer;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $icon = Image::make(asset('favicon.ico'))->encode('data-url');
        Customer::insert([
            [
                'code' => 'devent',
                'title' => 'D-Event',
                'icon' => $icon,
                'language' => 'en',
                'status' => '1',
            ],
            [
                'code' => 'pievent',
                'title' => 'Pi-Event',
                'icon' => $icon,
                'language' => 'tr',
                'status' => '1',
            ],
        ]);
    }
}
