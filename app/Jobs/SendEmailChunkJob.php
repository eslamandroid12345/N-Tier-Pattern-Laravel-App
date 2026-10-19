<?php

namespace App\Jobs;

use App\Architecture\Repositories\Interfaces\INotificationRepository;
use App\Enum\NotificationType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendEmailChunkJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $userIds,
    )
    {
        $this->onQueue('bulk-emails');
    }

    /**
     * الدالة دي هي اللي العامل (Worker) بينفذها في الخلفية
     */
    public function handle(INotificationRepository $notificationRepository): void
    {
        foreach ($this->userIds as $userId) {
            try {

            $notificationRepository->create([
                'title_en' => 'This an update in system check him now',
                'title_ar' => 'يوجد تحديث الان يرجي تفقده .',
                'content_en' => 'This an update in system check him now',
                'content_ar' => 'يوجد تحديث الان يرجي تفقده .',
                'type' => NotificationType::GENERAL->value,
                'user_id' => $userId,
            ]);
            } catch (\Throwable $e) {
                // 4. بنسجل اللوج ونكمل اللوب بدون أي تعطيل لباقي المستخدمين
                logger()->error("Failed to create notification for User ID {$userId}: {$e->getMessage()}", [
                    'user_id' => $userId,
                    'exception' => $e,
                ]);
            }
        }
    }
}
