<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $password = Hash::make('password123');

        DB::table('users')->insert([
            [
                'first_name' => 'Ahmed',
                'last_name' => 'Ali',
                'email' => 'superadmin@example.com',
                'phone' => '01053988710',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 1, // Super Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Rady',
                'last_name' => 'Gamal',
                'email' => 'admin.jane@example.com',
                'phone' => '01053988769',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 2, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Sayed',
                'last_name' => 'Hammed',
                'email' => 'admin.mike@example.com',
                'phone' => '01053988768',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 2, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Gamal',
                'last_name' => 'Hesham',
                'email' => 'admin.emily@example.com',
                'phone' => '01053988767',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 2, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Mohammed',
                'last_name' => 'Hassan',
                'email' => 'viewer.david@example.com',
                'phone' => '01053988766',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 3, // Viewer
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Rady',
                'email' => 'viewer.sarah@example.com',
                'phone' => '01053988765',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 3, // Viewer
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Wilson',
                'email' => 'viewer.james@example.com',
                'phone' => '01053988764',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 3, // Viewer
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jessica',
                'last_name' => 'Taylor',
                'email' => 'viewer.jessica@example.com',
                'phone' => '01053988763',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 3, // Viewer
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Daniel',
                'last_name' => 'Anderson',
                'email' => 'viewer.daniel@example.com',
                'phone' => '01053988762',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => false,
                'role_id' => 3, // Viewer
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Thomas',
                'last_name' => 'Harris',
                'email' => 'viewer.thomas@example.com',
                'phone' => '01053988761',
                'email_verified_at' => now(),
                'password' => $password,
                'active' => true,
                'role_id' => 3, // Viewer
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
