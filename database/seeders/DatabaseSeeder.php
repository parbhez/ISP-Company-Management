<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(BillSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(TransactionSeeder::class);
    }
}
