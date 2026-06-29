@extends('v3.layouts.app')

@section('title', 'Shopping Cart - Nurah Perfumes')

@push('styles')
<style>
    .cart-page {
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
        min-height: 60vh;
    }
    
    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        color: var(--black);
    }
    
    .cart-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }
    
    /* Cart Items */
    .cart-items {
        background: var(--white);
        border-radius: 12px;
        border: 1px solid var(--border);
        overflow: hidden;
    }
    
    .cart-header {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 0.8fr 0.5fr;
        padding: 15px 20px;
        background: var(--bg-light);
        border-bottom: 1px solid var(--border);
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        color: var(--text-light);
    }
    
    .cart-item {
        padding: 20px;
        border-bottom: 1px solid var(--border);
    }

    .cart-item-main {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 0.8fr 0.5fr;
        align-items: center;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .item-info {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .item-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--bg-light);
    }
    
    .item-details h3 {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        margin-bottom: 5px;
        color: var(--black);
    }
    
    .item-price {
        font-weight: 600;
        color: var(--text);
    }
    
    .item-quantity {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .qty-btn {
        width: 28px;
        height: 28px;
        border: 1px solid var(--border);
        background: var(--white);
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: var(--text);
    }
    
    .qty-input {
        width: 30px;
        text-align: center;
        border: none;
        font-weight: 600;
    }
    
    .item-total {
        font-weight: 700;
        color: var(--black);
    }
    
    .remove-btn {
        background: none;
        border: none;
        color: #ff3b30;
        cursor: pointer;
        font-size: 16px;
        opacity: 0.7;
        transition: opacity 0.3s;
    }
    
    .remove-btn:hover {
        opacity: 1;
    }
    
    /* Order Summary */
    .cart-summary {
        background: var(--bg-light);
        padding: 25px;
        border-radius: 12px;
        height: fit-content;
    }
    
    .summary-title {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        color: var(--text);
    }
    
    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
        font-weight: 800;
        font-size: 18px;
        color: var(--black);
    }

    .savings-row {
        color: var(--color-gold, #C5A059);
        font-weight: 700;
    }
    
    .checkout-btn {
        width: 100%;
        padding: 15px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 25px;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .checkout-btn:hover {
        background: #333;
    }
    
    .continue-shopping {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: var(--text-light);
        text-decoration: underline;
        font-size: 13px;
    }
    
    /* Empty State */
    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        display: none; /* Hidden by default */
    }
    
    .empty-icon {
        font-size: 60px;
        color: var(--border);
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .cart-container {
            grid-template-columns: 1fr;
        }
        
        .cart-header {
            display: none; /* Hide header on mobile */
        }
        
        .cart-item-main {
            grid-template-columns: 1fr;
            gap: 15px;
            position: relative;
        }
        
        .item-info {
            width: 100%;
        }
        
        .remove-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .item-quantity, .item-total {
            justify-content: space-between;
            width: 100%;
            display: flex;
        }
        
        .item-quantity::before {
            content: 'Quantity:';
            font-size: 13px;
            color: var(--text-light);
        }
        
        .item-total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed var(--border);
        }
        
        .item-total::before {
            content: 'Total:';
        }
    }
    
    .cart-item-blurred .cart-item-main {
        opacity: 0.5;
        filter: blur(2px);
        pointer-events: none;
        user-select: none;
    }
    
    .cart-item-blurred .remove-btn {
        pointer-events: all !important;
        filter: none;
        opacity: 1;
        cursor: pointer;
    }
    
    .cart-oos-badge {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #000;
        color: #fff;
        padding: 8px 15px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 5;
        border-radius: 4px;
        white-space: nowrap;
    }
    
    .pointer-none { pointer-events: none; }
</style>
@endpush

@section('content')
<div class="cart-page">
    <h1 class="page-title">Shopping Cart</h1>
    
    @if(count($cart) > 0)
    <!-- Cart populated -->
    <div class="cart-container" id="cartContainer">
        <div class="cart-items">
            <div class="cart-header">
                <div>Product</div>
                <div>Price</div>
                <div>Quantity</div>
                <div>Total</div>
                <div></div>
            </div>
            
            @php 
                $hasOutOfStock = false; 
            @endphp
            @foreach($cart as $id => $details)
            @php 
                $isOOS = isset($details['stock']) && $details['stock'] <= 0;
                if($isOOS) $hasOutOfStock = true;
            @endphp
            <div class="cart-item {{ $isOOS ? 'cart-item-blurred' : '' }}" data-id="{{ $id }}" style="position: relative;">
                @if($isOOS)
                    <div class="cart-oos-badge">Out of Stock</div>
                @endif
                <div class="cart-item-main">
                    <div class="item-info">
                        @php
                            $itemUrl = isset($details['bundle_id']) 
                                ? route('v3.combo', ['id' => $details['bundle_id']]) 
                                : route('v3.product', ['id' => $details['product_id']]);
                        @endphp
                        
                        <a href="{{ $itemUrl }}" class="{{ $isOOS ? 'pointer-none' : '' }}">
                            <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="item-image" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                        </a>
                        <div class="item-details">
                            <a href="{{ $itemUrl }}" style="text-decoration: none; color: inherit;" class="{{ $isOOS ? 'pointer-none' : '' }}">
                                <h3>{{ $details['name'] }}</h3>
                            </a>
                            @if(isset($details['size']) && $details['size'])
                                <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Size: {{ $details['size'] }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="item-price">₹{{ number_format($details['price']) }}</div>
                    <div class="item-quantity">
                        <button class="qty-btn minus" onclick="updateCart('{{ $id }}', {{ $details['quantity'] - 1 }})" {{ $isOOS ? 'disabled' : '' }}>-</button>
                        <input type="text" value="{{ $details['quantity'] }}" class="qty-input" readonly>
                        <button class="qty-btn plus" onclick="updateCart('{{ $id }}', {{ $details['quantity'] + 1 }})" {{ $isOOS ? 'disabled' : '' }}>+</button>
                    </div>
                    <div class="item-total" id="total-{{ $id }}">₹{{ number_format($details['price'] * $details['quantity']) }}</div>
                    <button class="remove-btn" onclick="removeItem('{{ $id }}')" style="z-index: 10;"><i class="fas fa-trash"></i></button>
                </div>

                @if(isset($details['coupon']) && $details['coupon'])
                    @php
                        $discountVal = $details['coupon']->type == 'percentage' 
                            ? $details['price'] * ($details['coupon']->value / 100) 
                            : $details['coupon']->value;
                        $newPrice = max(0, $details['price'] - $discountVal);
                    @endphp
                    <div style="margin-top: 15px; width: 100%; font-size: 12px; color: #8a6d3b; background: #fdf8ef; border: 1px dashed #C5A059; padding: 8px 12px; border-radius: 4px;">
                        <i class="fas fa-tag me-1"></i> <strong>{{ $details['coupon']->code }}</strong> coupon will automatically apply at checkout to get extra {{ $details['coupon']->type == 'percentage' ? number_format($details['coupon']->value) . '%' : '₹' . number_format($details['coupon']->value) }} OFF. 
                        <strong>Effective Price: ₹{{ number_format($newPrice) }}</strong>
                    </div>
                @endif
            </div>
            @endforeach
            
        </div>
        
        <div class="cart-summary">
            <h2 class="summary-title">Order Summary</h2>
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="cart-subtotal">₹{{ number_format($subtotal) }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span class="text-success">Free</span>
            </div>
            @if($savings > 0)
            <div class="summary-row savings-row">
                <span>Bundle / Volume Discount</span>
                <span id="cart-savings">-₹{{ number_format($savings) }}</span>
            </div>
            @endif
            <div class="summary-total">
                <span>Total</span>
                <span id="cart-total">₹{{ number_format($total) }}</span>
            </div>
            
            @if($hasOutOfStock)
                <div style="margin-top: 20px; color: #ff3b30; font-size: 13px; font-weight: 600; text-align: center; border: 1px solid #ff3b30; padding: 10px; border-radius: 6px; background: #fff0f0;">
                    <i class="fas fa-exclamation-circle"></i> Note: Out of stock items will be excluded from checkout.
                </div>
                <a href="{{ route('v3.checkout') }}" class="checkout-btn" style="text-decoration: none; display: block; text-align: center;">Proceed to Checkout</a>
            @else
                <a href="{{ route('v3.checkout') }}" class="checkout-btn" style="text-decoration: none; display: block; text-align: center;">Proceed to Checkout</a>
            @endif
            
            <a href="{{ route('v3.collection') }}" class="continue-shopping">Continue Shopping</a>
        </div>
    </div>
    @else
        <div class="empty-cart" id="emptyCart" style="display: block;">
            <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
            <h2>Your cart is empty</h2>
            <p class="mb-20">Looks like you haven't added any perfumes yet.</p>
            <a href="{{ route('v3.collection') }}" class="checkout-btn" style="display: inline-block; width: auto; padding: 12px 30px;">Start Shopping</a>
        </div>
    @endif
    
    <!-- Empty State (Hidden initially if cart has items) -->
    <div class="empty-cart" id="emptyCartHidden" style="display: none;">
        <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
        <h2>Your cart is empty</h2>
        <p class="mb-20">Looks like you haven't added any perfumes yet.</p>
        <a href="{{ route('v3.collection') }}" class="checkout-btn" style="display: inline-block; width: auto; padding: 12px 30px;">Start Shopping</a>
    </div>

</div>

@push('scripts')
<script>
    function updateCart(id, newQty) {
        if(newQty < 1) return; // Minimum 1

        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id,
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update specific row
                const row = document.querySelector(`.cart-item[data-id="${id}"]`);
                row.querySelector('.qty-input').value = newQty;
                row.querySelector('.minus').onclick = () => updateCart(id, newQty - 1);
                row.querySelector('.plus').onclick = () => updateCart(id, newQty + 1);
                
                document.getElementById(`total-${id}`).innerText = '₹' + new Intl.NumberFormat().format(data.itemTotal);
                
                // Update totals
                updateSummary(data.cartTotal, data.savings, data.subtotal);

                // Update Badge
                const cartBadge = document.querySelector('.cart-count'); 
                if(cartBadge) {
                    cartBadge.innerText = data.cartCount;
                }
            }
        });
    }

    function removeItem(id) {
        if(!confirm('Are you sure you want to remove this item?')) return;

        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Remove row
                document.querySelector(`.cart-item[data-id="${id}"]`).remove();
                
                // Update totals
                updateSummary(data.cartTotal, data.savings, data.subtotal);
                
                // Check if empty
                if(data.isEmpty) {
                    document.getElementById('cartContainer').style.display = 'none';
                    document.getElementById('emptyCartHidden').style.display = 'block';
                }
                
                // Update Badge
                const cartBadge = document.querySelector('.cart-count'); 
                if(cartBadge) {
                    cartBadge.innerText = data.cartCount;
                    if(data.cartCount > 0) {
                        cartBadge.style.display = 'flex';
                    } else {
                        cartBadge.style.display = 'none';
                    }
                }
            }
        });
    }

    function updateSummary(total, savings, subtotal) {
        document.getElementById('cart-subtotal').innerText = '₹' + new Intl.NumberFormat().format(subtotal);
        document.getElementById('cart-total').innerText = '₹' + new Intl.NumberFormat().format(total);
        
        const savingsEl = document.getElementById('cart-savings');
        if (savings > 0) {
            if (savingsEl) {
                savingsEl.innerText = '-₹' + new Intl.NumberFormat().format(savings);
            } else {
                // Reload page if savings row was missing but now needed
                location.reload();
            }
        } else if (savingsEl) {
            savingsEl.parentElement.remove();
        }
    }
</script>
@endpush
@endsection
