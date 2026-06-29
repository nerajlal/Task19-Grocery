@extends('v3.layouts.app')

@section('title', $bundle->title)

@push('styles')
<style>
    /* VARIABLES */
    :root {
        --color-bg: #FFFFFF;
        --color-text: #000000;
        --color-text-muted: #666666;
        --color-gold: #C5A059; 
        --color-border: #EEEEEE;
        
        --font-display: 'Playfair Display', serif;
        --font-body: 'Inter', sans-serif;
    }

    /* GLOBAL RESET */
    body {
        background-color: var(--color-bg);
        color: var(--color-text);
        font-family: var(--font-body);
        -webkit-font-smoothing: antialiased;
    }

    a { text-decoration: none; color: inherit; transition: opacity 0.2s; }
    a:hover { opacity: 0.7; }
    
    button { font-family: var(--font-body); }

    /* LAYOUT - EDITORIAL STYLE */
    .product-wrapper {
        max-width: 1300px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr; /* Image slightly larger */
        gap: 80px; /* Airy spacing */
        align-items: start;
    }

    /* GALLERY - CLEAN */
    .gallery-container {
        position: sticky;
        top: 40px;
    }

    .main-image-frame {
        width: 100%;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .main-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    .thumbnails {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .thumb {
        width: 80px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        opacity: 0.5;
        transition: opacity 0.3s;
        border-radius: 5px;
    }

    .thumb.active, .thumb:hover {
        opacity: 1;
    }

    /* INFO COLUMN */
    .info-container {
        padding-top: 10px;
        max-width: 550px; /* Restrict width for readability */
    }

    .brand-overline {
        font-family: var(--font-body);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--color-text-muted);
        margin-bottom: 20px;
        display: block;
    }

    .product-title {
        font-family: var(--font-display);
        font-size: 48px;
        font-weight: 400; /* Elegant thin weight */
        line-height: 1.1;
        margin: 0 0 20px 0;
        letter-spacing: -0.5px;
    }

    .price-block {
        display: flex;
        align-items: baseline;
        gap: 15px;
        margin-bottom: 40px;
        font-family: var(--font-body);
    }

    .price-current {
        font-size: 24px;
        font-weight: 300;
        color: var(--color-text);
    }

    .price-original {
        font-size: 16px;
        text-decoration: line-through;
        color: #999;
    }

    .discount-badge {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #C5A059;
        letter-spacing: 1px;
    }

    /* PROMO BANNER */
    .promo-banner {
        background: #fdf8ef; /* Very light gold tint */
        color: #8a6d3b;
        border: 1px dashed #C5A059;
        padding: 10px 15px;
        margin-bottom: 30px;
        font-size: 13px;
        font-weight: 500;
        display: inline-block; /* Or block if full width preferred */
        border-radius: 4px;
    }
    
    .promo-code {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: #fff;
        padding: 2px 6px;
        border: 1px solid #C5A059;
        border-radius: 3px;
        margin: 0 4px;
        color: #000;
    }

    /* OPTIONAL INCLUDED PRODUCTS LIST */
    .included-products {
        margin-bottom: 30px;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
    }

    .included-head {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 12px;
        display: block;
        color: var(--color-text-muted);
    }

    .included-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .included-item:last-child { margin-bottom: 0; }

    .included-thumb {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        object-fit: cover;
    }

    /* DESCRIPTION BOX */
    .desc-block {
        margin-bottom: 40px;
        font-size: 15px;
        line-height: 1.8;
        color: #444;
    }

    /* ACTIONS - SHARP & PREMIUM */
    .actions-bar {
        display: flex;
        gap: 20px;
        margin-top: 40px;
    }

    .qty-counter {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        width: 120px;
        justify-content: space-between;
        padding: 0 10px;
        height: 54px; /* Matches button height */
    }

    .qty-control {
        border: none;
        background: transparent;
        font-size: 18px;
        cursor: pointer;
        color: #666;
    }

    .qty-number { font-weight: 600; }

    .btn-main {
        flex: 1;
        background: #000;
        color: #fff;
        border: none;
        height: 54px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-main:hover { background: #333; }

    .btn-secondary {
        flex: 1;
        background: #fff;
        color: #000;
        border: 1px solid #000;
        height: 54px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-secondary:hover { background: #f0f0f0; }

    /* MOBILE ADJUSTMENTS */
    .mobile-back-nav { display: none; }

    @media (max-width: 900px) {
        .product-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .gallery-container { position: static; }
        
        .product-title { font-size: 32px; }

        .mobile-back-nav {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }
        
        .thumb {
            width: 60px;
            height: 75px;
        }
        
        /* Sticky bottoms for mobile actions */
        .actions-bar {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #fff;
            padding: 15px 20px;
            margin: 0;
            border-top: 1px solid #eee;
            z-index: 100;
            gap: 10px;
        }
        
        .btn-main, .btn-secondary, .qty-counter { height: 48px; }
        
        /* Add padding to bottom of page so content isn't hidden by sticky bar */
        .product-wrapper { padding-bottom: 100px; }

        /* Related Grid Mobile */
        .related-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 15px !important;
        }
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }
</style>
@endpush

@section('content')

<div class="product-wrapper">
    
    <!-- Mobile Back (Optional) -->
    <a href="javascript:history.back()" class="mobile-back-nav">
        <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Back
    </a>

    <div class="product-grid">
        
        <!-- LEFT: GALLERY -->
        <div class="gallery-container">
            <div class="main-image-frame">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($bundle->image) }}" alt="{{ $bundle->title }}" class="main-image" id="mainImage" onerror="handleImageError(this)">
            </div>
            
            <!-- Optional: Show images of included products as gallery thumbnails -->
            <div class="thumbnails">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($bundle->image) }}" 
                     class="thumb active" 
                     onclick="swapMain('{{ \Illuminate\Support\Facades\Storage::url($bundle->image) }}'); setActiveThumb(this)"
                     alt="{{ $bundle->title }}"
                     onerror="handleImageError(this)">
                     
                @foreach($bundle->products as $index => $prod)
                    @if($prod->images->count() > 0)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($prod->images->first()->path) }}" 
                         class="thumb" 
                         onclick="swapMain('{{ \Illuminate\Support\Facades\Storage::url($prod->images->first()->path) }}'); setActiveThumb(this)"
                         alt="{{ $prod->title }}"
                         onerror="handleImageError(this)">
                    @endif
                @endforeach
            </div>
        </div>

        <!-- RIGHT: STORY & ACTIONS -->
        <div class="info-container">
            
            <span class="brand-overline">Exclusive Bundle</span>
            <h1 class="product-title">{{ $bundle->title }}</h1>
            
            <div class="price-block">
                @php
                    $originalPrice = $bundle->products->sum(function($prod) {
                        return $prod->variants->min('price') ?? 0;
                    });
                @endphp

                @if($originalPrice > $bundle->total_price)
                    <span class="price-current" id="displayPrice">₹{{ number_format($bundle->total_price, 0) }}</span>
                    <span class="price-original">₹{{ number_format($originalPrice, 0) }}</span>
                    <span class="discount-badge">Save {{ $bundle->discount_value > 0 ? ($bundle->discount_type == 'percentage' ? number_format($bundle->discount_value) . '%' : '₹' . number_format($bundle->discount_value)) : '' }}</span>
                @else
                    <span class="price-current" id="displayPrice">₹{{ number_format($bundle->total_price, 0) }}</span>
                @endif
            </div>

            @if(isset($coupon))
            <div class="promo-banner">
                <i class="fas fa-tag" style="font-size: 12px; margin-right: 6px;"></i> Use code <span class="promo-code">{{ $coupon->code }}</span> for an extra {{ $coupon->type == 'percentage' ? number_format($coupon->value) . '%' : '₹' . number_format($coupon->value) }} OFF!
            </div>
            @endif

            <!-- Included Products -->
            <div class="included-products">
                <span class="included-head">Included In This Set</span>
                @foreach($bundle->products as $prod)
                <div class="included-item">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($prod->images->first()->path ?? '') }}" class="included-thumb" onerror="handleImageError(this)">
                    <div>
                        <strong>{{ $prod->title }}</strong> <span style="color: #666; font-size: 12px;">({{ $prod->variants->first()->size ?? '' }})</span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Description -->
            <div class="desc-block">
                {!! nl2br(e($bundle->description)) !!}
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                @if(!$bundle->is_out_of_stock)
                    <div class="qty-counter">
                        <button class="qty-control" onclick="updateQty(-1)">−</button>
                        <span class="qty-number" id="qtyVal">1</span>
                        <button class="qty-control" onclick="updateQty(1)">+</button>
                    </div>
                    <button class="btn-main" onclick="addToCart('{{ $bundle->title }}')">Add to Bag</button>
                    <button class="btn-secondary" onclick="location.href='{{ route('v3.checkout') }}'">Buy It Now</button>
                @else
                     <div class="qty-counter" style="opacity: 0.5; pointer-events: none;">
                        <button class="qty-control" disabled>−</button>
                        <span class="qty-number">0</span>
                        <button class="qty-control" disabled>+</button>
                    </div>
                    <button class="btn-main" disabled style="background: #ccc; cursor: not-allowed;">Out of Stock</button>
                    <button class="btn-secondary" disabled style="opacity: 0.5; cursor: not-allowed;">Buy It Now</button>
                @endif
            </div>
            
            <p style="text-align: center; margin-top: 15px; font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 1px;">Free Shipping over ₹399 • 14-Day Returns</p>

        </div>
    </div>
</div>

<!-- Recently Viewed / Related -->
@if(isset($relatedBundles) && $relatedBundles->count() > 0)
<div class="product-wrapper" style="padding-top: 0;">
    <h3 style="font-family: var(--font-display); font-size: 24px; margin-bottom: 30px; border-top: 1px solid var(--color-border); padding-top: 40px;">You May Also Like</h3>
    
    <div class="related-grid">
        @foreach($relatedBundles as $related)
        <a href="{{ route('v3.combo', ['id' => $related->id]) }}" style="text-decoration: none;">
            <div style="background: #f9f9f9; aspect-ratio: 1; margin-bottom: 15px; border-radius: 10px; overflow: hidden;">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($related->image) }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onerror="handleImageError(this)">
            </div>
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <h4 style="font-family: var(--font-display); font-size: 15px; margin: 0; font-weight: 500; line-height: 1.3; color: var(--color-text);">{{ $related->title }}</h4>
                <span style="font-size: 14px; font-weight: 600; color: var(--color-text); white-space: nowrap; margin-left: 10px;">₹{{ number_format($related->total_price) }}</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<div id="toast" style="position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: #000; color: #fff; padding: 15px 30px; font-size: 13px; font-weight: 500; letter-spacing: 1px; opacity: 0; pointer-events: none; transition: opacity 0.3s; z-index: 1000; text-transform: uppercase;">
    Added to Bag
</div>

@endsection

@push('scripts')
<script>
    let quantity = 1;

    // Image Fallback
    function handleImageError(img) {
        if (!img.getAttribute('data-error-handled')) {
            img.setAttribute('data-error-handled', 'true');
            img.src = '{{ asset("Images/g-load.webp") }}';
        }
    }

    function updateQty(change) {
        if (quantity + change >= 1) {
            quantity += change;
            document.getElementById('qtyVal').innerText = quantity;
        }
    }

    function addToCart(title) {
        const btn = document.querySelector('.btn-main');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '...';

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: {{ $bundle->id }}, // Bundle ID
                quantity: quantity,
                type: 'bundle'
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const toast = document.getElementById('toast');
                toast.innerText = (title || 'Item') + ' Added to Bag';
                toast.style.opacity = '1';
                setTimeout(() => toast.style.opacity = '0', 2500);
                
                if(navigator.vibrate) navigator.vibrate(50);
                
                const cartBadge = document.querySelector('.cart-count'); 
                if(cartBadge) {
                    cartBadge.innerText = data.cartCount;
                    cartBadge.style.display = 'flex'; // Ensure visible
                }
            } else {
                alert(data.message || 'Error adding to cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
    
    function swapMain(src) {
        document.getElementById('mainImage').src = src;
    }

    function setActiveThumb(el) {
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }
</script>
@endpush