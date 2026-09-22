<?php
namespace Database\Seeders;

use App\Enum\SettingType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('settings')->insert([
            [
                'slug' => 'Pagination Limits',
                'key' => 'pagination_limits',
                'value' => 30,
                'setting_type' => SettingType::PROCESS,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'App Name',
                'key' => 'app_name',
                'value' => 'Initial Project',
                'setting_type' => SettingType::GENERAL,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

    }
}
