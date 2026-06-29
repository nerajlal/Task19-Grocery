<div class="v-card">
    <div class="v-img-box">
        <a href="{{ route('velvet.product', ['id' => $product->id]) }}" style="display: block; height: 100%;">
            @if(isset($badge))
                <span class="v-badge">{{ $badge }}</span>
            @endif
            <img src="{{ $product->main_image_url ?? asset('Images/g-load.webp') }}" 
                 onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                 alt="{{ $product->title }}">
            <div class="social-proof-tag">
                <i class="fa-solid fa-crown"></i>
                <span>{{ rand(30, 120) }} sold this month</span>
            </div>
        </a>
        <button class="v-quick-add-overlay" onclick="quickAdd({{ $product->id }}, '{{ $product->variants->first()->size ?? '' }}', {{ $product->variants->first()->id ?? 'null' }})">
            <i class="fa-solid fa-cart-plus"></i> QUICK ADD
        </button>
    </div>
    <div class="v-details">
        <h3 class="v-name"><a href="{{ route('velvet.product', ['id' => $product->id]) }}" style="text-decoration: none; color: inherit;">{{ $product->title }}</a></h3>
        <p class="v-price">₹{{ number_format($product->starting_price, 0) }}</p>
    </div>
</div>
