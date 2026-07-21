<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Permissions a founder can grant to an individual team member.
     * Founders themselves bypass these checks entirely (see User::canAccess()).
     */
    public const TEAM_PERMISSIONS = [
        'manage-orders',
        'manage-website',
        'manage-calendar',
        'use-copilot',
        'view-billing',
        'view-assets',
        'manage-crm',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['customer', 'staff', 'admin', 'outside_expert', 'team_member'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        foreach (self::TEAM_PERMISSIONS as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
