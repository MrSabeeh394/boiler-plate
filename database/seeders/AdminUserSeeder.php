<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin portal permissions
        $permissions = [
            'manage-users',
            'impersonate-users',
            'view-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'portal' => 'admin'],
                ['guard_name' => 'web']
            );
        }

        // Create admin role
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'portal' => 'admin'],
            ['guard_name' => 'web']
        );

        // Assign all permissions to admin role
        $adminRole->syncPermissions($permissions);

        // Create admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role to user
        $adminUser->assignRole($adminRole);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
    }
}
