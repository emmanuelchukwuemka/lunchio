<?php

namespace Database\Seeders;

use App\Models\Expert;
use Illuminate\Database\Seeder;

class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Placeholder directory entries for the marketplace scaffold (future roadmap).
     */
    public function run(): void
    {
        $experts = [
            [
                'name' => 'Chidi Eze',
                'specialty' => 'Corporate & Business Law',
                'bio' => 'Advises early-stage founders on company structuring and compliance.',
                'status' => 'active',
            ],
            [
                'name' => 'Funmi Lawal',
                'specialty' => 'Brand Strategy',
                'bio' => 'Helps founders sharpen their positioning before a full brand build.',
                'status' => 'active',
            ],
            [
                'name' => 'Segun Adewale',
                'specialty' => 'Growth Marketing',
                'bio' => 'Works with Growth tier subscribers on customer acquisition strategy.',
                'status' => 'active',
            ],
        ];

        foreach ($experts as $data) {
            Expert::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
