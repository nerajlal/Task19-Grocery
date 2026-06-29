<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run()
    {
        $collections = [
            [
                'name' => 'Signature Collection',
                'description' => 'Our most exclusive and premium fragrances.',
                'image' => 'Images/category-oriental-woody.webp',
                'status' => 1,
            ],
            [
                'name' => 'Floral Symphony',
                'description' => 'A bouquet of fresh and vibrant floral scents.',
                'image' => 'Images/category-floral.webp',
                'status' => 1,
            ],
            [
                'name' => 'Fresh & Zesty',
                'description' => 'Invigorating citrus and aquatic notes for everyday freshness.',
                'image' => 'Images/category-fresh.webp',
                'status' => 1,
            ],
            [
                'name' => 'For Him',
                'description' => 'Bold and masculine fragrances.',
                'image' => 'Images/gender-him.webp',
                'status' => 1,
            ],
            [
                'name' => 'For Her',
                'description' => 'Elegant and feminine scents.',
                'image' => 'Images/gender-her.webp',
                'status' => 1,
            ],
            [
                'name' => 'Unisex Favorites',
                'description' => 'Versatile scents loved by everyone.',
                'image' => 'Images/gender-unisex.webp',
                'status' => 1,
            ],
        ];

        $tenant = \App\Models\Tenant::first();

        foreach ($collections as $data) {
            
            // Check if slug exists in data, else generate it
            if (!isset($data['slug'])) {
                $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            }

            $data['tenant_id'] = $tenant->id;

            Collection::create($data);
        }
    }
}
