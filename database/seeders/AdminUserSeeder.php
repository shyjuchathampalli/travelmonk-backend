<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'master_admin']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@travelmonk.com'],
            [
                'name' => 'Master Admin',
                'password' => Hash::make('Admin@123'),
            ]
        );

        $admin->syncRoles([$role]);
    }
}
