<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'name' => 'Masud Parbhez',
            'account_number' => '00000001',
            'type' => 'Assets',
            'description' => 'Description',
            'balance' => 12500.00,
            'status' => 1,
        ]);

        Account::create([
            'name' => 'Minhajur Rahman',
            'account_number' => '00000002',
            'type' => 'Liabilities',
            'description' => 'Description',
            'balance' => 18500.00,
            'status' => 1,
        ]);
    }
}
