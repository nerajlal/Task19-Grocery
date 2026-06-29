@extends('v3.layouts.app')

@section('title', ($title ?? 'Combos & Bundles') . ' - Nurah Perfumes')

@push('styles')
<style>
    /* Styling similar to all-products but simplified for bundles */
    .products-container {
        padding: 15px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        padding: 30px 15px; 
        text-align: center;
        background: var(--bg-light);
        margin-bottom: 20px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .product-card {
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
        text-decoration: none;
        color: inherit;
        display: block;
        cursor: pointer; 
    }

    .product-image-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        background: var(--bg-light);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: var(--black);
        color: var(--white);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .product-info {
        padding: 15px;
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .product-price {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 12px;
    }

    .bundle-description {
        font-size: 13px; 
        color: var(--text-light);
        line-height: 1.5;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .combo-products {
        font-size: 11px;
        color: var(--text-light);
        margin-bottom: 10px;
        font-style: italic;
    }

    .add-btn {
        width: 100%;
        padding: 10px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .add-btn:hover {
        background: var(--gold);
    }

    @media (min-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .page-header {
            max-width: 1200px;
            margin: 0 auto 20px;
            border-radius: 20px;
            margin-top: 20px;
        }
    }

    @media (min-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    /* Toast Notification (Same as product page) */
    .toast {
        position: fixed;
        bottom: 100px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: var(--black);
        color: var(--white);
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        z-index: 1000;
        opacity: 0;
        transition: all 0.3s;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* Social Proof Tag */
    .social-proof-tag {
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 8px;
        font-weight: 700;
        color: #000;
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        z-index: 2;
        border: 1px solid rgba(197, 160, 89, 0.2);
        transition: all 0.3s ease;
    }
    .product-card:hover .social-proof-tag {
        transform: translateX(-50%) translateY(-2px);
    }
    .social-proof-tag i { color: var(--gold); font-size: 9px; }
</style>
@endpush

@section('content')
    <div class="page-header">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700;">{{ $title }}</h1>
        <p style="margin-top: 10px; color: var(--text-light);">Exclusive sets curated for you</p>
    </div>

    <div class="products-container">
        @if($bundles->count() > 0)
        <div class="product-grid">
            @foreach($bundles as $bundle)
            <a href="{{ route('v3.combo', ['id' => $bundle->id]) }}" class="product-card">
                <div class="product-image-wrapper">
                    @if($bundle->discount_value > 0)
                    <span class="product-badge">
                        Save {{ $bundle->discount_type == 'percentage' ? number_format($bundle->discount_value) . '%' : '₹' . number_format($bundle->discount_value) }}
                    </span>
                    @endif
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($bundle->image) }}" alt="{{ $bundle->title }}" class="product-image" onerror="handleImageError(this)">
                    <div class="social-proof-tag">
                        <i class="fas fa-shopping-bag"></i>
                        <span>{{ rand(15, 60) }} bundles grabbed recently</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $bundle->title }}</h3>
                    <div class="combo-products">
                        Includes: {{ $bundle->products->pluck('title')->implode(', ') }}
                    </div>
                    <div class="product-price">
                        ₹{{ number_format($bundle->total_price, 0) }}
                    </div>
                     <button class="add-btn" onclick="event.preventDefault(); addToCart({{ $bundle->id }}, '{{ $bundle->title }}', this)">Add to Cart</button>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 50px;">
            <h2>No combos available at the moment.</h2>
            <p>Check back soon for exclusive deals!</p>
        </div>
        @endif
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">Added to cart! 🎉</div>

@endsection

@push('scripts')
<script>
    // Image Fallback
    function handleImageError(img) {
        if (!img.getAttribute('data-error-handled')) {
            img.setAttribute('data-error-handled', 'true');
            img.src = '{{ asset("Images/g-load.webp") }}';
        }
    }

    function addToCart(id, title, btn) {
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
                id: id,
                quantity: 1,
                type: 'bundle'
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const toast = document.getElementById('toast');
                if(toast) {
                    toast.textContent = (title || 'Item') + ' added to cart!';
                    toast.classList.add('show');
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 2500);
                }
                
                if(navigator.vibrate) navigator.vibrate(50);
                
                const cartBadge = document.querySelector('.cart-count'); 
                if(cartBadge) {
                    cartBadge.innerText = data.cartCount;
                    cartBadge.style.display = 'flex';
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
</script>
@endpush
