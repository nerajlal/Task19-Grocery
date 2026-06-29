<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $tenant = Tenant::first();

        $sliders = [
            [
                'title' => 'Luxury Fragrances',
                'image_desktop' => 'Images/slider-1-desktop.webp',
                'image_mobile' => 'Images/slider-1-mobile.webp',
                'status' => true,
                'order' => 1,
            ],
            [
                'title' => 'Summer Collection 2026',
                'image_desktop' => 'Images/slider-2-desktop.webp',
                'image_mobile' => 'Images/slider-2-mobile.webp',
                'status' => true,
                'order' => 2,
            ],
            [
                'title' => 'Exclusive Gift Bundles',
                'image_desktop' => 'Images/slider-3-desktop.webp',
                'image_mobile' => 'Images/slider-3-mobile.webp',
                'status' => true,
                'order' => 3,
            ],
        ];

        foreach ($sliders as $data) {
            $data['tenant_id'] = $tenant->id;
            Slider::create($data);
        }
    }
}
