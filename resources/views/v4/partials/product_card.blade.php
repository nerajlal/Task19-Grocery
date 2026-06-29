@php 
    $stock = $product->variants->sum('stock') > 0;
    $hasDiscount = $product->compare_at_price > $product->starting_price;
    $discountPercent = $hasDiscount ? round((($product->compare_at_price - $product->starting_price) / $product->compare_at_price) * 100) : 0;
@endphp

<div class="a-product-card">
    <div class="a-image-wrapper">
        <a href="{{ route('v4.product', ['id' => $product->id]) }}">
            <img src="{{ $product->main_image_url ?? asset('Images/g-load.webp') }}" 
                 onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                 alt="{{ $product->title }}" 
                 class="a-product-image"
                 loading="lazy">
        </a>
        
        @if($hasDiscount)
            <div class="a-badge-discount">{{ $discountPercent }}% OFF</div>
        @endif

        <button class="a-wishlist-btn"><i class="fa-regular fa-heart"></i></button>
    </div>

    <div class="a-product-info">
        <h3 class="a-product-title">
            <a href="{{ route('v4.product', ['id' => $product->id]) }}">{{ $product->title }}</a>
        </h3>
        
        <div class="a-rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>(12)</span>
        </div>

        <div class="a-product-price">
            <span class="a-price-current">₹{{ number_format($product->starting_price, 0) }}</span>
            @if($hasDiscount)
                <span class="a-price-original">₹{{ number_format($product->compare_at_price, 0) }}</span>
            @endif
        </div>
    </div>

    <button class="a-add-btn" onclick="quickAdd({{ $product->id }})">
        ADD TO CART
    </button>
</div>

<style>
    .a-product-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .a-product-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .a-image-wrapper {
        position: relative;
        height: 220px;
        background: #fff;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .a-image-wrapper a {
        display: block;
        width: 100%;
        height: 100%;
    }

    @media (max-width: 768px) {
        .a-image-wrapper {
            height: 180px;
        }
    }

    .a-product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .a-badge-discount {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #800000; /* Luxury Maroon */
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 50px;
        box-shadow: 0 4px 10px rgba(128, 0, 0, 0.2);
        z-index: 10;
        letter-spacing: 0.5px;
    }

    .a-wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 18px;
        color: #ccc;
        cursor: pointer;
        transition: 0.3s;
    }

    .a-wishlist-btn:hover { color: var(--accent); }

    .a-product-info {
        padding: 10px 12px;
        text-align: left;
    }

    .a-product-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 2px;
        line-height: 1.2;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .a-product-title a { text-decoration: none; color: #333; }

    .a-rating {
        color: #FFD700;
        font-size: 9px;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .a-rating span { color: #999; margin-left: 3px; font-size: 10px; }

    .a-product-price {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
    }

    .a-price-current { font-weight: 700; font-size: 15px; color: #000; }
    .a-price-original { color: #999; text-decoration: line-through; font-size: 12px; }

    .a-tags { display: flex; gap: 5px; margin-bottom: 10px; }
    .a-tag {
        font-size: 9px;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--accent);
        border: 1px solid var(--accent);
        padding: 2px 6px;
        border-radius: 2px;
    }

    .a-add-btn {
        margin-top: auto;
        width: 100%;
        background: #000;
        color: #fff;
        border: none;
        padding: 10px;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: 0.3s;
    }

    .a-add-btn:hover { background: var(--aj-gold); }
</style>
