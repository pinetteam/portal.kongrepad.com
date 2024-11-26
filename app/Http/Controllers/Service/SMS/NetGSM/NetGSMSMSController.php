<?php

namespace App\Http\Controllers\Service\SMS\NetGSM;

use App\Http\Controllers\Controller;
use Exception;
use SoapClient;
use SoapFault;

class NetGSMSMSController extends Controller
{
    protected $username;
    protected $password;
    protected $header;
    protected $app_key;
    protected $client;

    public function __construct()
    {
        $this->username = config('services.netgsm.username');
        $this->password = config('services.netgsm.password');
        $this->header = config('services.netgsm.header');
        $this->app_key = config('services.netgsm.app_key');

        $wsdl = 'https://soap.netgsm.com.tr:4443/Sms_webservis/SMS?wsdl';

        try {
            $this->client = new SoapClient($wsdl);
        } catch (SoapFault $e) {
            throw new Exception("SOAP Client oluşturulurken hata oluştu: " . $e->getMessage());
        }
    }

    public function sendSms(array $recipients, string $message, string $encoding = 'TR')
    {
        if (empty($recipients) || empty($message)) {
            throw new Exception('Alıcılar ve mesaj boş olamaz.');
        }

        $gsmNumbers = implode(',', $recipients);

        $parameters = [
            'username' => $this->username,
            'password' => $this->password,
            'header'   => $this->header,
            'msg'      => $message,
            'gsm'      => $gsmNumbers,
            'filter'   => '0',
            'encoding' => $encoding,
            'appkey'   => $this->app_key,
        ];

        try {
            $response = $this->client->smsGonder1NV2($parameters);
            return $this->parseResponse($response);
        } catch (SoapFault $e) {
            throw new Exception("SOAP isteği sırasında hata oluştu: " . $e->getMessage());
        }
    }

    protected function parseResponse($response)
    {
        if (is_object($response) && isset($response->smsGonder1NV2Result)) {
            $result = $response->smsGonder1NV2Result;
            if (strpos($result, '00') === 0) {
                return "SMS başarıyla gönderildi. İşlem Kodu: " . $result;
            } else {
                return "SMS gönderiminde hata oluştu. Hata Kodu: " . $result;
            }
        } else {
            throw new Exception("Geçersiz yanıt alındı.");
        }
    }

}
