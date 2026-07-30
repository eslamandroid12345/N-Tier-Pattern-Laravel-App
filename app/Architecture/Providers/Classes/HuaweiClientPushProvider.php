<?php

namespace App\Architecture\Providers\Classes;

use App\Architecture\Providers\Interfaces\IHuaweiClientPushProvider;
use Illuminate\Support\Facades\Http;

class HuaweiClientPushProvider implements IHuaweiClientPushProvider
{
    private const TOKEN_URL = 'https://oauth-login.cloud.huawei.com/oauth2/v3/token';
    private const PUSH_URL = 'https://push-api.cloud.huawei.com/v1/%s/messages:send';
    protected static string $appId;
    protected static string $clientId;
    protected static string $clientSecret;

    public function __construct()
    {
        self::$appId = config("huawei.huawei_client.app_id");
        self::$clientId = config("huawei.huawei_client.client_id");
        self::$clientSecret  = config("huawei.huawei_client.client_secret");
    }


    private function getAccessToken()
    {
            $response = Http::withOptions(['verify' => false])->asForm()->post(
                self::TOKEN_URL,
                [
                    'grant_type' => 'client_credentials',
                    'client_id' =>  self::$clientId,
                    'client_secret' => self::$clientSecret,
                ]
            );

            if (!$response->successful()) {
                return response()->json([
                    'message' => 'Huawei Token Error: ' . $response->body()
                ], 500);
            }

            return $response->json()['access_token'];
    }


    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post(
            sprintf(self::PUSH_URL,self::$appId),
            [
                "validate_only" => false,
                "message" => [
                    "token" => [$deviceToken],

                    "notification" => [
                        "title" => $title,
                        "body" => $body
                    ],

                    "data" => json_encode($data),
                    "android" => [
                        "notification" => [
                            "click_action" => [
                                "type" => 3
                            ]
                        ]
                    ]
                ]
            ]
        );

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Huawei Push Error: ' .  $response->body()
            ], 500);
        }

//        return $response->json();//to test response
    }
}
