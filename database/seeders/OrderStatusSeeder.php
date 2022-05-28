<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'alias' => 'pending',
            'status' => 'Pending Approval'
        ]);

        OrderStatus::create([
            'alias' => 'approved',
            'status' => 'Approved'
        ]);

        OrderStatus::create([
            'alias' => 'processing',
            'status' => 'Processing'
        ]);

        OrderStatus::create([
            'alias' => 'removed',
            'status' => 'Removed'
        ]);
    }
}
