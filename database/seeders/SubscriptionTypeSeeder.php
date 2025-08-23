<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $subscriptionTypes = [
            [
                'type_name'        => 'Month',
                'duration_days'    => 30,
                'base_amount'      => 3000.00,
                'discount_percent' => 0.00,
                'final_price'      => 3000.00,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'type_name'        => 'Three Months',
                'duration_days'    => 90,
                'base_amount'      => 9000.00,
                'discount_percent' => 8.33,
                'final_price'      => 8250.00,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'type_name'        => 'Six Months',
                'duration_days'    => 180,
                'base_amount'      => 18000.00,
                'discount_percent' => 16.67,
                'final_price'      => 15000.00,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'type_name'        => 'Annual',
                'duration_days'    => 365,
                'base_amount'      => 30000.00,
                'discount_percent' => 20.00,
                'final_price'      => 24000.00,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ];

        DB::table('subscription_types')->insertOrIgnore($subscriptionTypes);
    }
}
