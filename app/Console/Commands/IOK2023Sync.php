<?php

namespace App\Console\Commands;

use App\Models\Meeting\Participant\Participant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IOK2023Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:iok2023-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'İmmünoterapi ve Onkoloji Kongresi 2023';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("---------------------------------------------------------");
        Log::info("Yeşil Kongre ile eşitleme başladı: ".date('d/m/Y H:i:s'));
        $response = Http::get('https://yesilkongre.com/manager/public/api/event/participants?pid=2134&token=Bf2vPiVsDfCesI5ZbsX59femGzqNsgf4mtX96fsV');
        $values = $response->json();
        $data = [];
        foreach ($values as $value) {
            $identification_number = $value['participant_id'];
            $username = $value['barcode'];
            $title = $value['title'];
            $first_name = $value['name'];
            $last_name = $value['surname'];
            $email = $value['email'];
            $phone = $value['phone'];
            $enrolled = $value['status'];
            $password = $value['id'];
            $type = $value['registerType'];
            Participant::updateOrCreate(
                ['identification_number' => $identification_number],
                [
                    'meeting_id' => 1,
                    'username' => $identification_number,
                    'title' => $identification_number,
                    'first_name' => $identification_number,
                    'last_name' => $identification_number,
                    'identification_number' => $identification_number,
                    'organisation' => $identification_number,
                    'email' => $identification_number,
                    'phone_country_id' => $identification_number,
                    'phone' => $identification_number,
                    'password' => $identification_number,
                    'type' => $identification_number,
                    'enrolled' => $identification_number,
                    'gdpr_consent' => $identification_number,
                    'status' => $identification_number,
                ]
            );

            Log::info("$identification_number:$username:$title:$first_name:$last_name:$email:$phone:$enrolled:$password:$type");
        }
        Log::info("Yeşil Kongre ile eşitleme bitti: ".date('d/m/Y H:i:s'));
        Log::info("---------------------------------------------------------");
    }
}
