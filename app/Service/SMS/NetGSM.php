<?php

namespace App\Service\SMS;

use Exception;
use Illuminate\Support\Facades\Log;

class NetGSM
{
    protected string $api_url;
    protected string $username;
    protected string $password;
    protected string $header;
    protected string $app_key;

    /**
     * NetGSMService Constructor
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
     * Send SMS to multiple recipients (bulk SMS)
     *
     * @param array $recipients
     * @param string $message
     * @return string
     * @throws Exception
     */
    public function sendToMany(array $recipients, string $message): string
    {
        // Alıcıları XML formatında oluştur
        $recipients_xml = '';
        foreach ($recipients as $recipient) {
            $recipients_xml .= "<no>{$recipient}</no>";
        }

        // XML formatını oluşturun
        $xml_data = $this->buildXML($recipients_xml, $message, '1:n');

        // XML POST isteğini gönder
        $response = $this->makeXMLPostRequest($this->api_url, $xml_data);

        // Yanıtı logla ve hata kodunu kontrol et
        return $this->processResponse($response);
    }

    /**
     * Send SMS to a single recipient
     *
     * @param string $recipient
     * @param string $message
     * @return string
     * @throws Exception
     */
    public function sendToOne(string $recipient, string $message): string
    {
        // Alıcıyı XML formatında oluştur
        $recipients_xml = "<no>{$recipient}</no>";

        // XML formatını oluşturun
        $xml_data = $this->buildXML($recipients_xml, $message, '1:n');

        // XML POST isteğini gönder
        $response = $this->makeXMLPostRequest($this->api_url, $xml_data);

        // Yanıtı logla ve hata kodunu kontrol et
        return $this->processResponse($response);
    }

    /**
     * Build XML Data
     *
     * @param string $recipients_xml
     * @param string $message
     * @param string $type
     * @return string
     */
    protected function buildXML(string $recipients_xml, string $message, string $type): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
            <mainbody>
                <header>
                    <company dil="TR">Netgsm</company>
                    <usercode>' . $this->username . '</usercode>
                    <password>' . $this->password . '</password>
                    <appkey>' . $this->app_key . '</appkey>
                    <type>' . $type . '</type>
                    <msgheader>' . $this->header . '</msgheader>
                </header>
                <body>
                    <msg><![CDATA[' . $message . ']]></msg>
                    ' . $recipients_xml . '
                </body>
            </mainbody>';
    }

    /**
     * Process API Response
     *
     * @param string $response
     * @return string
     * @throws Exception
     */
    protected function processResponse(string $response): string
    {
        // Hata kodlarını kontrol edin
        $code = strtok($response, ','); // Yanıttaki hata kodunu al
        $message = $this->getErrorMessage($code);

        // Hata varsa logla ve exception at
        if ($code !== '00') {
            Log::error("NetGSM Error: [Code: $code] $message");
            throw new Exception("NetGSM Error: $message");
        }

        // Başarılı ise logla
        Log::info("NetGSM Success: $response");

        return $response;
    }

    /**
     * Map Error Code to Error Message
     *
     * @param string $code
     * @return string
     */
    protected function getErrorMessage(string $code): string
    {
        $errors = [
            '00' => 'Mesaj başarıyla gönderildi.',
            '20' => 'Sistem hatası.',
            '30' => 'Geçersiz kullanıcı adı veya şifre.',
            '40' => 'Gönderim yapılacak başlık onaylanmamış.',
            '50' => 'Mesaj metni boş.',
            '60' => 'Geçersiz alıcı numarası.',
            // Daha fazla hata kodu eklenebilir
        ];

        return $errors[$code] ?? 'Bilinmeyen hata.';
    }

    /**
     * cURL ile XML POST İsteği Gönderimi
     *
     * @param string $url
     * @param string $xml_data
     * @return string
     * @throws Exception
     */
    protected function makeXMLPostRequest(string $url, string $xml_data): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }
}
