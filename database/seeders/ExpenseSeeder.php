<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expense::create([
            'name' => 'Electricty Bill',
            'date' => '2023-05-01',
            'description' => 'Electricty Bill Electricty Bill',
            'amount' => 2500.00,
            'status' => 1,
        ]);

        Expense::create([
            'name' => 'Newspaper Bill',
            'date' => '2023-05-01',
            'description' => 'Newspaper Bill Newspaper Bill',
            'amount' => 2000.00,
            'status' => 1,
        ]);
    }
}
