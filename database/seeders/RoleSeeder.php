<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super Admin',
                'description' => 'Has full control and unrestricted access to all system features, settings, users, and configurations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'description' => 'Can manage day-to-day administrative tasks, user accounts, and content with some restrictions on system settings.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Viewer',
                'description' => 'Has read-only access to view data, reports, and dashboards without permission to create, edit, or delete any resources.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
