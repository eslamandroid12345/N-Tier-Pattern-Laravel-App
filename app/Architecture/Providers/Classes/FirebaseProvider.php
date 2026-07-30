<?php

namespace App\Architecture\Providers\Classes;

use App\Architecture\Providers\Interfaces\IFirebaseProvider;
use App\Architecture\Repositories\Interfaces\IUserDeviceRepository;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Log;

class FirebaseProvider implements IFirebaseProvider
{
    public function __construct(
        protected IUserDeviceRepository   $userDeviceRepository,
    )
    {
    }

    public function handle($fcm, $title, $content, $extraData = [])
    {
        $credentialsFilePath = base_path('public/json/firebase-auth.json');//Add file firebase auth

        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        $access_token = $token['access_token'];

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "token" => $fcm,
                "notification" => [
                    "title" => $title,
                    "body" => $content,
                ],
                "data" => empty($extraData) ? (object)[] : $extraData
            ]
        ];
        $payload = json_encode($data);

        Log::channel('firebase_info')->info("Payload => {$payload}");

        $url = 'https://fcm.googleapis.com/v1/projects/rdapp-client/messages:send';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $decodedResponse = $response ? json_decode($response, true) : null;


        if ($err) {
            Log::channel('firebase_error')->error('Failed to send Firebase notification (cURL Error).', [
                'action'    => 'send_fcm_notification',
                'endpoint'  => $url,
                'payload'   => $fcm,
                'curl_err'  => $err,
            ]);            return response()->json([
                'message' => 'Curl Error: ' . $err
            ], 500);
        } else {
            Log::channel('firebase_info')->info('Successfully sent Firebase notification.', [
                'action'    => 'send_fcm_notification',
                'endpoint'  => $url,
                'payload'   => $fcm,
                'response'  => $decodedResponse,
            ]);
            return response()->json([
                'message' => 'Notification has been sent',
                'response' => json_decode($response, true)
            ]);
        }
    }
}
