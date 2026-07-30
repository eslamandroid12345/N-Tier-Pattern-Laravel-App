<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin = Role::where('name', 'Admin')->first();
        $viewer = Role::where('name', 'Viewer')->first();

        $allPermissions = Permission::all();
        $viewPermissions = Permission::where('slug', 'like', '%view%')->get();

        if ($superAdmin) {
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
        }

        if ($admin) {
            $admin->permissions()->sync($allPermissions->pluck('id'));
        }

        if ($viewer) {
            // الـ Viewer يأخذ صلاحيات العرض (View) فقط
            $viewer->permissions()->sync($viewPermissions->pluck('id'));
        }
    }
}
