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
        Log::info("Synchronizing started: ".date('d/m/Y H:i:s'));
        $response = Http::get('https://yesilkongre.com/manager/public/api/event/participants?pid=2134&token=Bf2vPiVsDfCesI5ZbsX59femGzqNsgf4mtX96fsV')->timeout(-1);
        $values = $response->json();
        foreach ($values as $value) {
            $identification_number = $value['participant_id'];
            $username = $value['barcode'];
            $title = $value['title'];
            $first_name = $value['name'];
            $last_name = $value['surname'];
            $email = $value['email'];
            $phone = $value['phone'];
            if($phone) {
                $phone_country_code = 223;
            } else {
                $phone_country_code = null;
            }
            $enrolled = $value['status'];
            $password = $value['id'];
            $register_type = $value['registerType'];
            if ($register_type=='KATILIMCI' || $register_type=='KONUŞMACI' || $register_type=='MODERATÖR') {
                $type = "attendee";
            } elseif ($register_type=='FİRMA TEMSİLCİSİ' || $register_type=='STANDI OLMAYAN FİRMA TEMSİLCİSİ') {
                $type = "agent";
            } elseif ($register_type=='GÖREVLİ' || $register_type=='SANATÇI' || $register_type=='ÇILGINLAR KULÜBÜ') {
                $type = "team";
            } else {
                Log::info("Type error!");
            }
            Participant::updateOrCreate(
                ['identification_number' => $identification_number],
                [
                    'meeting_id' => 1,
                    'username' => $identification_number,
                    'title' => $title,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'identification_number' => $identification_number,
                    'organisation' => 'Belirtilmemiş',
                    'email' => $email,
                    'phone_country_id' => $phone_country_code,
                    'phone' => $phone,
                    'password' => $identification_number,
                    'type' => $identification_number,
                    'enrolled' => $enrolled,
                    'gdpr_consent' => 0,
                    'status' => 1,
                ]
            );
            Log::info("UOC: $identification_number:$username:$title:$first_name:$last_name:$email:$phone:$enrolled:$password:$type");
        }
        Log::info("Synchronizing finished: ".date('d/m/Y H:i:s'));
        Log::info("---------------------------------------------------------");
    }
}
