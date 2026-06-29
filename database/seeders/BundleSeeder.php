<?php

namespace Database\Seeders;

use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BundleSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        if ($products->count() < 3) {
            return;
        }

        $bundles = [
            [
                'title' => 'Essential Collection Trio',
                'discount_percentage' => 15,
            ],
            [
                'title' => 'Luxury Gift Set',
                'discount_percentage' => 20,
            ],
            [
                'title' => 'Summer Vibes Pack',
                'discount_percentage' => 10,
            ],
            [
                'title' => 'Date Night Essentials',
                'discount_percentage' => 25,
            ],
            [
                'title' => 'Office Wear Edit',
                'discount_percentage' => 10,
            ],
            [
                'title' => 'Weekend Getaway Kit',
                'discount_percentage' => 15,
            ],
            [
                'title' => 'Oud Lovers Collection',
                'discount_percentage' => 30,
            ],
            [
                'title' => 'Floral Fantasy Box',
                'discount_percentage' => 18,
            ],
        ];

        $tenant = \App\Models\Tenant::first();

        foreach ($bundles as $data) {
            $bundleProducts = $products->random(3);
            $totalPrice = $bundleProducts->sum(function ($product) {
                return $product->variants->first()->price ?? 0;
            });
            $discountedPrice = $totalPrice * (1 - ($data['discount_percentage'] / 100));

            $bundle = Bundle::create([
                'tenant_id' => $tenant->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => 'Get valid savings with this exclusive bundle!',
                'status' => 'active',
                'image' => $bundleProducts->first()->images->first()->path ?? null, // Use first product image as bundle image
                'discount_type' => 'percentage', // Defaulting as logic uses percentage
                'discount_value' => $data['discount_percentage'],
            ]);

            $bundle->products()->attach($bundleProducts->pluck('id'));
        }
    }
}
