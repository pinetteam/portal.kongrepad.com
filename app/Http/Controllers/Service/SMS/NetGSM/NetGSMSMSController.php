<?php

namespace App\Http\Controllers\Service\SMS\NetGSM;

use App\Http\Controllers\Controller;
use Exception;

class NetGSMSMSController extends Controller
{
    protected $api_url;
    protected $username;
    protected $password;
    protected $header;
    protected $app_key;

    /**
     * NetgsmService Constructor
     */
    public function __construct()
    {
        $this->api_url = 'https://api.netgsm.com.tr/sms/send/xml';
        $this->username = config('sms.netgsm.username');
        $this->password = config('sms.netgsm.password');
        $this->header = config('sms.netgsm.header');
        $this->app_key = config('sms.netgsm.app_key');
    }

    /**
     * SMS Gönder
     *
     * @param string $message
     * @param array $recipients
     * @return mixed
     * @throws Exception
     */
    public function sendSms(string $message, string $recipient)
    {
        $xmlData = '<?xml version="1.0" encoding="UTF-8"?>
            <mainbody>
                <header>
                    <company dil="TR">Netgsm</company>
                    <usercode>' . $this->username . '</usercode>
                    <password>' . $this->password . '</password>
                    <type>1:n</type>
                    <msgheader>' . $this->header . '</msgheader>
                </header>
                <body>
                    <msg><![CDATA[' . $message . ']]></msg>
                    <no>0' . $recipient . '</no>
                </body>
            </mainbody>';

        // cURL ile XML POST isteği gönder
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }
}
