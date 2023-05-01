<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'name' => '5-10 MBPS',
            'description' => 'test description',
            'monthly_fee' => 500.00,
            'status' => 1,
        ]);

        Package::create([
            'name' => '10-15 MBPS',
            'description' => 'test description',
            'monthly_fee' => 1000.00,
            'status' => 1,
        ]);

        Package::create([
            'name' => '15-20 MBPS',
            'description' => 'test description',
            'monthly_fee' => 1500.00,
            'status' => 1,
        ]);
    }
}
