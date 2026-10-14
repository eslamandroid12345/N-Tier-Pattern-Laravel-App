<?php
namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * مسح كاش الفلاتر بالكامل
     */
    private function clearFilterCache(): void
    {
        /**
         * Removes Caches For Users Filter
         * users:filter:c4ca4238a0b923820dcc509a6f75849b
         * users:filter:9dcr4238a0b923820dcc509a6f75jmc4
         */
        Cache::forever('users_filter_version', time());//users filter
        Cache::forever('users_list_version', time());//users list

    }

    /**
     * عند إضافة مستخدم جديد
     */
    public function created(User $user): void
    {
        $this->clearFilterCache();
    }

    /**
     * عند تعديل بيانات المستخدم
     */
    public function updated(User $user): void
    {
        $filterFields = [
            'first_name',
            'last_name',
            'image',
            'email',
            'password',
            'phone',
            'verified',
            'active',
            'national_id',
            'dark_mode',
            'notifications',
            'language',
            'role_id',
            'created_at',
            'updated_at'
        ];

        if ($user->wasChanged($filterFields)) {
            $this->clearFilterCache();
        }
    }

    /**
     * عند الحذف (Soft Delete)
     */
    public function deleted(User $user): void
    {
        $this->clearFilterCache();
    }

    /**
     * عند استرجاع المستخدم
     */
    public function restored(User $user): void
    {
        $this->clearFilterCache();
    }

    /**
     * عند الحذف النهائي (Force Delete)
     */
    public function forceDeleted(User $user): void
    {
        $this->clearFilterCache();
    }
}
