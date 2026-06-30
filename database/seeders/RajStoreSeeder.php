<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RajStoreSeeder extends Seeder
{
    public function run()
    {
        // 1. Create or Find the Raj Store Tenant
        $tenant = Tenant::firstOrCreate(
            ['name' => 'Raj Store'],
            [
                'plan' => 'sprout',
                'theme' => 'aura_luxe',
                'domain' => 'rajstore.local',
            ]
        );

        // 2. Create an admin user for Raj Store if none exists
        User::firstOrCreate(
            ['email' => 'raj@rajstore.com'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Raj Kumar',
                'site_name' => 'Raj Store',
                'phone' => '+91 9999999999',
                'type' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
            ]
        );

        // Create 5 customer users for Raj Store
        $customers = [
            ['name' => 'Amit Sharma', 'email' => 'amit@rajstore.com', 'phone' => '+91 9876543210'],
            ['name' => 'Priya Patel', 'email' => 'priya@rajstore.com', 'phone' => '+91 9876543211'],
            ['name' => 'Rahul Verma', 'email' => 'rahul@rajstore.com', 'phone' => '+91 9876543212'],
            ['name' => 'Sneha Reddy', 'email' => 'sneha@rajstore.com', 'phone' => '+91 9876543213'],
            ['name' => 'Vikram Singh', 'email' => 'vikram@rajstore.com', 'phone' => '+91 9876543214'],
        ];

        foreach ($customers as $c) {
            User::firstOrCreate(
                ['email' => $c['email']],
                [
                    'tenant_id' => $tenant->id,
                    'name' => $c['name'],
                    'site_name' => 'Raj Store',
                    'phone' => $c['phone'],
                    'type' => 'user',
                    'email_verified_at' => now(),
                    'password' => bcrypt('password123'),
                ]
            );
        }

        // Ensure grocery collections exist for this tenant
        $collections = [
            'Fresh Produce' => 'Images/category-fresh.webp',
            'Dairy & Eggs' => 'Images/category-dairy.webp',
            'Bakery & Pantry' => 'Images/category-bakery.webp',
            'Beverages' => 'Images/category-beverages.webp',
        ];

        $collectionIds = [];
        foreach ($collections as $name => $image) {
            $col = Collection::withoutGlobalScopes()
                ->where('tenant_id', $tenant->id)
                ->where('name', $name)
                ->first();

            if (!$col) {
                $col = Collection::create([
                    'tenant_id' => $tenant->id,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . $tenant->id,
                    'description' => "All your premium {$name} products.",
                ]);
            }
            $collectionIds[$name] = $col->id;
        }

        // 3. Define 10 grocery products
        $groceryProducts = [
            [
                'title' => 'Fresh Organic Bananas',
                'type' => 'Fruits',
                'vendor' => 'Local Farm Direct',
                'collection' => 'Fresh Produce',
                'description' => 'Sweet, ripe organic bananas sourced directly from certified organic farms. High in potassium and perfect for snacks or baking.',
                'variants' => [
                    ['size' => '1 Bunch (approx 5-6 pcs)', 'price' => 80.00, 'stock' => 50],
                    ['size' => '1kg', 'price' => 120.00, 'stock' => 30],
                ]
            ],
            [
                'title' => 'Whole Wheat Fresh Bread',
                'type' => 'Bakery',
                'vendor' => 'Raj Bakers',
                'collection' => 'Bakery & Pantry',
                'description' => 'Freshly baked whole wheat bread loaf. Rich in fiber, stone-ground flour, and baked fresh every morning with no added preservatives.',
                'variants' => [
                    ['size' => 'Standard Loaf (400g)', 'price' => 45.00, 'stock' => 40],
                    ['size' => 'Large Loaf (800g)', 'price' => 85.00, 'stock' => 20],
                ]
            ],
            [
                'title' => 'Full Cream Organic Milk',
                'type' => 'Dairy',
                'vendor' => 'Happy Cows Dairy',
                'collection' => 'Dairy & Eggs',
                'description' => 'Pure, pasteurized full cream milk from grass-fed cows. Farm fresh, rich in calcium, and perfect for the whole family.',
                'variants' => [
                    ['size' => '500ml', 'price' => 35.00, 'stock' => 100],
                    ['size' => '1L Packet', 'price' => 68.00, 'stock' => 80],
                ]
            ],
            [
                'title' => 'Premium Olive Oil',
                'type' => 'Pantry',
                'vendor' => 'Deluxe Foods',
                'collection' => 'Bakery & Pantry',
                'description' => 'Cold-pressed extra virgin olive oil imported from Mediterranean groves. Ideal for salads, cooking, and dressings.',
                'variants' => [
                    ['size' => '250ml Bottle', 'price' => 320.00, 'stock' => 15],
                    ['size' => '500ml Bottle', 'price' => 599.00, 'stock' => 25],
                    ['size' => '1L Bottle', 'price' => 1099.00, 'stock' => 10],
                ]
            ],
            [
                'title' => 'Fresh Organic Eggs',
                'type' => 'Dairy',
                'vendor' => 'Free Range Farms',
                'collection' => 'Dairy & Eggs',
                'description' => 'Farm-fresh free-range eggs. Handpicked, nutrient-dense, high protein, and perfect for baking, boiling, or frying.',
                'variants' => [
                    ['size' => 'Pack of 6', 'price' => 60.00, 'stock' => 45],
                    ['size' => 'Pack of 12', 'price' => 115.00, 'stock' => 40],
                    ['size' => 'Crate of 30', 'price' => 270.00, 'stock' => 15],
                ],
                'packs' => [
                    ['variant_size' => 'Pack of 6', 'quantity' => 3, 'pack_price' => 150.00],
                ]
            ],
            [
                'title' => 'Natural Orange Juice',
                'type' => 'Beverages',
                'vendor' => 'Pure Press Co.',
                'collection' => 'Beverages',
                'description' => '100% natural cold-pressed orange juice with pulp. No added sugars, artificial colors, or concentrates.',
                'variants' => [
                    ['size' => '250ml Cup', 'price' => 70.00, 'stock' => 30],
                    ['size' => '1L Bottle', 'price' => 220.00, 'stock' => 20],
                ]
            ],
            [
                'title' => 'Fresh Organic Avocados',
                'type' => 'Fruits',
                'vendor' => 'Highland Farms',
                'collection' => 'Fresh Produce',
                'description' => 'Buttery and perfectly ripe Hass avocados. Packed with healthy fats, vitamins, and perfect for guacamole or spreads.',
                'variants' => [
                    ['size' => 'Single Piece', 'price' => 90.00, 'stock' => 25],
                    ['size' => 'Pack of 3', 'price' => 250.00, 'stock' => 15],
                ]
            ],
            [
                'title' => 'Greek Style Strawberry Yogurt',
                'type' => 'Dairy',
                'vendor' => 'Happy Cows Dairy',
                'collection' => 'Dairy & Eggs',
                'description' => 'Thick and creamy Greek-style yogurt infused with real strawberry fruit chunks. High in protein and active probiotics.',
                'variants' => [
                    ['size' => '150g Cup', 'price' => 50.00, 'stock' => 60],
                    ['size' => '400g Tub', 'price' => 125.00, 'stock' => 30],
                ]
            ],
            [
                'title' => 'Premium Basmati Rice',
                'type' => 'Pantry',
                'vendor' => 'Raj Growers',
                'collection' => 'Bakery & Pantry',
                'description' => 'Aromatic extra long-grain Basmati rice. Aged for 12 months for the perfect fluffy texture and premium aroma.',
                'variants' => [
                    ['size' => '1kg Bag', 'price' => 150.00, 'stock' => 100],
                    ['size' => '5kg Family Pack', 'price' => 720.00, 'stock' => 40],
                ],
                'packs' => [
                    ['variant_size' => '1kg Bag', 'quantity' => 5, 'pack_price' => 650.00],
                    ['variant_size' => '1kg Bag', 'quantity' => 10, 'pack_price' => 1200.00],
                ]
            ],
            [
                'title' => 'Fresh Farm Tomatoes',
                'type' => 'Vegetables',
                'vendor' => 'Local Farm Direct',
                'collection' => 'Fresh Produce',
                'description' => 'Juicy red vine-ripened tomatoes. Grown organically, picked fresh daily, and great for curries, salads, and soups.',
                'variants' => [
                    ['size' => '500g', 'price' => 30.00, 'stock' => 60],
                    ['size' => '1kg', 'price' => 55.00, 'stock' => 50],
                ]
            ]
        ];

        foreach ($groceryProducts as $gp) {
            $product = Product::withoutGlobalScopes()
                ->where('tenant_id', $tenant->id)
                ->where('title', $gp['title'])
                ->first();

            if (!$product) {
                $product = Product::create([
                    'tenant_id' => $tenant->id,
                    'title' => $gp['title'],
                    'slug' => Str::slug($gp['title']) . '-' . $tenant->id,
                    'description' => $gp['description'],
                    'status' => 'active',
                    'type' => $gp['type'],
                    'vendor' => $gp['vendor'],
                    'collection_id' => $collectionIds[$gp['collection']] ?? null,
                ]);
            }

            // Add placeholder images matching the grocery theme
            if ($product->images()->count() === 0) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => 'Images/placeholder-grocery.webp',
                    'type' => 'main',
                    'order' => 1,
                ]);
            }

            // Seed variants
            foreach ($gp['variants'] as $v) {
                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('size', $v['size'])
                    ->first();

                if (!$variant) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $v['size'],
                        'sku' => Str::upper(Str::slug($gp['title'])) . '-' . Str::slug($v['size']) . '-' . $tenant->id,
                        'price' => $v['price'],
                        'stock' => $v['stock'],
                    ]);
                }
            }

            // Seed pack deals
            if (isset($gp['packs'])) {
                foreach ($gp['packs'] as $pData) {
                    $variant = ProductVariant::where('product_id', $product->id)
                        ->where('size', $pData['variant_size'])
                        ->first();
                        
                    if ($variant) {
                        $title = "Pack of {$pData['quantity']} - {$product->title} - {$variant->size}";
                        $originalTotal = $variant->price * $pData['quantity'];
                        $discountValue = max(0, $originalTotal - $pData['pack_price']);
                        
                        $bundle = \App\Models\Bundle::withoutGlobalScopes()
                            ->where('tenant_id', $tenant->id)
                            ->where('title', $title)
                            ->first();
                            
                        if (!$bundle) {
                            $bundle = \App\Models\Bundle::create([
                                'tenant_id' => $tenant->id,
                                'title' => $title,
                                'slug' => Str::slug($title) . '-' . $product->id . '-' . rand(100, 999),
                                'type' => 'pack',
                                'discount_type' => 'fixed',
                                'discount_value' => $discountValue,
                                'status' => 'active',
                            ]);
                            
                            $bundle->products()->attach($product->id, [
                                'quantity' => $pData['quantity'],
                                'product_variant_id' => $variant->id
                            ]);
                        }
                    }
                }
            }
        }
    }
}
