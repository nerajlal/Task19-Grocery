@extends('layouts.storefront')

@section('title', $bundle->title . ' | Exclusive Combo | VESPR Perfumes')

@section('content')
<div class="product-page-container">
    <div class="breadcrumb">
        <a href="{{ route('v1.home') }}">Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('v1.combos') }}">Combos</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>{{ $bundle->title }}</span>
    </div>

    <div class="product-core-grid">
        <!-- Gallery -->
        <div class="product-gallery">
            <div class="main-image-display">
                @php 
                    $mainImg = $bundle->image ? Storage::url($bundle->image) : asset('Images/g-load.webp');
                @endphp
                <img src="{{ $mainImg }}" id="p-main-img" alt="{{ $bundle->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
            </div>
        </div>

        <!-- Info -->
        <div class="product-details-panel">
            <div style="background: var(--accent-color); color: var(--primary-color); display: inline-block; padding: 0.25rem 1rem; border-radius: 9999px; font-weight: 700; font-size: 0.8rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Exclusive Savings
            </div>
            <h1 class="p-title-lg">{{ $bundle->title }}</h1>
            <p class="p-vendor-lg">Curated Performance Set</p>
            
            <div class="p-price-block-lg">
                <span class="p-price-lg">₹{{ number_format($bundle->total_price, 2) }}</span>
                @php
                    $originalPrice = $bundle->products->sum(function($p) {
                        return $p->variants->min('price') ?? 0;
                    });
                @endphp
                @if($originalPrice > $bundle->total_price)
                    <span class="p-compare-lg">₹{{ number_format($originalPrice, 2) }}</span>
                    <div style="color: #10B981; font-weight: 700; font-size: 1rem;">
                        Save ₹{{ number_format($originalPrice - $bundle->total_price, 0) }}
                    </div>
                @endif
            </div>

            <!-- Tabby EMI Promo (Top) -->
            <div style="margin-top: -1rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.6rem; font-size: 0.9rem; color: var(--text-muted); background: #fdfdfd; padding: 0.5rem 0.75rem; border-radius: 0.75rem; width: fit-content; border: 1px solid #f1f5f9;">
                <span style="display: flex; align-items: center; gap: 0.4rem;">or 4 interest-free payments of <strong style="color: var(--primary-color);">₹{{ number_format($bundle->total_price / 4, 0) }}</strong> with</span>
                <span style="background: #3DF9D1; color: #000; padding: 0.15rem 0.6rem; border-radius: 0.3rem; font-weight: 900; font-size: 0.75rem; letter-spacing: -0.01em; text-transform: lowercase;">tabby</span>
            </div>

            <!-- Delivery Date Info -->
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; background: var(--section-bg); padding: 0.85rem 1.25rem; border-radius: 1rem; border: 1px solid var(--border-color); width: 100%;">
                <i class="fa-solid fa-truck-fast" style="color: var(--accent-color); font-size: 1.1rem;"></i>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Arriving by</span>
                    <span style="font-weight: 700; color: var(--primary-color); font-size: 0.9rem;">{{ now()->addDays(2)->format('l, M jS') }}</span>
                </div>
            </div>

            <div class="p-tabs" style="border-top: none; padding-top: 0; margin-bottom: 3rem;">
                <h3 class="p-section-title">Description</h3>
                <p style="color: var(--text-muted); line-height: 1.8;">{{ $bundle->description }}</p>
            </div>

            <div class="bundle-contents" style="margin-bottom: 3rem;">
                <h3 class="p-section-title">Products Included</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($bundle->products as $product)
                        <div class="bundle-product-item" style="background: var(--section-bg); border-radius: 1rem; border: 1px solid var(--border-color); overflow: hidden;">
                            <div style="display: flex; align-items: center; gap: 1.5rem; padding: 1rem;">
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'" style="width: 60px; height: 60px; border-radius: 0.5rem; object-fit: cover;">
                                <div style="flex-grow: 1;">
                                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.25rem;">
                                        @if($product->pivot->quantity > 1) {{ $product->pivot->quantity }}x @endif
                                        {{ $product->title }}
                                    </h4>
                                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">
                                        @if($product->pivot->product_variant_id)
                                            @php $v = $product->variants->firstWhere('id', $product->pivot->product_variant_id); @endphp
                                            {{ $v->size ?? $product->type }}
                                        @else
                                            {{ $product->type }}
                                        @endif
                                        • {{ $product->olfactory_family }}
                                    </p>
                                    <div style="font-weight: 700; color: var(--primary-color); font-size: 0.9rem;">
                                        @if($product->pivot->product_variant_id)
                                            ₹{{ number_format($v->price ?? $product->starting_price, 2) }}
                                        @else
                                            ₹{{ number_format($product->starting_price, 2) }}
                                        @endif
                                    </div>
                                </div>
                                <button onclick="toggleProductDetails({{ $product->id }})" style="background: none; border: none; font-size: 0.85rem; font-weight: 600; color: var(--accent-color); cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                    <span id="text-{{ $product->id }}">View Details</span> <i class="fa-solid fa-chevron-down" id="chevron-{{ $product->id }}" style="transition: transform 0.3s ease;"></i>
                                </button>
                            </div>
                            <div id="details-{{ $product->id }}" style="display: none; padding: 0 1rem 1rem 1rem; border-top: 1px solid var(--border-color); background: #fff;">
                                <div style="margin-top: 1rem;">
                                    <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">{{ $product->description }}</p>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; font-size: 0.8rem; background: var(--section-bg); padding: 1rem; border-radius: 0.75rem;">
                                        <div><strong style="display: block; color: var(--primary-color); margin-bottom: 0.25rem;">Top Notes</strong> {{ $product->notes_top }}</div>
                                        <div><strong style="display: block; color: var(--primary-color); margin-bottom: 0.25rem;">Heart Notes</strong> {{ $product->notes_heart }}</div>
                                        <div><strong style="display: block; color: var(--primary-color); margin-bottom: 0.25rem;">Base Notes</strong> {{ $product->notes_base }}</div>
                                    </div>
                                    <div style="margin-top: 1.5rem;">
                                        <button onclick="showProductPopup({{ $product->id }})" class="btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.85rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.5rem; background: var(--primary-color); color: #fff; border: none; cursor: pointer;">
                                            Quick View Details <i class="fa-solid fa-expand" style="font-size: 0.75rem;"></i>
                                        </button>
                                        
                                        <!-- Hidden data for popup -->
                                        <div id="product-data-{{ $product->id }}" style="display: none;">
                                            {
                                                "title": "{{ $product->title }}",
                                                "image": "{{ $product->main_image_url }}",
                                                "type": "{{ $product->type }}",
                                                "family": "{{ $product->olfactory_family }}",
                                                "description": "{{ addslashes($product->description) }}",
                                                "notes_top": "{{ $product->notes_top }}",
                                                "notes_heart": "{{ $product->notes_heart }}",
                                                "notes_base": "{{ $product->notes_base }}",
                                                "price": "₹{{ number_format($product->starting_price, 2) }}",
                                                "url": "{{ route('v1.product', ['id' => $product->id]) }}"
                                            }
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="p-actions-lg">
                <div class="p-qty-selector">
                    <button onclick="changePageQty(-1)"><i class="fa-solid fa-minus"></i></button>
                    <span id="page-qty">1</span>
                    <button onclick="changePageQty(1)"><i class="fa-solid fa-plus"></i></button>
                </div>
                <button class="add-to-cart-lg btn-primary" id="add-to-cart-bundle-btn">
                    <span>Add Combo to Cart</span>
                    <span class="btn-divider"></span>
                    <span id="btn-price-display">₹{{ number_format($bundle->total_price, 0) }}</span>
                </button>
            </div>

            <!-- Tabby EMI Promo (Bottom) -->
            <div style="margin-top: 1rem; margin-bottom: 3rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem; color: var(--text-muted); background: #f8fafc; padding: 1rem 1.5rem; border-radius: 1.25rem; width: 100%; border: 1px solid var(--border-color);">
                <span style="display: flex; align-items: center; gap: 0.5rem; flex-grow: 1;">or 4 interest-free payments of <strong style="color: var(--primary-color); font-size: 1.1rem;">₹{{ number_format($bundle->total_price / 4, 0) }}</strong> with</span>
                <span style="background: #3DF9D1; color: #000; padding: 0.25rem 0.75rem; border-radius: 0.4rem; font-weight: 900; font-size: 0.85rem; letter-spacing: -0.02em; text-transform: lowercase;">tabby</span>
            </div>

            <div style="margin-top: 3rem; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 1.5rem; border-radius: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                <i class="fa-solid fa-shield-check" style="color: #16a34a; font-size: 1.5rem;"></i>
                <p style="font-size: 0.95rem; color: #166534; font-weight: 500;">This exclusive combo is backed by VESPR's Authenticity Guarantee.</p>
            </div>
        </div>
    </div>

    <!-- Related Combos -->
    @if(isset($relatedBundles) && $relatedBundles->count() > 0)
    <div class="department-section" style="margin-top: 5rem;">
        <div class="section-header">
            <h2 class="section-title">Other Exclusive Combos</h2>
        </div>
        <div class="product-grid">
            @foreach($relatedBundles as $relBundle)
                @include('nurah.partials.bundle_card', ['bundle' => $relBundle])
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Product Detail Modal -->
<div id="product-modal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 1.5rem;">
    <div class="modal-card" style="background: #fff; width: 100%; max-width: 900px; border-radius: 2rem; overflow: hidden; position: relative; display: grid; grid-template-columns: 1fr 1fr; animation: modalSlideUp 0.4s ease-out;">
        <button id="modal-close-btn" onclick="closeProductModal()" style="position: absolute; top: 1.5rem; right: 1.5rem; background: #fff; border: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--primary-color);">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <div class="modal-gallery" style="background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 2rem;">
            <img id="modal-img" src="" alt="" style="width: 100%; height: auto; border-radius: 1rem; object-fit: cover; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        </div>
        
        <div class="modal-info" style="padding: 3rem; display: flex; flex-direction: column; max-height: 80vh; overflow-y: auto;">
            <div id="modal-tag" style="background: var(--accent-color); color: var(--primary-color); display: inline-block; padding: 0.2rem 1rem; border-radius: 9999px; font-weight: 800; font-size: 0.7rem; margin-bottom: 1rem; text-transform: uppercase; width: fit-content;">Fragrance Details</div>
            <h2 id="modal-title" style="font-size: 2.25rem; font-weight: 800; color: var(--primary-color); margin-bottom: 0.5rem; line-height: 1.2;"></h2>
            <p id="modal-subtitle" style="color: var(--text-muted); font-size: 1rem; margin-bottom: 2rem; font-weight: 500;"></p>
            
            <div style="margin-bottom: 2.5rem;">
                <h4 style="font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary-color); margin-bottom: 1rem;">Description</h4>
                <p id="modal-desc" style="font-size: 1rem; color: var(--text-muted); line-height: 1.7;"></p>
            </div>
            
            <div style="margin-bottom: 3rem;">
                <h4 style="font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary-color); margin-bottom: 1.25rem;">Olfactory Notes</h4>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div style="width: 40px; font-weight: 800; font-size: 0.7rem; color: var(--accent-color);">TOP</div>
                        <div id="modal-top" style="font-size: 0.95rem; color: var(--primary-color); font-weight: 500;"></div>
                    </div>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div style="width: 40px; font-weight: 800; font-size: 0.7rem; color: var(--accent-color);">HEART</div>
                        <div id="modal-heart" style="font-size: 0.95rem; color: var(--primary-color); font-weight: 500;"></div>
                    </div>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <div style="width: 40px; font-weight: 800; font-size: 0.7rem; color: var(--accent-color);">BASE</div>
                        <div id="modal-base" style="font-size: 0.95rem; color: var(--primary-color); font-weight: 500;"></div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: auto; display: flex; align-items: center; justify-content: space-between; pt-4; border-top: 1px solid #f1f5f9; padding-top: 2rem;">
                <div id="modal-price" style="font-size: 1.5rem; font-weight: 800; color: var(--primary-color);"></div>
                <a id="modal-link" href="" class="btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 9999px; background: var(--primary-color); color: #fff; font-size: 0.9rem; text-decoration: none; font-weight: 700;">View Product Page</a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes modalSlideUp {
        from { opacity: 0; transform: translateY(40px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    
    @media (max-width: 850px) {
        .modal-card { 
            display: flex !important;
            flex-direction: column !important;
            max-height: 90vh !important; 
            overflow-y: auto !important;
            margin: 1rem;
            border-radius: 2rem !important;
            width: calc(100% - 2rem) !important;
        }
        .modal-gallery { 
            padding: 1.5rem !important;
            background: #f8fafc !important;
            flex-shrink: 0;
        }
        .modal-gallery img {
            max-height: 300px;
            width: auto !important;
            margin: 0 auto;
            display: block;
            border-radius: 1.5rem !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        }
        .modal-info { 
            padding: 2rem !important; 
            max-height: none !important;
            overflow: visible !important;
        }
        #modal-title { 
            font-size: 2rem !important; 
            letter-spacing: -0.02em;
        }
        #modal-close-btn {
            top: 1rem !important;
            right: 1rem !important;
            width: 36px !important;
            height: 36px !important;
            background: rgba(255,255,255,0.8) !important;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }
        .modal-info > div { margin-bottom: 2rem !important; }
        
        #modal-price { font-size: 1.25rem !important; }
        #modal-link { padding: 0.6rem 1.25rem !important; font-size: 0.85rem !important; }
    }

    .product-page-container { padding: 1rem 0; }
    .breadcrumb { display: flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; color: var(--text-muted); margin-bottom: 3rem; }
    .breadcrumb a:hover { color: var(--accent-color); }
    .breadcrumb i { font-size: 0.7rem; opacity: 0.5; }

    .product-core-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 5rem; }

    .main-image-display { background: var(--section-bg); border-radius: 2rem; overflow: hidden; aspect-ratio: 1; margin-bottom: 1.5rem; border: 1px solid var(--border-color); }
    .main-image-display img { width: 100%; height: 100%; object-fit: cover; }

    .p-title-lg { font-size: 3rem; font-weight: 800; color: var(--primary-color); line-height: 1.1; margin-bottom: 0.5rem; }
    .p-vendor-lg { color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem; font-weight: 500; }

    .p-price-block-lg { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 3rem; flex-wrap: wrap; }
    .p-price-lg { font-size: 2.25rem; font-weight: 800; color: var(--primary-color); }
    .p-compare-lg { font-size: 1.5rem; text-decoration: line-through; color: var(--text-muted); }

    .p-actions-lg { display: flex; gap: 2rem; margin-bottom: 4rem; }
    .p-qty-selector { display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: 9999px; padding: 0.5rem 1.5rem; gap: 2rem; }
    .p-qty-selector button { border: none; background: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer; }
    .p-qty-selector span { font-weight: 700; font-size: 1.25rem; min-width: 30px; text-align: center; }

    .add-to-cart-lg { flex-grow: 1; display: flex; align-items: center; justify-content: center; gap: 1rem; padding: 0 2rem; border: none; }
    .btn-divider { width: 1px; height: 24px; background: rgba(0,0,0,0.1); }

    @media (max-width: 1200px) {
        .product-core-grid { grid-template-columns: 1fr; gap: 3rem; }
        .product-details-panel { max-width: 800px; }
    }
</style>
@endsection

@section('scripts')
<script>
    let qty = 1;

    function toggleProductDetails(id) {
        const details = document.getElementById('details-' + id);
        const chevron = document.getElementById('chevron-' + id);
        const text = document.getElementById('text-' + id);
        
        if (details.style.display === 'none') {
            $(details).slideDown(300);
            chevron.style.transform = 'rotate(180deg)';
            text.innerText = 'Hide Details';
        } else {
            $(details).slideUp(300);
            chevron.style.transform = 'rotate(0deg)';
            text.innerText = 'View Details';
        }
    }

    function showProductPopup(id) {
        const data = JSON.parse(document.getElementById('product-data-' + id).innerText);
        
        document.getElementById('modal-img').src = data.image;
        document.getElementById('modal-title').innerText = data.title;
        document.getElementById('modal-subtitle').innerText = data.type + ' • ' + data.family;
        document.getElementById('modal-desc').innerText = data.description;
        document.getElementById('modal-top').innerText = data.notes_top;
        document.getElementById('modal-heart').innerText = data.notes_heart;
        document.getElementById('modal-base').innerText = data.notes_base;
        document.getElementById('modal-price').innerText = data.price;
        document.getElementById('modal-link').href = data.url;
        
        const modal = document.getElementById('product-modal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeProductModal() {
        const modal = document.getElementById('product-modal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close on overlay click
    document.getElementById('product-modal').addEventListener('click', function(e) {
        if (e.target === this) closeProductModal();
    });

    function changePageQty(delta) {
        qty = Math.max(1, qty + delta);
        document.getElementById('page-qty').innerText = qty;
    }

    function addToCart() {
        const btn = document.getElementById('add-to-cart-bundle-btn');
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
        btn.disabled = true;

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: "{{ $bundle->id }}",
                quantity: qty,
                type: 'bundle'
            },
            success: function(response) {
                if(response.success) {
                    $('#cart-count').text(response.cartCount);
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Added!';
                    btn.style.background = '#10B981';
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.style.background = '';
                        btn.disabled = false;
                    }, 2000);
                } else {
                    alert('Error: ' + response.message);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }

    document.getElementById('add-to-cart-bundle-btn').addEventListener('click', addToCart);
</script>
@endsection
