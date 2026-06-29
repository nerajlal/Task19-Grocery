@if(count($cart) > 0)
    <div class="cart-items-list-v">
        @foreach($cart as $key => $item)
            <div class="cart-item-v" data-key="{{ $key }}">
                <div class="cart-item-img-v">
                    <img src="{{ asset($item['image'] ?? 'Images/g-load.webp') }}" alt="{{ $item['name'] }}">
                </div>
                <div class="cart-item-info-v">
                    <h4 class="cart-item-name-v">{{ $item['name'] }}</h4>
                    <p class="cart-item-meta-v">{{ $item['size'] ?? 'Standard Size' }}</p>
                    <div class="cart-item-qty-v">
                        <button class="qty-btn-v" onclick="updateDrawerQty('{{ $key }}', -1)">-</button>
                        <span class="qty-val-v">{{ $item['quantity'] }}</span>
                        <button class="qty-btn-v" onclick="updateDrawerQty('{{ $key }}', 1)">+</button>
                    </div>
                </div>
                <div class="cart-item-price-v">
                    ₹{{ number_format($item['price'] * $item['quantity'], 0) }}
                    <button class="remove-item-v" onclick="removeDrawerItem('{{ $key }}')">Remove</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="cart-summary-v">
        <div class="summary-row-v">
            <span>Subtotal</span>
            <span>₹{{ number_format($subtotal, 0) }}</span>
        </div>
        @if($savings > 0)
            <div class="summary-row-v savings-v">
                <span>Savings</span>
                <span>-₹{{ number_format($savings, 0) }}</span>
            </div>
        @endif
        <div class="summary-row-v total-v">
            <span>Estimated Total</span>
            <span>₹{{ number_format($total, 0) }}</span>
        </div>
        
        <a href="{{ route('checkout') }}" class="checkout-btn-v">CHECKOUT SECURELY</a>
        <p class="shipping-note-v">Shipping & taxes calculated at checkout.</p>
    </div>
@else
    <div class="empty-cart-v">
        <i class="fa-solid fa-bag-shopping"></i>
        <h3>Your bag is empty</h3>
        <p>Explore our exquisite collections and find your signature scent.</p>
        <a href="{{ route('velvet.all-products') }}" class="shop-now-v">START SHOPPING</a>
    </div>
@endif

<style>
    .cart-items-list-v {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .cart-item-v {
        display: flex;
        gap: 1rem;
        align-items: center;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .cart-item-img-v {
        width: 80px;
        height: 100px;
        flex-shrink: 0;
        background: #f9f9f9;
        border-radius: 4px;
        overflow: hidden;
    }

    .cart-item-img-v img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-info-v {
        flex-grow: 1;
    }

    .cart-item-name-v {
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
        color: #000;
    }

    .cart-item-meta-v {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .cart-item-qty-v {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f5f5f5;
        width: fit-content;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
    }

    .qty-btn-v {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        color: #666;
        padding: 0 0.5rem;
    }

    .qty-val-v {
        font-size: 0.9rem;
        font-weight: 600;
        min-width: 20px;
        text-align: center;
    }

    .cart-item-price-v {
        text-align: right;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .remove-item-v {
        background: none;
        border: none;
        color: #999;
        font-size: 0.7rem;
        text-decoration: underline;
        cursor: pointer;
        margin-top: auto;
    }

    .cart-summary-v {
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .summary-row-v {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        color: #666;
    }

    .summary-row-v.savings-v {
        color: #10B981;
        font-weight: 600;
    }

    .summary-row-v.total-v {
        margin-top: 1rem;
        font-size: 1.1rem;
        font-weight: 800;
        color: #000;
    }

    .checkout-btn-v {
        display: block;
        width: 100%;
        background: #000;
        color: #fff;
        text-align: center;
        padding: 1.25rem;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.1em;
        margin-top: 1.5rem;
        transition: background 0.3s;
    }

    .checkout-btn-v:hover {
        background: #333;
    }

    .shipping-note-v {
        font-size: 0.75rem;
        color: #999;
        text-align: center;
        margin-top: 1rem;
    }

    .empty-cart-v {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        padding: 2rem;
    }

    .empty-cart-v i {
        font-size: 3rem;
        color: #eee;
        margin-bottom: 1.5rem;
    }

    .empty-cart-v h3 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 1rem;
    }

    .empty-cart-v p {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 2rem;
    }

    .shop-now-v {
        padding: 1rem 2rem;
        background: #000;
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        border-radius: 4px;
        font-size: 0.85rem;
    }
</style>
