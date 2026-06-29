<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DeliveryPartner;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->withCount('items')->latest();

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20)->withQueryString();
        
        return view('admin.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'items.bundle.products.variants', 'user', 'deliveryPartner'])->findOrFail($id);
        $deliveryPartners = DeliveryPartner::where('status', true)->orderBy('is_default', 'desc')->get();
        return view('admin.orders.show', compact('order', 'deliveryPartners'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $status = $request->input('status');
        $trackingId = $request->input('tracking_id');

        if ($status) {
            $order->status = $status;
            
            // If status is shipped, we might want to save tracking ID
            // Assuming we have a way to store tracking ID, for now let's just save it in notes or a dedicated column if it existed.
            // checking migration, we don't seem to have tracking_number. 
            // I'll append it to notes for now to avoid migration overhead unless critical, 
            // OR I can add a tracking_number column. For "fully functional" usually means DB too.
            // But let's check order schema first. I'll stick to updating status for now and maybe notes.
            
            if ($status == 'shipped') {
                 if ($trackingId) {
                     $order->tracking_number = $trackingId;
                 }
                 if ($request->has('delivery_partner_id')) {
                     $order->delivery_partner_id = $request->input('delivery_partner_id');
                 }
            }
            
            $order->save();
        }

        return response()->json(['success' => true, 'message' => 'Order status updated successfully']);
    }

    public function print($id)
    {
        $order = Order::with(['items.product', 'items.bundle.products.variants', 'user'])->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }

    public function create()
    {
        $customers = \App\Models\User::where('type', 'user')->orderBy('name', 'asc')->get();
        $products = \App\Models\Product::where('status', 'active')->with('variants')->orderBy('title', 'asc')->get();
        
        return view('admin.orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_type' => 'required|in:existing,new',
            'user_id' => 'required_if:customer_type,existing|nullable|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            
            // Shipping Address
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',

            // Billing Address
            'billing_address_line1' => 'nullable|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:100',

            'payment_status' => 'required|in:pending,paid',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'shipping_cost' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            
            // Items
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $request) {
            $dateCtx = now()->format('d');
            $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $rLetters = substr(str_shuffle($pool), 0, 2);
            $randomMix = str_shuffle(rand(10, 99) . $rLetters);
            $orderNumber = "NR-{$dateCtx}-MAN-{$randomMix}";

            $userId = $validated['customer_type'] === 'existing' ? $validated['user_id'] : null;

            $shippingAddress = [
                'address' => $validated['shipping_address_line1'] . ($validated['shipping_address_line2'] ? ', ' . $validated['shipping_address_line2'] : ''),
                'city' => $validated['shipping_city'],
                'state' => $validated['shipping_state'],
                'postal_code' => $validated['shipping_postal_code'],
                'country' => $validated['shipping_country'],
            ];

            $billingAddress = [
                'address' => ($validated['billing_address_line1'] ?? $validated['shipping_address_line1']) . (($validated['billing_address_line2'] ?? $validated['shipping_address_line2']) ? ', ' . ($validated['billing_address_line2'] ?? $validated['shipping_address_line2']) : ''),
                'city' => $validated['billing_city'] ?? $validated['shipping_city'],
                'state' => $validated['billing_state'] ?? $validated['shipping_state'],
                'postal_code' => $validated['billing_postal_code'] ?? $validated['shipping_postal_code'],
                'country' => $validated['billing_country'] ?? $validated['shipping_country'],
            ];

            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $totalAmount = $subtotal + $validated['shipping_cost'] - $validated['discount_amount'];
            if ($totalAmount < 0) {
                $totalAmount = 0;
            }

            $tenantId = session('active_tenant_id') ?? request()->route('tenant') ?? 1;

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'status' => $validated['status'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_status'],
                'subtotal' => $subtotal,
                'shipping_cost' => $validated['shipping_cost'],
                'discount_amount' => $validated['discount_amount'],
                'total_amount' => $totalAmount,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'notes' => $validated['notes'],
                'placed_at' => now(),
                'tenant_id' => $tenantId,
            ]);

            foreach ($validated['items'] as $itemData) {
                $product = \App\Models\Product::findOrFail($itemData['product_id']);
                $variant = $itemData['variant_id'] ? \App\Models\ProductVariant::find($itemData['variant_id']) : null;
                
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->title,
                    'sku' => $variant ? $variant->sku : $product->title,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemData['price'] * $itemData['quantity'],
                    'size' => $variant ? $variant->size : null,
                    'type' => 'product',
                ]);
            }
        });

        $tenant = request()->route('tenant');
        return redirect()->route('admin.orders', ['tenant' => $tenant])->with('success', 'Order created successfully.');
    }
}
