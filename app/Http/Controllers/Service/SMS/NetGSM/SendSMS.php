<?php

namespace App\Http\Controllers\Service\SMS\NetGSM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SendSMS extends Controller
{
    public static function toMany($country_code, $phone_number, $message)
    {
        $request = '<?xml version="1.0" encoding="UTF-8"?>
        <mainbody>
            <header>
                <company dil="TR">NETGSM</company>
                <usercode>3129119113</usercode>
                <password>PD1PS2QU</password>
                <type>1:n</type>
                <msgheader>PiNET</msgheader>
            </header>
            <body>
                <msg><![CDATA[' . $message . ']]></msg>
                <no>' . $country_code . $phone_number . '</no>
            </body>
        </mainbody>';
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, "http://api.netgsm.com.tr/xmlbulkhttppost.asp" );
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($connection, CURLOPT_POST, TRUE);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $request);
        curl_setopt($connection, CURLOPT_TIMEOUT, 30);
        curl_setopt($connection, CURLOPT_HTTPHEADER, [
            'Content-Type: text/xml'
        ]);
        $response = curl_exec($connection);
        curl_close($connection);
        $result = strip_tags(substr($response, 0, 2));
        if ($result=="00")
        {
            return TRUE;
        } elseif ($result=="01" || $result=="02") {
            return FALSE;
        }
    }
}
