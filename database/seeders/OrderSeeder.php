<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Tenant;
use App\Models\DeliveryPartner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $tenant = Tenant::first();
        $products = Product::with('variants')->get();
        $deliveryPartners = DeliveryPartner::all();

        if ($products->isEmpty()) {
            return;
        }

        // Create some customers
        $customers = User::factory(5)->create([
            'tenant_id' => $tenant->id,
            'type' => 'customer',
        ]);

        foreach ($customers as $customer) {
            // Create 1-3 orders for each customer
            $orderCount = rand(1, 3);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $placedAt = Carbon::now()->subDays(rand(1, 30));
                $status = collect(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->random();
                $paymentMethod = collect(['cod', 'prepaid'])->random();
                $paymentStatus = $paymentMethod === 'prepaid' ? 'paid' : ($status === 'delivered' ? 'paid' : 'pending');

                $order = Order::create([
                    'tenant_id' => $tenant->id,
                    'user_id' => $customer->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'status' => $status,
                    'payment_method' => $paymentMethod,
                    'payment_status' => $paymentStatus,
                    'subtotal' => 0, // Will calculate below
                    'shipping_cost' => 50.00,
                    'discount_amount' => 0,
                    'total_amount' => 0, // Will calculate below
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'customer_phone' => '9876543210',
                    'shipping_address' => [
                        'address' => '123, Sample Street',
                        'city' => 'Bangalore',
                        'state' => 'Karnataka',
                        'pincode' => '560001',
                    ],
                    'billing_address' => [
                        'address' => '123, Sample Street',
                        'city' => 'Bangalore',
                        'state' => 'Karnataka',
                        'pincode' => '560001',
                    ],
                    'placed_at' => $placedAt,
                    'tracking_number' => $status === 'shipped' || $status === 'delivered' ? 'TRACK' . Str::random(10) : null,
                    'delivery_partner_id' => $deliveryPartners->isNotEmpty() ? $deliveryPartners->random()->id : null,
                ]);

                // Add 1-4 items to the order
                $itemCount = rand(1, 4);
                $subtotal = 0;
                $orderProducts = $products->random($itemCount);

                foreach ($orderProducts as $product) {
                    $variant = $product->variants->first();
                    $qty = rand(1, 2);
                    $price = $variant ? $variant->price : $product->price;
                    $total = $price * $qty;
                    $subtotal += $total;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'name' => $product->title,
                        'sku' => $variant ? $variant->sku : 'SKU-' . $product->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'total' => $total,
                        'size' => $variant ? $variant->size : '100ml',
                        'type' => $product->type,
                    ]);
                }

                $order->update([
                    'subtotal' => $subtotal,
                    'total_amount' => $subtotal + $order->shipping_cost - $order->discount_amount,
                ]);
            }
        }
    }
}
