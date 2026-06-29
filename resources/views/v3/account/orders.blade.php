@extends('v3.layouts.app')

@section('content')
<div class="container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    <div style="margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700;">My Orders</h1>
        <a href="{{ route('account.index') }}" style="text-decoration: underline; color: #000; font-weight: 600;">Back to Account</a>
    </div>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
                <div style="border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px; overflow: hidden;">
                    <div style="background: #f8f8f8; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0;">
                        <div>
                            <span style="font-weight: 700; color: #333;">{{ $order->order_number }}</span>
                            <span style="color: #666; font-size: 13px; margin-left: 10px;">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 600; font-size: 14px; color: {{ $order->payment_status == 'paid' ? 'green' : '#d4a574' }}; text-transform: uppercase;">
                                {{ $order->status }}
                            </div>
                            @if($order->tracking_number)
                                <div style="font-size: 13px; color: #666; margin-top: 4px;">
                                    Tracking: <a href="https://www.dtdc.com/track-your-shipment/" target="_blank" style="font-weight: 700; color: #333; text-decoration: underline;">{{ $order->tracking_number }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <div>
                                <div style="font-size: 13px; color: #666; margin-bottom: 5px;">Total Amount</div>
                                <div style="font-weight: 700; font-size: 16px;">₹{{ number_format($order->total_amount) }}</div>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #666; margin-bottom: 5px;">Payment</div>
                                <div style="font-weight: 600; font-size: 14px; text-transform: uppercase;">{{ $order->payment_method }}</div>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #666; margin-bottom: 5px;">Items</div>
                                <div style="font-weight: 600; font-size: 14px;">{{ $order->items->count() }}</div>
                            </div>
                        </div>
                        
                        <!-- Order Items Preview -->
                        <div style="background: #fafafa; padding: 15px; border-radius: 5px;">
                            @foreach($order->items as $item)
                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 14px; margin-bottom: 15px; color: #444;">
                                    <div style="display: flex; align-items: center;">
                                        <!-- Item Image -->
                                        <div style="width: 60px; height: 60px; flex-shrink: 0; margin-right: 15px; border-radius: 6px; overflow: hidden; background-color: #f0f0f0; border: 1px solid #eee;">
                                            @php
                                                $defaultImg = asset('Images/g-load.webp');
                                                $imgSrc = $defaultImg; // Fallback
                                                
                                                if($item->product && $item->product->main_image_url) {
                                                    $imgSrc = $item->product->main_image_url;
                                                } elseif($item->bundle && $item->bundle->image) {
                                                    $imgSrc = asset('storage/' . $item->bundle->image);
                                                }
                                                
                                                $link = '#';
                                                if($item->product_id) {
                                                    $link = route('v3.product', ['id' => $item->product_id]);
                                                } elseif($item->bundle_id) {
                                                    $link = route('v3.combo', ['id' => $item->bundle_id]);
                                                }
                                            @endphp
                                            <a href="{{ $link }}" style="display: block; width: 100%; height: 100%;">
                                                <img src="{{ $imgSrc }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null;this.src='{{ $defaultImg }}';">
                                            </a>
                                        </div>

                                        <!-- Item Details -->
                                        <div>
                                            <div style="font-weight: 500; margin-bottom: 2px;">
                                                @if($item->product_id)
                                                    <a href="{{ route('v3.product', ['id' => $item->product_id]) }}" style="color: inherit; text-decoration: none;">{{ $item->name }}</a>
                                                @elseif($item->bundle_id)
                                                    <a href="{{ route('v3.combo', ['id' => $item->bundle_id]) }}" style="color: inherit; text-decoration: none;">{{ $item->name }}</a>
                                                @else
                                                    {{ $item->name }}
                                                @endif
                                            </div>
                                            <div style="font-size: 13px; color: #777;">
                                                Qty: {{ $item->quantity }} @if($item->size) &bull; Size: {{ $item->size }} @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div style="font-weight: 600;">₹{{ number_format($item->total) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: #f9f9f9; border-radius: 8px;">
            <i class="fas fa-shopping-bag" style="font-size: 48px; color: #ddd; margin-bottom: 20px;"></i>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 22px; margin-bottom: 10px;">No orders yet</h3>
            <p style="color: #666; margin-bottom: 20px;">Looks like you haven't placed any orders yet.</p>
            <a href="{{ route('v3.all-products') }}" style="display: inline-block; background: #000; color: #fff; padding: 10px 25px; text-decoration: none; border-radius: 4px; font-weight: 600;">Start Shopping</a>
        </div>
    @endif
</div>
@endsection
