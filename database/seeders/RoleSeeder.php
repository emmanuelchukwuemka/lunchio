<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['customer', 'staff', 'admin', 'outside_expert'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
