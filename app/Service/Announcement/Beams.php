<?php

namespace App\Service\Announcement;

use Pusher\PushNotifications\PushNotifications;

class Beams
{
    protected PushNotifications $beamsClient;

    /**
     * Beams constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->beamsClient = new PushNotifications([
            'instanceId' => config('services.pusher.beams_instance_id'),
            'secretKey'  => config('services.pusher.beams_secret_key'),
        ]);
    }

    /**
     * Bildirim gönderme işlemi.
     *
     * @param array $interests İlgi alanları (ör. kullanıcı grupları)
     * @param string $title Bildirim başlığı
     * @param string $body Bildirim içeriği
     * @param array $data Ek veri (isteğe bağlı)
     * @return array Başarı veya hata mesajı
     */
    public function sendNotification(array $interests, string $title, string $body): array
    {
        try {
            // FCM yapısını JSON nesnesi olarak oluşturuyoruz
            $fcmPayload = json_decode(json_encode([
                "notification" => [
                    "title" => $title,
                    "body"  => $body,
                ],
            ]));

            // APNs yapısını JSON nesnesi olarak oluşturuyoruz
            $apnsPayload = json_decode(json_encode([
                "aps" => [
                    "alert" => [
                        "title" => $title,
                        "body"  => $body,
                    ],
                ],
            ]));

            // Pusher Beams'e bildirim gönderiliyor
            $response = $this->beamsClient->publishToInterests(
                $interests,
                [
                    "fcm" => $fcmPayload,  // FCM için JSON uyumlu yapı
                    "apns" => $apnsPayload,  // APNs için JSON uyumlu yapı
                ]
            );

            return [
                'success'  => true,
                'response' => $response,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
