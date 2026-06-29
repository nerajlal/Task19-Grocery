<?php

namespace Database\Seeders;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        $discounts = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'status' => 'active',
                'starts_at' => Carbon::now(),
                'ends_at' => null,
            ],
            [
                'code' => 'SAVE500',
                'type' => 'fixed',
                'value' => 500,
                'status' => 'active',
                'starts_at' => Carbon::now(),
                'ends_at' => Carbon::now()->addMonth(),
            ],
            [
                'code' => 'SUMMER25',
                'type' => 'percentage',
                'value' => 25,
                'status' => 'expired',
                'starts_at' => Carbon::now()->subMonths(2),
                'ends_at' => Carbon::now()->subMonth(),
            ],
            [
                'code' => 'BLACKFRIDAY',
                'type' => 'percentage',
                'value' => 50,
                'status' => 'scheduled',
                'starts_at' => Carbon::now()->addMonths(2),
                'ends_at' => Carbon::now()->addMonths(2)->addWeek(),
            ],
             [
                'code' => 'FLASH50',
                'type' => 'fixed',
                'value' => 50,
                'status' => 'active',
                'starts_at' => Carbon::now(),
                'ends_at' => Carbon::now()->addDays(2),
            ],
        ];

        $tenant = \App\Models\Tenant::first();

        foreach ($discounts as $data) {
            $data['tenant_id'] = $tenant->id;
            Discount::create($data);
        }
    }
}
