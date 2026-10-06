<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//        $this->call([
//            RoleSeeder::class,
//            PermissionSeeder::class,
//            RolePermissionSeeder::class,
//            UserSeeder::class,
//            SettingSeeder::class,
//        ]);

        User::factory()->count(100000)->create();

    }
}
