<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        return Setting::query()->where('key',$key)->value('value');
    }

}


if (!function_exists('getCacheSetting')) {
    function getCacheSetting($key,$slug,$action): string
    {
        /**
         * Query Parameters: تجميع وترتيب كل معاملات البحث والصفحات
         */
        $params = request()->query();
        /**
         * ترتيب الحقول عشان ?page=1&role=2 تدي نفس مفتاح ?role=2&page=1
         */
        ksort($params);
        /**
         * جلب رقم الإصدار الحالي لمفتاح الكاش
         */
        $version = Cache::get($key, 1);
        /**
         * توليد مفتاح كاش فريد مشفّر بـ MD5 مرتبط بالإصدار
         * Example: users:v1:filter:c4ca4238a0b923820dcc509a6f75849b
         */
        return "{$slug}:v{$version}:{$action}:" . md5(http_build_query($params));

    }


    if (!function_exists('getCacheTtl')) {
        function getCacheTtl(): float|int
        {

            return 60 * 60 * 24 * 30;

        }
    }

    }
