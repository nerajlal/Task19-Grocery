@if(count($cart) > 0)
    <div class="v4-cart-drawer-items">
        @foreach($cart as $id => $item)
            <div class="v4-drawer-item" data-id="{{ $id }}">
                <div class="v4-drawer-item-img">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                </div>
                <div class="v4-drawer-item-info">
                    <div class="v4-drawer-item-header">
                        <h4>{{ $item['name'] }}</h4>
                        <button onclick="drawerRemove('{{ $id }}')" class="v4-drawer-remove"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    <div class="v4-drawer-meta">
                        <span class="v4-drawer-item-variant">{{ $item['size'] ?? 'Combo' }}</span>
                        @if(isset($item['pack_offer_applied']) && $item['pack_offer_applied'])
                            <span class="v4-drawer-offer-badge">{{ $item['pack_offer_text'] }}</span>
                        @endif
                        
                        @if(isset($item['coupon']) && $item['coupon'])
                            <div class="v4-drawer-coupon-notice">
                                <i class="fa-solid fa-tag"></i> 
                                <strong>{{ $item['coupon']->code }}</strong>: 
                                {{ $item['coupon']->type == 'percentage' ? number_format($item['coupon']->value) . '%' : '₹' . number_format($item['coupon']->value) }} OFF
                            </div>
                        @endif
                    </div>
                    
                    <div class="v4-drawer-item-footer">
                        <div class="v4-drawer-qty">
                            <button onclick="drawerUpdateQty('{{ $id }}', -1)">-</button>
                            <span>{{ $item['quantity'] }}</span>
                            <button onclick="drawerUpdateQty('{{ $id }}', 1)">+</button>
                        </div>
                        <div class="v4-drawer-item-price">
                            @if(isset($item['line_savings']) && $item['line_savings'] > 0)
                                <span class="v4-price-old">₹{{ number_format($item['line_subtotal'], 0) }}</span>
                                <span class="v4-price-new">₹{{ number_format($item['line_subtotal'] - $item['line_savings'], 0) }}</span>
                            @else
                                ₹{{ number_format($item['line_subtotal'], 0) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="v4-drawer-footer">
        <div class="v4-drawer-subtotal">
            <span>Subtotal</span>
            <strong>₹{{ number_format($subtotal, 0) }}</strong>
        </div>
        @if($savings > 0)
        <div class="v4-drawer-savings">
            <span>Total Savings</span>
            <strong style="color: #10B981;">- ₹{{ number_format($savings, 0) }}</strong>
        </div>
        @endif
        <div class="v4-drawer-total">
            <span>Estimate Total</span>
            <strong>₹{{ number_format($total, 0) }}</strong>
        </div>
        <a href="{{ route('v4.cart') }}" class="v4-drawer-btn secondary">VIEW BAG</a>
        <a href="{{ route('v4.checkout') }}" class="v4-drawer-btn">CHECKOUT NOW</a>
    </div>
@else
    <div class="v4-drawer-empty">
        <i class="fa-solid fa-bag-shopping"></i>
        <p>Your bag is empty</p>
        <a href="{{ route('v4.all-products') }}" class="v4-drawer-btn">START SHOPPING</a>
    </div>
@endif

<style>
    .v4-cart-drawer-items { display: flex; flex-direction: column; gap: 20px; padding: 20px 0; overflow-y: auto; flex: 1; }
    .v4-drawer-item { display: flex; gap: 15px; align-items: flex-start; padding-bottom: 20px; border-bottom: 1px solid #f5f5f5; }
    .v4-drawer-item:last-child { border-bottom: none; }
    
    .v4-drawer-item-img { width: 80px; height: 80px; background: #f9f9f9; border-radius: 8px; overflow: hidden; border: 1px solid #eee; flex-shrink: 0; }
    .v4-drawer-item-img img { width: 100%; height: 100%; object-fit: cover; }
    
    .v4-drawer-item-info { flex: 1; }
    .v4-drawer-item-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px; }
    .v4-drawer-item-info h4 { font-size: 13px; font-weight: 700; color: var(--aj-dark); margin: 0; line-height: 1.4; }
    
    .v4-drawer-remove { background: none; border: none; color: #ccc; cursor: pointer; font-size: 14px; transition: 0.3s; padding: 0 0 0 10px; }
    .v4-drawer-remove:hover { color: #ff4d4d; }
    
    .v4-drawer-meta { display: flex; flex-direction: column; gap: 4px; }
    .v4-drawer-item-variant { font-size: 10px; color: var(--aj-gray); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .v4-drawer-offer-badge { font-size: 9px; font-weight: 800; color: #10B981; background: #e6f7f0; padding: 2px 8px; border-radius: 4px; align-self: flex-start; text-transform: uppercase; margin-bottom: 2px; }
    
    .v4-drawer-coupon-notice { 
        font-size: 9px; 
        font-weight: 700; 
        color: #8a6d3b; 
        background: #fdf8ef; 
        border: 1px dashed var(--aj-gold); 
        padding: 4px 8px; 
        border-radius: 4px; 
        display: flex; 
        align-items: center; 
        gap: 6px; 
        margin-top: 5px;
    }
    .v4-drawer-coupon-notice i { font-size: 10px; color: var(--aj-gold); }
    .v4-drawer-coupon-notice strong { color: var(--aj-dark); }
    
    .v4-drawer-item-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
    
    .v4-drawer-qty { display: flex; align-items: center; border: 1px solid #eee; border-radius: 4px; overflow: hidden; }
    .v4-drawer-qty button { width: 25px; height: 25px; background: #fff; border: none; cursor: pointer; font-size: 14px; font-weight: 700; }
    .v4-drawer-qty button:hover { background: #f9f9f9; }
    .v4-drawer-qty span { width: 30px; text-align: center; font-size: 12px; font-weight: 800; }
    
    .v4-drawer-item-price { font-size: 13px; font-weight: 800; color: var(--aj-dark); }
    .v4-price-old { text-decoration: line-through; color: #999; font-size: 11px; margin-right: 5px; }
    .v4-price-new { color: var(--aj-gold); }

    .v4-drawer-footer { padding: 20px 0; border-top: 1px solid #eee; }
    .v4-drawer-subtotal, .v4-drawer-savings, .v4-drawer-total { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; }
    .v4-drawer-total { margin-top: 15px; margin-bottom: 25px; font-size: 16px; font-weight: 800; border-top: 1px dashed #eee; padding-top: 15px; }
    
    .v4-drawer-btn { display: block; width: 100%; padding: 15px; text-align: center; text-decoration: none; font-weight: 800; font-size: 12px; border-radius: 4px; margin-bottom: 10px; transition: 0.3s; }
    .v4-drawer-btn { background: #000; color: #fff; }
    .v4-drawer-btn.secondary { background: #fff; color: #000; border: 1px solid #000; }
    .v4-drawer-btn:hover { background: var(--aj-gold); color: #fff; border-color: var(--aj-gold); }

    .v4-drawer-empty { text-align: center; padding: 50px 0; }
    .v4-drawer-empty i { font-size: 50px; color: #eee; margin-bottom: 20px; }
</style>
