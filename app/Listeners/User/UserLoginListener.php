<?php

namespace App\Listeners\User;

use App\Architecture\Providers\Interfaces\IFirebaseProvider;
use App\Architecture\Providers\Interfaces\IHuaweiClientPushProvider;
use App\Architecture\Repositories\Interfaces\INotificationRepository;
use App\Architecture\Repositories\Interfaces\IUserDeviceRepository;
use App\Enum\DeviceType;
use App\Enum\NotificationType;
use App\Events\User\UserLogin;
use Illuminate\Support\Facades\Log;

class UserLoginListener
{

    public function __construct(
        private readonly IUserDeviceRepository $userDeviceRepository,
        private readonly IFirebaseProvider     $firebaseProvider,
        private readonly IHuaweiClientPushProvider $huaweiClientPushProvider,
        private readonly INotificationRepository   $notificationRepository,
    )
    {
    }

    public function handle(UserLogin $event): void
    {
        try {
            $messageContent = $this->generateMessageContent();

            $targetUser = $event->user;

            $androidAndIosTokens = $this->userDeviceRepository->androidAndIosTokens([$targetUser->id]);
            $huaweiTokens = $this->userDeviceRepository->huaweiTokens([$targetUser->id]);
            $webTokens = $this->userDeviceRepository->webTokens([$targetUser->id]);

            $this->storeNotification($targetUser, $event, $messageContent);
            $this->sendPushNotification($targetUser,$androidAndIosTokens,$huaweiTokens, $webTokens,$messageContent);

        } catch (\Exception $e) {
           return;
        }
    }


    private function generateMessageContent(): array
    {
        return [
            'title_en' => 'Welcome,back to app.',
            'title_ar' => 'اهلا بك من جديد.',
            'content_en' => 'Welcome,back to app.',
            'content_ar' => 'اهلا بك من جديد.',
            'type' => NotificationType::GENERAL->value
        ];
    }

    private function storeNotification($targetUser,UserLogin $event, array $messageContent): void
    {
        $data = [
            'user_id' => $targetUser->id,
            'title_en' => $messageContent['title_en'],
            'title_ar' => $messageContent['title_ar'],
            'content_en' => $messageContent['content_en'],
            'content_ar' => $messageContent['content_ar'],
            'item' => null,
            'type' => $messageContent['type'],
        ];
        $this->notificationRepository->create($data);
    }


    private function sendPushNotification($targetUser,$androidAndIosTokens,$huaweiTokens,$webTokens,$notificationData): void
    {

        try {
            $androidToken = collect($androidAndIosTokens)
                ->firstWhere('device',DeviceType::ANDROID->value)['token'] ?? null;

            $iosToken = collect($androidAndIosTokens)
                ->firstWhere('device',DeviceType::IOS->value)['token'] ?? null;

            $huaweiToken = collect($huaweiTokens)
                ->firstWhere('device',DeviceType::HUAWEI->value)['token'] ?? null;

            $webToken = collect($webTokens)
                ->firstWhere('device', DeviceType::WEBSITE->value)['token'] ?? null;
//            dd([
//                'android_token' => $androidToken,
//                'ios_token' => $iosToken,
//                'huawei_token' => $huaweiToken,
//                'web_token' =>  $webToken,
//            ]);
            $locale = $targetUser->language ?? config('app.locale');
            $title = $notificationData["title_{$locale}"];
            $content = $notificationData["content_{$locale}"];
            $this->firebaseProvider->handle($androidToken, $title, $content);
            $this->firebaseProvider->handle($iosToken, $title, $content);
            $this->firebaseProvider->handle($webToken, $title, $content);
            $this->huaweiClientPushProvider->sendNotification($huaweiToken, $title, $content);

            Log::info('Android Firebase Push Notification Successfully With Invite Or Request::::', [
                'android_token' => $androidToken
            ]);

            Log::info('Ios Firebase Push Notification Successfully With Invite Or Request::::', [
                'ios_token' => $iosToken
            ]);

            Log::info('Huawei Push Notification Successfully With Invite Or Request::::', [
                'huawei_token' => $huaweiToken
            ]);
        } catch (\Exception $e) {
            Log::error('Failed To Send Push Notification:::: ' . $e->getMessage(), [
                'token' => 'Error!'
            ]);
        }
    }
}
