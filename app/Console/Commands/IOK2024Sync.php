<?php

namespace App\Console\Commands;

use App\Models\Meeting\Participant\Participant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class IOK2024Sync extends Command
{
    protected $signature = 'app:iok2024-sync';

    protected $description = 'İmmünoterapi ve Onkoloji Kongresi 2024';

    public function handle()
    {
        Log::info("---------------------------------------------------------");
        Log::info("Synchronizing started: ".date('d/m/Y H:i:s'));
        $response = file_get_contents('https://yesilkongre.com/manager/public/api/event/participants?pid=2330&token=scy8BYdU65KXQJobkWam0BPuanQnDFwuLFzm1FlZ');
        $values = json_decode($response, true);
        foreach ($values as $value) {
            $identification_number = $value['participant_id'];
            $username = $value['barcode'];
            if($username) {
                $username = $value['barcode'];
            } else {
                $username = $identification_number;
            }
            //$title = $value['title'];
            $title = null;
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
                    'username' => $username,
                    'title' => $title,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'identification_number' => $identification_number,
                    'organisation' => 'Belirtilmemiş',
                    'email' => $email,
                    'phone_country_id' => $phone_country_code,
                    'phone' => $phone,
                    'password' => $password,
                    'type' => $type,
                    'enrolled' => $enrolled,
                    'gdpr_consent' => 0,
                    'status' => 1,
                ]
            );
            Log::info("UOC: $username:$title:$first_name:$last_name:$identification_number:$email:$phone_country_code:$phone:$password:$type:$enrolled");
        }
        Log::info("Synchronizing finished: ".date('d/m/Y H:i:s'));
        Log::info("---------------------------------------------------------");
    }
}
