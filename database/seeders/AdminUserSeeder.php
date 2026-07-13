<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Admin/staff accounts are seeded, not self-registrable, per the build plan
     * ("admin/staff accounts only created via seeder"). Change these passwords
     * immediately in any non-local environment.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@launchio.test'],
            [
                'name' => 'Launchio Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        $staff = User::updateOrCreate(
            ['email' => 'staff@launchio.test'],
            [
                'name' => 'Launchio Staff',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        $staff->syncRoles(['staff']);
    }
}
