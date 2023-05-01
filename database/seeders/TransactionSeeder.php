<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'account_id' => 1,
            'date' => '2023-05-01',
            'type' => 'Deposit',
            'description' => 'description',
            'amount' => 5000.00,
            'status' => 1,
        ]);

        Transaction::create([
            'account_id' => 2,
            'date' => '2023-04-01',
            'type' => 'Withdraw',
            'description' => 'description',
            'amount' => 5000.00,
            'status' => 1,
        ]);
    }
}
