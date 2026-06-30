@extends('layouts.storefront')

@section('title', $product->title . ' | VESPR Perfumes')
@section('meta_description', Str::limit(strip_tags($product->description), 160))
@section('meta_keywords', $product->title . ', ' . $product->olfactory_family . ', ' . $product->type . ', VESPR perfumes')
@section('og_image', $product->main_image_url ?? asset('Images/products/p' . $product->id . '.png'))

@section('styles')
<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@@type": "Product",
  "name": "{{ $product->title }}",
  "image": [
    "{{ $product->main_image_url ?? asset('Images/products/p' . $product->id . '.png') }}"
  ],
  "description": "{{ strip_tags($product->description) }}",
  "brand": {
    "@@type": "Brand",
    "name": "VESPR"
  },
  "offers": {
    "@@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "INR",
    "price": "{{ $product->starting_price }}",
    "availability": "https://schema.org/InStock"
  }
}
</script>
@endsection

@section('content')
<div class="product-page-container">
    <div class="breadcrumb">
        <a href="{{ route('v1.home') }}">Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('v1.all-products') }}">Shop</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>{{ $product->title }}</span>
    </div>

    <div class="product-core-grid">
        <!-- Gallery -->
        <div class="product-gallery">
            <div class="main-image-display">
                @if(isset($packBundles) && $packBundles->count() > 0)
                    @php 
                        $bestPack = $packBundles->sortBy('total_price')->first(); 
                        $bestQty = $bestPack->products->first()->pivot->quantity;
                    @endphp
                    <div class="p-gallery-badge">
                        <i class="fa-solid fa-tags"></i> Buy {{ $bestQty }} at ₹{{ number_format($bestPack->total_price, 0) }}
                    </div>
                @endif
                @php 
                    $mainImg = $product->main_image_url ?? asset('Images/products/p' . $product->id . '.png');
                @endphp
                <img src="{{ $mainImg }}" id="p-main-img" alt="{{ $product->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
            </div>
            <div class="thumb-grid">
                @foreach($product->images->take(3) as $img)
                    @php 
                        $thumbPath = $img->path;
                        if (Str::startsWith($thumbPath, 'http')) {
                            // External
                        } elseif (Str::startsWith($thumbPath, 'Images/')) {
                            $thumbPath = asset($thumbPath);
                        } else {
                            $thumbPath = \Illuminate\Support\Facades\Storage::url($thumbPath);
                        }
                    @endphp
                    <div class="thumb-item {{ $loop->first ? 'active' : '' }}" onclick="updateImg('{{ $thumbPath }}', this)">
                        <img src="{{ $thumbPath }}" alt="Gallery">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Info -->
        <div class="product-details-panel">
            <p class="p-vendor-label">VESPR FRAGRANCE HOUSE</p>
            <h1 class="p-title-serif">{{ $product->title }}</h1>
            
            <div class="p-price-row">
                @if($product->compare_at_price > $product->starting_price)
                    <span class="p-compare-at">₹{{ number_format($product->compare_at_price, 0) }}</span>
                @endif
                <span class="p-current-price" id="p-price-display">₹{{ number_format($product->starting_price, 0) }}</span>
                @if($product->compare_at_price > $product->starting_price)
                    @php $discount = round((($product->compare_at_price - $product->starting_price) / $product->compare_at_price) * 100); @endphp
                    <span class="p-discount-badge">{{ $discount }}% Off</span>
                @endif
                
                <div class="p-quick-add-badge" onclick="addToCart()" title="Quick Add to Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>

            <p class="p-emi-info">or 4 interest-free payments of ₹<span class="tabby-emi-display">{{ number_format($product->starting_price / 4, 0) }}</span> with <strong>tabby</strong>. <i class="fa-solid fa-circle-info"></i></p>

            <div class="delivery-note" style="margin-top: -1rem; margin-bottom: 2rem; color: var(--accent-color); font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 0.6rem;">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Get it by <strong>{{ now()->addDays(2)->format('l, M jS') }}</strong></span>
            </div>

            <!-- Bundle Promo Box -->
            @if(isset($bundle))
            <div class="p-promo-box">
                <div class="promo-content">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Save more with the <strong>{{ $bundle->title }}</strong> combo</span>
                </div>
                <a href="{{ route('v1.combo', ['id' => $bundle->id]) }}" class="promo-link">
                    View Combo <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
            @endif

            <div class="p-specs-pill">
                <div class="spec-part"><strong>Family:</strong> {{ $product->olfactory_family }}</div>
                <div class="spec-part"><strong>Intensity:</strong> {{ $product->intensity ?? 'Long-lasting' }}</div>
                <div class="spec-part"><strong>Type:</strong> {{ $product->type }}</div>
            </div>

            <!-- Main Accords Pills -->
            <div class="p-accords-wrapper">
                <h3 class="p-section-label">Main Accords</h3>
                <div class="accords-pills">
                    @php
                        $accords = [$product->olfactory_family, 'Warm Spicy', 'Amber', 'Aromatic'];
                    @endphp
                    @foreach($accords as $accord)
                        <span class="accord-pill">{{ $accord }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Size Selection -->
            <div class="p-size-wrapper">
                <h3 class="p-section-label">Select Size</h3>
                <div class="size-rect-grid">
                    @foreach($product->variants as $variant)
                        <div class="size-rect {{ $loop->first ? 'active' : '' }}" onclick="selectVariant(this, {{ $variant->price }}, '{{ $variant->size }}', {{ $variant->id }})">
                            <span class="s-size">{{ $variant->size }}</span>
                            <span class="s-price">₹{{ number_format($variant->price, 0) }}</span>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="selected-variant-id" name="variant_id" value="{{ $product->variants->first()->id ?? '' }}">
            </div>

            <!-- Pack Of / Volume Deals -->
            @if(isset($packBundles) && $packBundles->count() > 0)
            <div class="p-volume-deals">
                <h3 class="p-section-label">Special Volume Deals</h3>
                <div class="deals-list">
                    @foreach($packBundles as $pb)
                        @php 
                            $pb_prod = $pb->products->first();
                            $pb_variant = $pb_prod ? $pb_prod->variants->firstWhere('id', $pb_prod->pivot->product_variant_id) : null;
                        @endphp
                        @if($pb_prod)
                        <div class="deal-card">
                            <div class="deal-info" style="flex-direction: row; align-items: center; gap: 1rem; flex-grow: 1;">
                                <span class="deal-title" style="white-space: nowrap;">Buy {{ $pb_prod->pivot->quantity }} @if($pb_variant) ({{ $pb_variant->size }}) @endif</span>
                                <div style="width: 1px; height: 16px; background: #eee;"></div>
                                <span class="deal-save" style="white-space: nowrap;">Save ₹{{ number_format(($pb_variant ? $pb_variant->price : $pb_prod->starting_price) * $pb_prod->pivot->quantity - $pb->total_price, 0) }} instantly</span>
                            </div>
                            <button onclick="addPackToCart({{ $pb->id }})" class="btn-deal-add">
                                Add ₹{{ number_format($pb->total_price, 0) }}
                            </button>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Pool Deal Box -->
            @if(isset($poolBundles) && $poolBundles->count() > 0)
                @php $pool = $poolBundles->first(); @endphp
                <div class="p-pool-box">
                    <div class="pool-header">
                        <span class="pool-label">POOL DEAL • MIX & MATCH OFFER</span>
                        <h4 class="pool-offer-title">Buy any {{ $pool->min_quantity }} items from this collection & get ₹{{ number_format($pool->discount_value, 0) }} off your total.</h4>
                    </div>
                    <div class="pool-products-grid">
                        @foreach($pool->products->take(4) as $poolProd)
                            @php 
                                $p_variant = $poolProd->variants->first(); 
                                $p_data = [
                                    'id' => $poolProd->id,
                                    'title' => $poolProd->title,
                                    'image' => $poolProd->main_image_url,
                                    'family' => $poolProd->olfactory_family,
                                    'type' => $poolProd->type,
                                    'description' => $poolProd->description,
                                    'notes_top' => $poolProd->notes_top,
                                    'notes_heart' => $poolProd->notes_heart,
                                    'notes_base' => $poolProd->notes_base,
                                    'price' => '₹' . number_format($poolProd->starting_price, 0),
                                    'url' => route('v1.product', ['id' => $poolProd->id])
                                ];
                            @endphp
                            <script type="application/json" id="product-data-{{ $poolProd->id }}">
                                {!! json_encode($p_data) !!}
                            </script>
                            <div class="pool-prod-item {{ $poolProd->id == $product->id ? 'current' : '' }}">
                                <div class="pool-prod-img" onclick="showProductPopup({{ $poolProd->id }})">
                                    <img src="{{ $poolProd->main_image_url }}" alt="{{ $poolProd->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                                    <button class="pool-quick-add" onclick="quickAddPoolProduct(event, {{ $poolProd->id }}, {{ $p_variant->id ?? 'null' }}, '{{ $p_variant->size ?? '' }}')" title="Quick Add">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </div>
                                <a href="{{ route('v1.product', ['id' => $poolProd->id]) }}" class="pool-prod-name">{{ $poolProd->title }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="p-actions-row">
                <div class="qty-control">
                    <button onclick="changePageQty(-1)">-</button>
                    <span class="page-qty">1</span>
                    <button onclick="changePageQty(1)">+</button>
                </div>
                <button class="btn-add-to-cart add-to-cart-btn" id="add-to-cart-page-btn">
                    ADD TO CART <span class="btn-price-display">₹{{ number_format($product->starting_price, 0) }}</span>
                </button>
            </div>

            <!-- Concentration Guide -->
            <div class="p-concentration-bar">
                <div class="conc-step {{ str_contains(strtolower($product->type), 'toilette') ? 'active' : '' }}">
                    <span class="c-name">EDT</span>
                    <span class="c-desc">5-15% Oil</span>
                </div>
                <div class="conc-step {{ str_contains(strtolower($product->type), 'parfum') && !str_contains(strtolower($product->type), 'extrait') ? 'active' : '' }}">
                    <span class="c-name">EDP</span>
                    <span class="c-desc">15-20% Oil</span>
                </div>
                <div class="conc-step {{ str_contains(strtolower($product->type), 'extrait') || str_contains(strtolower($product->type), 'oil') ? 'active' : '' }}">
                    <span class="c-name">Extrait</span>
                    <span class="c-desc">20-40% Oil</span>
                </div>
            </div>

            <div class="p-tabs-minimal">
                <button class="tab-link active" onclick="switchTab('desc')">DESCRIPTION</button>
                <button class="tab-link" onclick="switchTab('notes')">OLFACTORY NOTES</button>
                <button class="tab-link" onclick="switchTab('shipping')">SHIPPING</button>
            </div>
            
            <div class="tab-content-minimal" id="tab-desc">
                <p>{{ $product->description }}</p>
            </div>
            <div class="tab-content-minimal d-none" id="tab-notes">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                    <div>
                        <h4 style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 1px;">Top Notes</h4>
                        <p style="font-weight: 600; color: #000;">{{ $product->notes_top }}</p>
                    </div>
                    <div>
                        <h4 style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 1px;">Heart Notes</h4>
                        <p style="font-weight: 600; color: #000;">{{ $product->notes_heart }}</p>
                    </div>
                    <div>
                        <h4 style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 1px;">Base Notes</h4>
                        <p style="font-weight: 600; color: #000;">{{ $product->notes_base }}</p>
                    </div>
                </div>
            </div>
            <div class="tab-content-minimal d-none" id="tab-shipping">
                <p>Enjoy free express shipping on this order. Estimated delivery by <strong>{{ now()->addDays(2)->format('l, M jS') }}</strong> (within 2 business days).</p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @php $related = \App\Models\Product::where('collection_id', $product->collection_id)->where('id', '!=', $product->id)->take(4)->get(); @endphp
    @if($related->count() > 0)
    <div class="department-section" style="margin-top: 5rem;">
        <div class="section-header">
            <h2 class="section-title">You Might Also Like</h2>
        </div>
        <div class="product-grid">
            @foreach($related as $rel)
                @include('nurah.partials.product_card', ['product' => $rel])
            @endforeach
        </div>
    </div>
    @endif

    <!-- Product Modal -->
    <div id="product-modal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 1.5rem;">
        <div class="modal-card" style="background: #fff; width: 100%; max-width: 900px; border-radius: 2rem; overflow: hidden; position: relative; display: grid; grid-template-columns: 1fr 1fr;">
            <button id="modal-close-btn" onclick="closeProductModal()" style="position: absolute; top: 1.5rem; right: 1.5rem; background: #fff; border: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #000;">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="modal-gallery" style="background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 2rem;">
                <img id="modal-img" src="" alt="" style="width: 100%; height: auto; border-radius: 1rem; object-fit: cover; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            </div>
            <div class="modal-info" style="padding: 3rem; display: flex; flex-direction: column; max-height: 80vh; overflow-y: auto;">
                <div id="modal-tag" style="background: var(--accent-color); color: var(--primary-color); display: inline-block; padding: 0.2rem 1rem; border-radius: 9999px; font-weight: 800; font-size: 0.7rem; margin-bottom: 1rem; text-transform: uppercase; width: fit-content;">Fragrance Details</div>
                <h2 id="modal-title" style="font-size: 2.25rem; font-weight: 800; color: #000; margin-bottom: 0.5rem; line-height: 1.2; font-family: 'Playfair Display', serif;"></h2>
                <p id="modal-subtitle" style="color: #666; font-size: 1rem; margin-bottom: 2rem; font-weight: 500;"></p>
                
                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: #000; margin-bottom: 0.75rem; font-weight: 800;">About the Scent</h4>
                    <p id="modal-desc" style="font-size: 1rem; color: #444; line-height: 1.7;"></p>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h4 style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: #000; margin-bottom: 1rem; font-weight: 800;">Olfactory Profile</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 80px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #999;">Top</div>
                            <div id="modal-top" style="font-size: 0.95rem; color: #000; font-weight: 500;"></div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 80px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #999;">Heart</div>
                            <div id="modal-heart" style="font-size: 0.95rem; color: #000; font-weight: 500;"></div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 80px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #999;">Base</div>
                            <div id="modal-base" style="font-size: 0.95rem; color: #000; font-weight: 500;"></div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: auto; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #eee; padding-top: 2rem;">
                    <div id="modal-price" style="font-size: 1.5rem; font-weight: 800; color: #000;"></div>
                    <a id="modal-link" href="" class="btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 9999px; background: #000; color: #fff; font-size: 0.9rem; text-decoration: none; font-weight: 700;">View Product Page</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Mobile Sticky Footer -->
    <div class="mobile-sticky-footer">
        <div class="p-actions-row">
            <div class="qty-control">
                <button onclick="changePageQty(-1)">-</button>
                <span class="page-qty">1</span>
                <button onclick="changePageQty(1)">+</button>
            </div>
            <button class="btn-add-to-cart add-to-cart-btn">
                ADD TO CART <span class="btn-price-display">₹{{ number_format($product->starting_price, 0) }}</span>
            </button>
        </div>
    </div>
</div>

<style>
    .product-page-container { padding: 1rem 0; color: #1a1a1a; }
    .breadcrumb { display: flex; align-items: center; gap: 0.75rem; font-size: 0.85rem; color: #666; margin-bottom: 2rem; }
    .breadcrumb a:hover { color: var(--accent-color); }
    
    .product-core-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 4rem; align-items: start; }

    /* Gallery */
    .main-image-display { background: #fdfdfd; border-radius: 0.5rem; overflow: hidden; aspect-ratio: 1; border: 1px solid #eee; margin-bottom: 1rem; }
    .main-image-display img { width: 100%; height: 100%; object-fit: cover; }
    .thumb-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .thumb-item { border: 1px solid #eee; border-radius: 0.25rem; overflow: hidden; aspect-ratio: 1; cursor: pointer; transition: 0.3s; }
    .thumb-item img { width: 100%; height: 100%; object-fit: cover; }
    .thumb-item.active { border: 2px solid var(--accent-color); }

    /* Floating Gallery Badge */
    .p-gallery-badge { position: absolute; top: 1.25rem; right: 1.25rem; background: var(--accent-color); color: var(--primary-color); padding: 0.5rem 1rem; border-radius: 999px; font-weight: 800; font-size: 0.8rem; box-shadow: 0 10px 20px rgba(212, 175, 55, 0.4); z-index: 10; display: flex; align-items: center; gap: 0.5rem; border: 2px solid #fff; animation: float 3s ease-in-out infinite; }

    /* Info */
    .p-vendor-label { font-size: 0.75rem; font-weight: 700; color: var(--accent-color); letter-spacing: 0.15em; margin-bottom: 0.5rem; }
    .p-title-serif { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 600; font-style: italic; color: #000; margin-bottom: 1rem; line-height: 1.1; }
    
    .p-price-row { display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1rem; }
    .p-compare-at { font-size: 1.5rem; text-decoration: line-through; color: #999; }
    .p-current-price { font-size: 2.25rem; font-weight: 700; color: #000; }
    .p-discount-badge { background: #B5A264; color: #fff; padding: 0.35rem 1rem; border-radius: 999px; font-size: 0.85rem; font-weight: 700; }
    
    .p-quick-add-badge { width: 35px; height: 35px; background: var(--accent-color); color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; cursor: pointer; transition: 0.3s; margin-left: auto; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3); }
    .p-quick-add-badge:hover { transform: scale(1.1) rotate(-5deg); background: var(--primary-color); color: var(--accent-color); }
    
    .p-emi-info { font-size: 0.85rem; color: #444; margin-bottom: 1.5rem; }
    .p-emi-info strong { color: #000; }
    .p-emi-info i { font-size: 0.8rem; opacity: 0.5; margin-left: 0.25rem; }

    /* Promo Box (Combo) */
    .p-promo-box { background: #FFFEF9; border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 0.75rem; padding: 1rem 1.25rem; margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
    .promo-content { display: flex; align-items: center; gap: 0.75rem; font-size: 0.85rem; font-weight: 500; color: #1a1a1a; }
    .promo-content i { color: var(--accent-color); font-size: 0.9rem; }
    .promo-link { font-size: 0.75rem; font-weight: 800; color: var(--accent-color); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.4rem; }

    .p-specs-pill { display: flex; border: 1px solid #e5e5e5; border-radius: 999px; padding: 0.75rem 2rem; margin-bottom: 1.25rem; justify-content: space-between; font-size: 0.85rem; background: #fff; }
    .spec-part { color: #666; }
    .spec-part strong { color: #1a1a1a; font-weight: 600; }
    .spec-part:not(:last-child) { padding-right: 1.5rem; border-right: 1px solid #eee; }

    .p-section-label { font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 1rem; }
    .p-accords-wrapper { margin-bottom: 1.25rem; }
    .accords-pills { display: flex; flex-wrap: wrap; gap: 0.75rem; }
    .accord-pill { border: 1px solid #e5e5e5; border-radius: 999px; padding: 0.5rem 1.25rem; font-size: 0.85rem; color: #444; font-weight: 500; }

    .p-size-wrapper { margin-bottom: 1.25rem; }
    .size-rect-grid { display: flex; gap: 1rem; }
    .size-rect { flex: 1; border: 1.5px solid #e5e5e5; border-radius: 0.5rem; padding: 0.75rem 1.25rem; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 1rem; }
    .size-rect.active { border-color: var(--accent-color); background: #fcfcfc; }
    .s-size { font-weight: 700; font-size: 0.95rem; color: #000; }
    .s-price { font-size: 0.95rem; color: #000; font-weight: 500; }

    /* Volume Deals (Pack Of) */
    .p-volume-deals { margin-bottom: 1.25rem; }
    .deals-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .deal-card { display: flex; align-items: center; justify-content: space-between; background: #fff; border: 1.5px dashed #e5e5e5; padding: 1rem 1.25rem; border-radius: 0.75rem; transition: 0.3s; }
    .deal-info { display: flex; flex-direction: column; gap: 0.15rem; }
    .deal-title { font-weight: 700; font-size: 0.95rem; color: #000; }
    .deal-save { font-size: 0.75rem; font-weight: 700; color: #10B981; }
    .btn-deal-add { background: #111; color: #fff; border: none; padding: 0.6rem 1.25rem; border-radius: 0.5rem; font-weight: 700; font-size: 0.8rem; cursor: pointer; transition: 0.3s; }
    .btn-deal-add:hover { background: #000; transform: scale(1.02); }

    /* Pool Box */
    .p-pool-box { border: 2px solid #D4AF37; background: #FFFEF9; border-radius: 1rem; padding: 1.25rem; margin-bottom: 1.25rem; position: relative; box-shadow: 0 10px 30px rgba(212, 175, 55, 0.1); }
    .pool-header { text-align: center; margin-bottom: 1.5rem; }
    .pool-label { font-size: 0.7rem; font-weight: 800; color: #D4AF37; letter-spacing: 0.1em; }
    .pool-offer-title { font-size: 1.1rem; font-weight: 700; color: #000; margin-top: 0.5rem; }
    .pool-products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }
    .pool-prod-item { text-align: center; }
    .pool-prod-img { aspect-ratio: 1; background: #fff; border-radius: 0.5rem; border: 1px solid #eee; overflow: hidden; margin-bottom: 0.5rem; position: relative; }
    .pool-prod-item.current .pool-prod-img { border-color: #D4AF37; border-width: 2px; }
    .pool-prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .pool-prod-name { font-size: 0.7rem; font-weight: 600; color: #666; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    
    .pool-quick-add { position: absolute; bottom: 0.5rem; right: 0.5rem; width: 28px; height: 28px; border-radius: 50%; background: #111; color: #fff; border: 1.5px solid #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; cursor: pointer; opacity: 1; z-index: 5; transition: 0.3s; }
    .pool-prod-img:hover .pool-quick-add { transform: scale(1.1); }

    .p-actions-row { display: flex; gap: 1rem; margin-bottom: 1.25rem; }
    .qty-control { display: flex; align-items: center; border: 1.5px solid #e5e5e5; border-radius: 0.5rem; overflow: hidden; background: #fff; }
    .qty-control button { border: none; background: none; padding: 0.75rem 1rem; font-size: 1.25rem; cursor: pointer; color: #666; }
    .qty-control span { padding: 0 1rem; font-weight: 700; min-width: 40px; text-align: center; }
    .btn-add-to-cart { flex: 1; background: #111; color: #fff; border: none; border-radius: 0.5rem; font-weight: 700; font-size: 1rem; letter-spacing: 0.05em; padding: 1rem; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 1rem; }
    .btn-add-to-cart:hover { background: #000; transform: translateY(-2px); }

    /* Concentration Bar */
    .p-concentration-bar { display: flex; border: 1.5px solid #e5e5e5; border-radius: 0.5rem; overflow: hidden; margin-bottom: 1.25rem; }
    .conc-step { flex: 1; padding: 1rem; text-align: center; display: flex; flex-direction: column; gap: 0.25rem; position: relative; }
    .conc-step:not(:last-child) { border-right: 1px solid #eee; }
    .conc-step.active { background: #FFFEF9; border: 2px solid #D4AF37; z-index: 2; margin: -1.5px; }
    .c-name { font-weight: 700; font-size: 0.95rem; color: #000; }
    .c-desc { font-size: 0.75rem; color: #999; }
    .conc-step.active .c-desc { color: #B5A264; }

    /* Tabs minimal */
    .p-tabs-minimal { display: flex; gap: 3rem; border-bottom: 1.5px solid #eee; margin-bottom: 1.5rem; }
    .tab-link { background: none; border: none; padding: 1rem 0; font-size: 0.85rem; font-weight: 700; color: #999; cursor: pointer; position: relative; letter-spacing: 0.1em; }
    .tab-link.active { color: #000; }
    .tab-link.active::after { content: ''; position: absolute; bottom: -1.5px; left: 0; right: 0; height: 2px; background: #000; }
    .tab-content-minimal { font-size: 0.95rem; color: #666; line-height: 1.6; }
    .d-none { display: none !important; }

    @media (max-width: 1200px) {
        .product-core-grid { grid-template-columns: 1fr; gap: 2rem; }
    }

    @media (max-width: 768px) {
        .p-title-serif { font-size: 2.2rem; }
        .p-tabs-minimal { gap: 1.5rem; }
        .pool-products-grid { grid-template-columns: repeat(2, 1fr); }
        .modal-card { grid-template-columns: 1fr !important; max-height: 90vh; overflow-y: auto; }
        .modal-info { padding: 1.5rem !important; }
        .p-price-row { flex-wrap: wrap; }
    }
    .mobile-sticky-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        padding: 0.75rem 1rem;
        box-shadow: 0 -10px 30px rgba(0,0,0,0.08);
        z-index: 1000;
        display: none;
    }
    .mobile-sticky-footer .p-actions-row { margin-bottom: 0; gap: 0.75rem; }
    .mobile-sticky-footer .qty-control button { padding: 0.5rem 0.75rem; }
    .mobile-sticky-footer .btn-add-to-cart { padding: 0.75rem; font-size: 0.9rem; }

    @media (max-width: 768px) {
        .mobile-sticky-footer { display: block; }
        .product-page-container { padding-bottom: 70px; } /* Space for sticky footer */
    }
</style>

@endsection

@section('scripts')
<script>
    let qty = 1;

    function updateImg(src, el) {
        document.getElementById('p-main-img').src = src;
        document.querySelectorAll('.t-item').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    function selectVariant(element, price, size, id) {
        // Update active class
        document.querySelectorAll('.size-rect').forEach(card => card.classList.remove('active'));
        element.classList.add('active');

        // Update Price displays
        const formattedPrice = new Intl.NumberFormat('en-IN', {
            maximumFractionDigits: 0
        }).format(price);
        
        document.getElementById('p-price-display').innerText = '₹' + formattedPrice;
        document.getElementById('btn-price-display').innerText = '₹' + formattedPrice;
        
        // Update Tabby EMI
        const emiPrice = new Intl.NumberFormat('en-IN', {
            maximumFractionDigits: 0
        }).format(price / 4);
        document.querySelectorAll('.tabby-emi-display').forEach(el => {
            el.innerText = emiPrice;
        });
        
        // Update hidden input
        document.getElementById('selected-variant-id').value = id;
    }

    function changePageQty(delta) {
        qty = Math.max(1, qty + delta);
        document.querySelectorAll('.page-qty').forEach(el => {
            el.innerText = qty;
        });
    }

    function switchTab(tab) {
        document.querySelectorAll('.tab-link').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content-minimal').forEach(c => c.classList.add('d-none'));
        
        const targetBtn = Array.from(document.querySelectorAll('.tab-link')).find(b => b.innerText.toLowerCase().includes(tab));
        if(targetBtn) targetBtn.classList.add('active');
        document.getElementById('tab-' + tab).classList.remove('d-none');
    }

    function addToCart(event) {
        const btn = event.currentTarget;
        const variantId = document.getElementById('selected-variant-id').value;
        const activeCard = document.querySelector('.size-rect.active');
        const size = activeCard ? activeCard.querySelector('.s-size').innerText : '';
        const originalHtml = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
        btn.disabled = true;

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: "{{ $product->id }}",
                quantity: qty,
                size: size,
                variant_id: variantId
            },
            success: function(response) {
                if(response.success) {
                    $('#cart-count').text(response.cartCount);
                    document.querySelectorAll('.add-to-cart-btn').forEach(b => {
                        b.innerHTML = 'ADDED TO CART';
                        b.style.background = '#10B981';
                    });
                    
                    setTimeout(() => {
                        document.querySelectorAll('.add-to-cart-btn').forEach(b => {
                            b.innerHTML = originalHtml; // Note: originalHtml might be different for each btn, but usually they are same text
                            b.style.background = '';
                            b.disabled = false;
                        });
                    }, 2000);
                } else {
                    alert('Error: ' + response.message);
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        });
    }

    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', addToCart);
    });

    function addPackToCart(bundleId) {
        const btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
        btn.disabled = true;

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: bundleId,
                quantity: 1,
                type: 'bundle'
            },
            success: function(response) {
                if(response.success) {
                    $('#cart-count').text(response.cartCount);
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Added!';
                    btn.style.background = '#10B981';
                    
                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.style.background = '';
                        btn.disabled = false;
                    }, 2000);
                }
            }
        });
    }

    function quickAddPoolProduct(event, productId, variantId, size) {
        event.preventDefault();
        event.stopPropagation();
        
        const btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="font-size: 0.6rem;"></i>';
        btn.disabled = true;

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
                quantity: 1,
                size: size,
                variant_id: variantId
            },
            success: function(response) {
                if(response.success) {
                    $('#cart-count').text(response.cartCount);
                    btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                    btn.style.background = '#10B981';
                    
                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.style.background = '';
                        btn.disabled = false;
                    }, 2000);
                }
            }
        });
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
    $(document).on('click', '#product-modal', function(e) {
        if (e.target === this) closeProductModal();
    });
</script>
@endsection
