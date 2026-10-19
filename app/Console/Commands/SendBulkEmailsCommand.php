<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\SendEmailChunkJob;

class SendBulkEmailsCommand extends Command
{
    protected $signature = 'emails:send-bulk';
    protected $description = 'Dispatch 6 million users in chunks of 1000 to the queue';

    public function handle(): void
    {
        $this->info("بدء تجهيز وتقسيم المستخدمين...");

        $chunkSize = 1000;
        $counter = 0;

        User::query()
            ->select('id')
            ->chunkById($chunkSize, function ($users) use (&$counter) {

                // 1. بنحول الـ 1,000 كائن لمصفوفة أرقام بسيطة: [1001, 1002, ... 2000]
                $ids = $users->pluck('id')->toArray();

                // 2. بنرمي الـ 1,000 رقم دول في Job ونبعتها للـ Queue
                SendEmailChunkJob::dispatch($ids);

                $counter += count($ids);
                $this->line("تم إرسال {$counter} مستخدم إلى الطابور...");
            });

        $this->info("تم الانتهاء! كل الـ 6 مليون مستخدم اتقسموا واتحطوا في الـ Queue بنجاح.");
    }
}
