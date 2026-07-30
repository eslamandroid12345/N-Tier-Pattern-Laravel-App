<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [];

        $sections = [
            'users' => ['Create', 'Update', 'View','Details','Delete'],
            'roles' => ['Create', 'Update', 'View','Details', 'Delete'],
        ];

        foreach ($sections as $section => $actions) {
            foreach ($actions as $action) {
                $permissions[] = [
                    'section'    => $section,
                    'name'       => $action,
                    'slug'       => $section . '-' .strtolower($action),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('permissions')->insert($permissions);
    }
}
