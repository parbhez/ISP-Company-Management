<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Customer 1',
            'package_id' => 1,
            'email' => 'customer1@gmail.com',
            'phone' => '01778565178',
            'address' => 'Dhaka',
        ]);

        Customer::create([
            'name' => 'Customer 2',
            'package_id' => 2,
            'email' => 'customer2@gmail.com',
            'phone' => '01778565578',
            'address' => 'Dhaka',
        ]);

        Customer::create([
            'name' => 'Customer 3',
            'package_id' => 3,
            'email' => 'customer3@gmail.com',
            'phone' => '01778565978',
            'address' => 'Dhaka',
        ]);
    }
}
