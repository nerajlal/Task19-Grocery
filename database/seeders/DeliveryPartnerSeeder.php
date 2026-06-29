<?php

namespace Database\Seeders;

use App\Models\DeliveryPartner;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DeliveryPartnerSeeder extends Seeder
{
    public function run()
    {
        $tenant = Tenant::first();

        $partners = [
            [
                'name' => 'BlueDart',
                'site_url' => 'https://www.bluedart.com',
                'tracking_url_template' => 'https://www.bluedart.com/tracking?id={tracking_number}',
                'status' => true,
            ],
            [
                'name' => 'Delhivery',
                'site_url' => 'https://www.delhivery.com',
                'tracking_url_template' => 'https://www.delhivery.com/track/package/{tracking_number}',
                'status' => true,
            ],
            [
                'name' => 'Ecom Express',
                'site_url' => 'https://ecomexpress.in',
                'tracking_url_template' => 'https://ecomexpress.in/tracking/{tracking_number}',
                'status' => true,
            ],
        ];

        foreach ($partners as $data) {
            $data['tenant_id'] = $tenant->id;
            DeliveryPartner::create($data);
        }
    }
}
