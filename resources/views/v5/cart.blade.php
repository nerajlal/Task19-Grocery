<div class="af-cart-summary">
    @if(count($cart) > 0)
        <div class="af-cart-items-list">
            @foreach($cart as $id => $item)
                <div class="af-cart-item">
                    <div class="af-cart-item-img">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                    </div>
                    <div class="af-cart-item-info">
                        <h4>{{ $item['title'] }}</h4>
                        <p>{{ $item['size'] ?? '' }}</p>
                        <div class="af-cart-item-price">
                            <span class="qty">{{ $item['quantity'] }} x</span>
                            <span class="price">₹{{ number_format($item['price'], 0) }}</span>
                        </div>
                    </div>
                    <button class="af-remove-item" onclick="removeFromCartV5('{{ $id }}')">&times;</button>
                </div>
            @endforeach
        </div>

        <div class="af-cart-footer">
            <div class="af-cart-total-row">
                <span>Subtotal</span>
                <span>₹{{ number_format($subtotal, 0) }}</span>
            </div>
            @if($savings > 0)
                <div class="af-cart-total-row af-savings">
                    <span>Total Savings</span>
                    <span>-₹{{ number_format($savings, 0) }}</span>
                </div>
            @endif
            <div class="af-cart-total-row total">
                <span>Grand Total</span>
                <span>₹{{ number_format($total, 0) }}</span>
            </div>
            
            <a href="{{ route('v5.checkout') }}" class="af-checkout-btn">Proceed to Checkout</a>
        </div>
    @else
        <div class="af-empty-cart">
            <i class="fa-solid fa-bag-shopping"></i>
            <p>Your shopping bag is empty</p>
            <a href="{{ route('v5.all-products') }}" class="af-btn-dark">Start Shopping</a>
        </div>
    @endif
</div>

<style>
    .af-cart-items-list { display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px; }
    .af-cart-item { display: flex; gap: 15px; position: relative; border-bottom: 1px solid #eee; padding-bottom: 20px; }
    .af-cart-item-img { width: 80px; aspect-ratio: 1; background: #f9f9f9; border-radius: 4px; overflow: hidden; }
    .af-cart-item-img img { width: 100%; height: 100%; object-fit: contain; }
    
    .af-cart-item-info h4 { font-size: 13px; font-weight: 700; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
    .af-cart-item-info p { font-size: 11px; color: #999; margin-bottom: 8px; }
    .af-cart-item-price { font-size: 13px; font-weight: 600; }
    .af-cart-item-price .qty { color: #999; margin-right: 5px; }

    .af-remove-item { position: absolute; top: 0; right: 0; background: none; border: none; font-size: 18px; color: #ccc; cursor: pointer; }
    .af-remove-item:hover { color: #000; }

    .af-cart-footer { padding-top: 20px; border-top: 2px solid #000; }
    .af-cart-total-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
    .af-cart-total-row.total { font-weight: 800; font-size: 18px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee; }
    .af-savings { color: var(--af-red); font-weight: 700; }

    .af-checkout-btn { display: block; background: #000; color: #fff; text-decoration: none; text-align: center; padding: 18px; font-weight: 700; font-size: 12px; letter-spacing: 2px; margin-top: 25px; transition: 0.3s; }
    .af-checkout-btn:hover { background: var(--af-red); }

    .af-empty-cart { text-align: center; padding: 60px 20px; }
    .af-empty-cart i { font-size: 48px; color: #eee; margin-bottom: 20px; }
    .af-empty-cart p { color: #999; margin-bottom: 30px; }
</style>
