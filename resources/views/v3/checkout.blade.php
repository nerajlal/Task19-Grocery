@extends('v3.layouts.app')

@section('title', 'Checkout - Nurah Perfumes')

@push('styles')
<style>
    .checkout-page {
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
        min-height: 80vh;
    }
    
    .checkout-container {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 50px;
        margin-top: 30px;
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border);
        color: var(--black);
    }
    
    /* Form Styles */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        transition: border 0.3s;
        outline: none;
    }
    
    .form-control:focus {
        border-color: var(--black);
    }
    
    /* Order Summary & Payment */
    .order-summary-box {
        background: var(--bg-light);
        padding: 30px;
        border-radius: 12px;
        position: sticky;
        top: 100px;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #ddd;
    }
    
    .summary-item:last-of-type {
        border-bottom: none;
    }
    
    .prod-name {
        font-weight: 500;
        color: var(--black);
    }
    
    .prod-meta {
        font-size: 12px;
        color: var(--text-light);
        margin-top: 4px;
    }

    .totals-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        color: var(--text);
        font-size: 14px;
    }
    
    .final-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid var(--black);
        font-weight: 800;
        font-size: 20px;
        color: var(--black);
    }
    
    /* Payment Method */
    .payment-method {
        background: var(--white);
        border: 2px solid var(--black);
        padding: 20px;
        border-radius: 8px;
        margin: 25px 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .pay-radio {
        width: 20px;
        height: 20px;
        accent-color: var(--black);
    }
    
    .pay-label {
        font-weight: 700;
        color: var(--black);
        font-size: 15px;
    }
    
    .pay-desc {
        font-size: 12px;
        color: var(--text-light);
        margin-top: 5px;
        display: block;
    }
    
    .place-order-btn {
        width: 100%;
        padding: 18px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background 0.3s;
        font-size: 15px;
    }
    
    .place-order-btn:hover {
        background: #333;
    }
    
    @media (max-width: 900px) {
        .checkout-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .order-summary-box {
            position: static;
            order: -1; /* Show summary first on mobile? Usually better after contact info, but let's keep standard flow */
            order: 1; /* Standard flow: Details -> Payment */
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="checkout-page">
    <div class="checkout-container">
        <!-- Shipping Details -->
        <div class="checkout-left">
            <h2 class="section-title">Shipping Address</h2>
            <form id="shippingForm" action="#" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" required value="{{ Auth::check() ? explode(' ', Auth::user()->name)[0] : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" required value="{{ Auth::check() ? (explode(' ', Auth::user()->name)[1] ?? '') : '' }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="neraj@example.com" required value="{{ Auth::check() ? Auth::user()->email : '' }}">
                </div>
                
                <div class="form-group">
                    <label>Street Address</label>
                    <input type="text" name="address" class="form-control" placeholder="House number and street name" required value="{{ $address->address_line1 ?? '' }}">
                </div>
                
                <div class="form-group">
                    <label>Apartment, suite, etc. (optional)</label>
                    <input type="text" name="apartment" class="form-control" placeholder="" value="{{ $address->address_line2 ?? '' }}">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" placeholder="Mumbai" required value="{{ $address->city ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>State / Province</label>
                        <select name="state" class="form-control" required>
                            <option value="">Select State</option>
                            <option value="AP" {{ ($address->state ?? '') == 'AP' ? 'selected' : '' }}>Andhra Pradesh</option>
                            <option value="AR" {{ ($address->state ?? '') == 'AR' ? 'selected' : '' }}>Arunachal Pradesh</option>
                            <option value="AS" {{ ($address->state ?? '') == 'AS' ? 'selected' : '' }}>Assam</option>
                            <option value="BR" {{ ($address->state ?? '') == 'BR' ? 'selected' : '' }}>Bihar</option>
                            <option value="CG" {{ ($address->state ?? '') == 'CG' ? 'selected' : '' }}>Chhattisgarh</option>
                            <option value="GA" {{ ($address->state ?? '') == 'GA' ? 'selected' : '' }}>Goa</option>
                            <option value="GJ" {{ ($address->state ?? '') == 'GJ' ? 'selected' : '' }}>Gujarat</option>
                            <option value="HR" {{ ($address->state ?? '') == 'HR' ? 'selected' : '' }}>Haryana</option>
                            <option value="HP" {{ ($address->state ?? '') == 'HP' ? 'selected' : '' }}>Himachal Pradesh</option>
                            <option value="JH" {{ ($address->state ?? '') == 'JH' ? 'selected' : '' }}>Jharkhand</option>
                            <option value="KA" {{ ($address->state ?? '') == 'KA' ? 'selected' : '' }}>Karnataka</option>
                            <option value="KL" {{ ($address->state ?? '') == 'KL' ? 'selected' : '' }}>Kerala</option>
                            <option value="MP" {{ ($address->state ?? '') == 'MP' ? 'selected' : '' }}>Madhya Pradesh</option>
                            <option value="MH" {{ ($address->state ?? '') == 'MH' ? 'selected' : '' }}>Maharashtra</option>
                            <option value="MN" {{ ($address->state ?? '') == 'MN' ? 'selected' : '' }}>Manipur</option>
                            <option value="ML" {{ ($address->state ?? '') == 'ML' ? 'selected' : '' }}>Meghalaya</option>
                            <option value="MZ" {{ ($address->state ?? '') == 'MZ' ? 'selected' : '' }}>Mizoram</option>
                            <option value="NL" {{ ($address->state ?? '') == 'NL' ? 'selected' : '' }}>Nagaland</option>
                            <option value="OR" {{ ($address->state ?? '') == 'OR' ? 'selected' : '' }}>Odisha</option>
                            <option value="PB" {{ ($address->state ?? '') == 'PB' ? 'selected' : '' }}>Punjab</option>
                            <option value="RJ" {{ ($address->state ?? '') == 'RJ' ? 'selected' : '' }}>Rajasthan</option>
                            <option value="SK" {{ ($address->state ?? '') == 'SK' ? 'selected' : '' }}>Sikkim</option>
                            <option value="TN" {{ ($address->state ?? '') == 'TN' ? 'selected' : '' }}>Tamil Nadu</option>
                            <option value="TG" {{ ($address->state ?? '') == 'TG' ? 'selected' : '' }}>Telangana</option>
                            <option value="TR" {{ ($address->state ?? '') == 'TR' ? 'selected' : '' }}>Tripura</option>
                            <option value="UP" {{ ($address->state ?? '') == 'UP' ? 'selected' : '' }}>Uttar Pradesh</option>
                            <option value="UT" {{ ($address->state ?? '') == 'UT' ? 'selected' : '' }}>Uttarakhand</option>
                            <option value="WB" {{ ($address->state ?? '') == 'WB' ? 'selected' : '' }}>West Bengal</option>
                            <option value="AN" {{ ($address->state ?? '') == 'AN' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                            <option value="CH" {{ ($address->state ?? '') == 'CH' ? 'selected' : '' }}>Chandigarh</option>
                            <option value="DN" {{ ($address->state ?? '') == 'DN' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                            <option value="DL" {{ ($address->state ?? '') == 'DL' ? 'selected' : '' }}>Delhi</option>
                            <option value="JK" {{ ($address->state ?? '') == 'JK' ? 'selected' : '' }}>Jammu and Kashmir</option>
                            <option value="LA" {{ ($address->state ?? '') == 'LA' ? 'selected' : '' }}>Ladakh</option>
                            <option value="LD" {{ ($address->state ?? '') == 'LD' ? 'selected' : '' }}>Lakshadweep</option>
                            <option value="PY" {{ ($address->state ?? '') == 'PY' ? 'selected' : '' }}>Puducherry</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>ZIP / Postal Code</label>
                        <input type="text" name="zip" class="form-control" placeholder="400001" required value="{{ $address->zip ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210" required value="{{ Auth::user()->phone ?? ($address->phone ?? '') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Order Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                </div>
            </form>
        </div>
        
        <!-- Order Summary -->
        <div class="checkout-right">
            <div class="order-summary-box">
                <h2 class="section-title">Your Order</h2>
                
                <div class="cart-items-review">
                    @forelse($cart as $id => $details)
                    <div class="summary-item">
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                            <div>
                                <div class="prod-name">{{ $details['name'] }}</div>
                                <div class="prod-meta">Qty: {{ $details['quantity'] }} @if(isset($details['size'])) | {{ $details['size'] }} @endif</div>
                            </div>
                        </div>
                        <div class="prod-price">
                            @if(isset($details['coupon']) && $details['coupon'])
                                @php
                                    $discountVal = $details['coupon']->type == 'percentage' 
                                        ? $details['price'] * ($details['coupon']->value / 100) 
                                        : $details['coupon']->value;
                                    $newPrice = max(0, $details['price'] - $discountVal);
                                    $totalPrice = $newPrice * $details['quantity'];
                                    $savedAmount = ($details['price'] - $newPrice) * $details['quantity'];
                                @endphp
                                <div style="text-align: right;">
                                    <div style="color: #black; font-weight: 700;">₹{{ number_format($totalPrice) }}</div>
                                    <div style="font-size: 11px; color: #999; text-decoration: line-through;">₹{{ number_format($details['price'] * $details['quantity']) }}</div>
                                    <div style="font-size: 11px; color: #28a745; margin-top: 2px;">
                                        {{ $details['coupon']->code }} Applied<br>
                                        Saved ₹{{ number_format($savedAmount) }}
                                    </div>
                                </div>
                            @else
                                ₹{{ number_format($details['price'] * $details['quantity']) }}
                            @endif
                        </div>
                    </div>
                    @empty
                    <p>Your cart is empty.</p>
                    @endforelse
                </div>
                
                <div style="margin: 20px 0; border-top: 1px solid #ddd; padding-top: 20px;">
                    <div class="totals-row">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($subtotal) }}</span>
                    </div>
                    <div class="totals-row">
                        <span>Shipping</span>
                        <span style="color: green; font-weight: 600;">Free</span>
                    </div>
                    @if($savings > 0)
                    <div class="totals-row" style="color: #C5A059; font-weight: 700;">
                        <span>Bundle / Volume Discount</span>
                        <span>-₹{{ number_format($savings) }}</span>
                    </div>
                    @endif
                    <div class="final-total">
                        <span>Total</span>
                        <span>₹{{ number_format($total) }}</span>
                    </div>
                </div>
                
                <h3 style="font-size: 16px; font-weight: 700; margin-top: 30px; margin-bottom: 15px;">Payment Method</h3>
                
                <div class="payment-method">
                    <input type="radio" name="payment" id="cod" class="pay-radio" value="cod" checked>
                    <div>
                        <label for="cod" class="pay-label">Cash on Delivery (COD)</label>
                        <span class="pay-desc">Pay with cash upon delivery. No extra charges.</span>
                    </div>
                </div>
                
                <p style="font-size: 12px; color: #666; margin-bottom: 20px; line-height: 1.6;">
                    Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="{{ route('v3.terms-of-service') }}" style="color: var(--black); text-decoration: underline;">privacy policy</a>.
                </p>
                
                <button type="button" class="place-order-btn" onclick="placeOrder()">Place Order</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @guest
            // Trigger login popup for guests
            setTimeout(() => {
                if(typeof openLogin === 'function') {
                    openLogin();
                } else {
                    console.warn('openLogin function not found');
                }
            }, 500);
        @endguest
    });

    function placeOrder() {
        @guest
            openLogin();
            return;
        @endguest

        const form = document.getElementById('shippingForm');
        if (form.checkValidity()) {
            // Show loading state
            const btn = document.querySelector('.place-order-btn');
            const originalText = btn.innerText;
            btn.innerText = 'Processing...';
            btn.disabled = true;

            // Collect form data
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            // Map payment method and match standard fields
            data.name = ((data.first_name || '') + ' ' + (data.last_name || '')).trim();
            data.pincode = data.zip;
            const paymentRadio = document.querySelector('input[name="payment"]:checked');
            data.payment_method = paymentRadio ? paymentRadio.value : 'cod';
            
            fetch('{{ route("order.place") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Order Placed Successfully! Order ID: ' + data.order_id);
                    window.location.href = data.redirect_url;
                } else {
                    alert('Error: ' + data.message);
                    btn.innerText = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
                btn.innerText = originalText;
                btn.disabled = false;
            });
            
        } else {
            form.reportValidity();
        }
    }
</script>
@endpush
@endsection
