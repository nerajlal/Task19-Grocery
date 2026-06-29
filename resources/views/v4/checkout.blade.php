@extends('v4.layouts.app')

@section('title', 'Secure Checkout | Task19 Luxury Fragrance')

@section('content')
    <div class="container" style="margin-top: 30px;">
        <nav class="v4-breadcrumb">
            <a href="{{ route('v4.home') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('v4.cart') }}">Shopping Bag</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Checkout</span>
        </nav>

        <header class="v4-page-header" style="margin-top: 50px; margin-bottom: 50px;">
            <h1 class="cursive aj-title">SECURE <span class="sketch-under">CHECKOUT</span></h1>
        </header>

        <form action="{{ route('order.place') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="v4-checkout-layout">
                <!-- Left: Delivery Details -->
                <div class="v4-checkout-main-col">
                    <div class="v4-checkout-section">
                        <h3 class="serif">SHIPPING ADDRESS</h3>
                        <div class="v4-address-form">
                            <div class="v4-form-grid">
                                <div class="v4-form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" value="{{ Auth::user()->first_name ?? '' }}" required>
                                </div>
                                <div class="v4-form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="{{ Auth::user()->last_name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="v4-form-group">
                                <label>Street Address</label>
                                <input type="text" name="address" value="{{ $address->address ?? '' }}" required>
                            </div>
                            <div class="v4-form-grid">
                                <div class="v4-form-group">
                                    <label>City</label>
                                    <input type="text" name="city" value="{{ $address->city ?? '' }}" required>
                                </div>
                                <div class="v4-form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" value="{{ $address->phone ?? Auth::user()->phone ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="v4-checkout-section" style="margin-top: 40px;">
                        <h3 class="serif">PAYMENT METHOD</h3>
                        <div class="v4-payment-options">
                            <label class="v4-payment-card active">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div class="v4-payment-card-inner">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                    <span>Cash on Delivery (COD)</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="v4-checkout-summary-col">
                    <div class="v4-checkout-summary-card">
                        <h3 class="serif">ORDER SUMMARY</h3>
                        <div class="v4-summary-items">
                            @foreach($cart as $item)
                                <div class="v4-summary-item">
                                    <div class="v4-summary-item-img">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                                        <span class="v4-summary-qty">{{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="v4-summary-item-info">
                                        <strong>{{ $item['name'] }}</strong>
                                        <span>{{ $item['size'] ?? 'Combo' }}</span>
                                    </div>
                                    <div class="v4-summary-item-price">
                                        ₹{{ number_format($item['price'] * $item['quantity'], 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="v4-summary-totals">
                            <div class="v4-summary-row">
                                <span>Subtotal</span>
                                <span>₹{{ number_format($subtotal, 0) }}</span>
                            </div>
                            <div class="v4-summary-row">
                                <span>Shipping</span>
                                <span style="color: #10B981;">FREE</span>
                            </div>
                            <div class="v4-summary-row total">
                                <span>Total</span>
                                <span style="font-size: 24px;">₹{{ number_format($total, 0) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="v4-place-order-btn">
                            PLACE ORDER NOW
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .v4-breadcrumb { display: flex; align-items: center; gap: 10px; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; color: var(--aj-gray); }
        .v4-breadcrumb a { text-decoration: none; color: inherit; transition: 0.3s; }
        .v4-breadcrumb a:hover { color: var(--aj-gold); }
        .v4-breadcrumb i { font-size: 8px; opacity: 0.5; }

        .v4-checkout-layout { display: grid; grid-template-columns: 1fr 450px; gap: 80px; margin-bottom: 100px; }

        .v4-checkout-section h3 { font-size: 14px; letter-spacing: 2px; margin-bottom: 30px; font-weight: 800; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        
        .v4-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .v4-form-group { margin-bottom: 20px; }
        .v4-form-group label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--aj-gray); margin-bottom: 8px; letter-spacing: 1px; }
        .v4-form-group input { width: 100%; padding: 15px; border: 1.5px solid #eee; border-radius: 6px; outline: none; font-family: inherit; font-size: 14px; transition: 0.3s; }
        .v4-form-group input:focus { border-color: var(--aj-gold); }

        .v4-payment-card { display: block; cursor: pointer; }
        .v4-payment-card input { display: none; }
        .v4-payment-card-inner { border: 2px solid var(--aj-gold); background: #fffaf0; padding: 25px; border-radius: 12px; display: flex; align-items: center; gap: 20px; }
        .v4-payment-card-inner i { font-size: 24px; color: var(--aj-gold); }
        .v4-payment-card-inner span { font-weight: 700; color: var(--aj-dark); }

        .v4-checkout-summary-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 40px; position: sticky; top: 120px; }
        .v4-checkout-summary-card h3 { font-size: 14px; letter-spacing: 2px; margin-bottom: 30px; font-weight: 800; }
        
        .v4-summary-items { display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px; }
        .v4-summary-item { display: grid; grid-template-columns: 60px 1fr auto; gap: 20px; align-items: center; }
        .v4-summary-item-img { position: relative; width: 60px; height: 60px; background: #f9f9f9; border-radius: 6px; border: 1px solid #eee; }
        .v4-summary-item-img img { width: 100%; height: 100%; object-fit: cover; }
        .v4-summary-qty { position: absolute; top: -8px; right: -8px; width: 20px; height: 20px; background: var(--aj-gold); color: #fff; font-size: 10px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; }
        .v4-summary-item-info strong { display: block; font-size: 14px; color: var(--aj-dark); }
        .v4-summary-item-info span { font-size: 11px; color: var(--aj-gray); font-weight: 700; text-transform: uppercase; }
        .v4-summary-item-price { font-weight: 700; color: var(--aj-dark); }

        .v4-summary-totals { border-top: 1px solid #eee; padding-top: 25px; }
        .v4-summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-weight: 600; color: var(--aj-gray); }
        .v4-summary-row.total { margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee; color: var(--aj-dark); font-weight: 800; }

        .v4-place-order-btn { width: 100%; background: #000; color: #fff; border: none; padding: 25px; border-radius: 4px; font-weight: 900; font-size: 15px; letter-spacing: 2px; cursor: pointer; transition: 0.3s; margin-top: 30px; }
        .v4-place-order-btn:hover { background: var(--aj-gold); transform: translateY(-5px); box-shadow: 0 15px 30px rgba(176, 141, 87, 0.3); }

        @media (max-width: 1024px) {
            .v4-checkout-layout { grid-template-columns: 1fr; gap: 40px; }
            .v4-checkout-summary-col { order: -1; }
            .v4-checkout-summary-card { position: static; }
        }
    </style>
@endsection
