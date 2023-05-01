<?php

namespace Database\Seeders;

use App\Models\Bill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bill::create([
            'customer_id' => 1,
            'month' => 'January',
            'year' => '2023',
            'amount' => 500.00,
            'status' => 'unpaid',
        ]);

        Bill::create([
            'customer_id' => 2,
            'month' => 'February',
            'year' => '2023',
            'amount' => 1500.00,
            'status' => 'paid',
        ]);

        Bill::create([
            'customer_id' => 3,
            'month' => 'March',
            'year' => '2023',
            'amount' => 2500.00,
            'status' => 'paid',
        ]);
    }
}
