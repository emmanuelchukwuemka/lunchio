<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PackageSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            BlogPostSeeder::class,
            AdminUserSeeder::class,
            ExpertSeeder::class,
        ]);

        $customer = User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@launchio.test',
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');
    }
}
