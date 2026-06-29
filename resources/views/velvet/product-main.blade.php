@extends('layouts.velvet')

@section('title', $product->title . ' | Task19 Perfumes')

@section('content')
<div class="product-page-container">
    <div class="breadcrumb">
        <a href="{{ route('velvet.home') }}">Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('velvet.all-products') }}">Shop</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>{{ $product->title }}</span>
    </div>

    <div class="product-core-grid">
        <!-- Gallery -->
        <div class="product-gallery">
            <div class="main-image-display" style="position: relative;">
                @if(isset($packBundles) && $packBundles->count() > 0)
                    @php 
                        $bestPack = $packBundles->sortBy('total_price')->first(); 
                        $bestQty = $bestPack->products->first()->pivot->quantity;
                    @endphp
                    <div style="position: absolute; top: 1.5rem; right: 1.5rem; background: var(--accent-color); color: var(--text-primary); padding: 0.6rem 1.2rem; border-radius: 999px; font-weight: 800; font-size: 0.85rem; box-shadow: 0 10px 20px rgba(212, 175, 55, 0.4); z-index: 10; display: flex; align-items: center; gap: 0.5rem; border: 2px solid #fff; animation: float 3s ease-in-out infinite;">
                        <i class="fa-solid fa-tags"></i> Buy {{ $bestQty }} at ₹{{ number_format($bestPack->total_price, 0) }}
                    </div>
                @endif

                @php 
                    $mainImg = $product->main_image_url ?? asset('Images/products/p' . $product->id . '.png');
                @endphp
                <img src="{{ $mainImg }}" id="p-main-img" alt="{{ $product->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
            </div>
            <div class="thumb-strip">
                @foreach($product->images as $img)
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
                    <img src="{{ $thumbPath }}" class="t-item {{ $loop->first ? 'active' : '' }}" onclick="updateImg(this.src, this)" alt="Gallery">
                @endforeach
            </div>
        </div>

        <!-- Info -->
        <div class="product-details-panel">
            <h1 class="p-title-lg">{{ $product->title }}</h1>
            <p class="p-vendor-lg">By Task19 Fragrance House</p>
            
            <div class="p-price-block-lg">
                <span class="p-price-lg" id="p-price-display">₹{{ number_format($product->starting_price, 2) }}</span>
                @if($product->compare_at_price > $product->starting_price)
                    <span class="p-compare-lg">₹{{ number_format($product->compare_at_price, 2) }}</span>
                @endif
                <div class="p-quick-add-badge" onclick="addToCart()">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>

            <!-- Tabby EMI Promo (Top) -->
            <div class="v-tabby-promo v-tabby-top">
                <span style="line-height: 1.4;">or 4 interest-free payments of <strong style="color: var(--text-primary);">₹<span class="tabby-emi-display">{{ number_format($product->starting_price / 4, 0) }}</span></strong> with</span>
                <span style="background: #3DF9D1; color: #000; padding: 0.15rem 0.6rem; border-radius: 0.3rem; font-weight: 900; font-size: 0.75rem; letter-spacing: -0.01em; text-transform: lowercase; display: inline-block; vertical-align: middle;">tabby</span>
            </div>



            <!-- Delivery Date Info -->
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; background: var(--secondary-bg); padding: 0.85rem 1.25rem; border-radius: 1rem; border: 1px solid var(--border-color); width: 100%;">
                <i class="fa-solid fa-truck-fast" style="color: var(--accent-color); font-size: 1.1rem;"></i>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                    <span style="font-size: 0.85rem; color: var(--text-secondary); font-weight: 600;">Arriving by</span>
                    <span style="font-weight: 700; color: var(--text-primary); font-size: 0.9rem;">{{ now()->addDays(2)->format('l, M jS') }}</span>
                </div>
            </div>

            <!-- Bundle Promo Box -->
            @if(isset($bundle))
            <div style="background: #FEFAF2; padding: 0.85rem 1.25rem; border-radius: 1rem; margin-bottom: 2.5rem; color: var(--text-primary); display: flex; align-items: center; justify-content: space-between; border: 1px solid rgba(212, 175, 55, 0.3); gap: 1rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-layer-group" style="color: var(--accent-color); font-size: 0.9rem;"></i>
                    <span style="font-size: 0.9rem; font-weight: 500;">Save more with the <strong>{{ $bundle->title }}</strong> combo</span>
                </div>
                <a href="{{ route('velvet.combo', ['slug' => $bundle->slug]) }}" style="color: var(--accent-color); font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.4rem; white-space: nowrap;">
                    View Combo <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
            @endif

            <div class="p-spec-grid">
                <div class="p-spec-item">
                    <span class="s-label">Family</span>
                    <span class="s-value">{{ $product->olfactory_family }}</span>
                </div>
                <div class="p-spec-item">
                    <span class="s-label">Intensity</span>
                    <span class="s-value">{{ $product->intensity ?? 'Medium' }}</span>
                </div>
                <div class="p-spec-item">
                    <span class="s-label">Type</span>
                    <span class="s-value">{{ $product->type }}</span>
                </div>
            </div>

            <!-- Main Accords Section -->
            <div class="p-accords-section">
                <h3 class="p-section-title">Main Accords</h3>
                <div class="accords-list">
                    @php
                        $accords = [
                            ['name' => $product->olfactory_family, 'width' => '95%', 'color' => '#8B4513'],
                            ['name' => 'Warm Spicy', 'width' => '75%', 'color' => '#B22222'],
                            ['name' => 'Amber', 'width' => '60%', 'color' => '#FF8C00'],
                            ['name' => 'Aromatic', 'width' => '45%', 'color' => '#556B2F'],
                            ['name' => 'Citrus', 'width' => '30%', 'color' => '#FFD700'],
                        ];
                    @endphp
                    @foreach($accords as $accord)
                        <div class="accord-item">
                            <div class="accord-bar" style="width: {{ $accord['width'] }}; background-color: {{ $accord['color'] }};">
                                {{ $accord['name'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Size Selection Grid -->
            <div class="p-variants-section">
                <h3 class="p-section-title">Select Size</h3>
                <div class="variant-grid">
                    @foreach($product->variants as $variant)
                        <div class="variant-card {{ $loop->first ? 'active' : '' }}" onclick="selectVariant(this, {{ $variant->price }}, '{{ $variant->size }}', {{ $variant->id }})">
                            <i class="fa-solid fa-bottle-droplet bottle-icon"></i>
                            <span class="v-size">{{ $variant->size }}</span>
                            <span class="v-price">₹{{ number_format($variant->price, 0) }}</span>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="selected-variant-id" name="variant_id" value="{{ $product->variants->first()->id ?? '' }}">
            </div>

            <!-- Pack Of / Volume Deals -->
            @if(isset($packBundles) && $packBundles->count() > 0)
            <div style="margin-bottom: 2.5rem;">
                <h3 class="p-section-title">Special Volume Deals</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($packBundles as $pb)
                        @php 
                            $pb_prod = $pb->products->first();
                            $pb_variant = $pb_prod ? $pb_prod->variants->firstWhere('id', $pb_prod->pivot->product_variant_id) : null;
                        @endphp
                        @if($pb_prod)
                        <div class="pack-offer-item" style="display: flex; align-items: center; justify-content: space-between; background: #fff; border: 2px dashed #e2e8f0; padding: 1rem 1.25rem; border-radius: 1.25rem; transition: all 0.3s ease;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-weight: 700; color: var(--text-primary); font-size: 1rem;">
                                    Buy {{ $pb_prod->pivot->quantity }} 
                                    @if($pb_variant) ({{ $pb_variant->size }}) @endif
                                    at ₹{{ number_format($pb->total_price, 0) }}
                                </span>
                                <span style="font-size: 0.8rem; color: #10B981; font-weight: 600;">
                                    Save ₹{{ number_format(($pb_variant ? $pb_variant->price : $pb_prod->starting_price) * $pb_prod->pivot->quantity - $pb->total_price, 0) }} instantly
                                </span>
                            </div>
                            <button onclick="addPackToCart({{ $pb->id }})" style="background: var(--text-primary); color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 0.75rem; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fa-solid fa-plus"></i> Add Pack
                            </button>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Pool Offers Section -->
            @if(isset($poolBundles) && $poolBundles->count() > 0)
                <div class="p-pool-section" style="margin-top: 3.5rem; margin-bottom: 3rem; background: #fafafa; padding: 1.75rem; border-radius: 1.5rem; border: 2px dashed var(--accent-color); position: relative;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                        <h3 class="p-section-title" style="margin: 0; color: var(--accent-color); font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px;">Mix & Match Offer</h3>
                        <span style="background: var(--accent-color); color: var(--text-primary); padding: 0.35rem 0.85rem; border-radius: 0.75rem; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">Pool Deal</span>
                    </div>
                    
                    @foreach($poolBundles as $pool)
                        <div class="pool-item" style="margin-bottom: 1.5rem; last-child: margin-bottom: 0;">
                            <p style="font-weight: 700; font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-primary); line-height: 1.4;">
                                Buy any {{ $pool->min_quantity }} items from this collection & get <span style="color: #10B981;">₹{{ number_format($pool->discount_value, 0) }} off</span> your total!
                            </p>
                            
                            <div style="display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 1rem;" class="hide-scrollbar">
                                @foreach($pool->products as $poolProd)
                                    @php 
                                        $p_variant = $poolProd->variants->first(); 
                                    @endphp
                                    <div style="flex: 0 0 90px; position: relative;">
                                        <a href="{{ route('velvet.product', ['id' => $poolProd->id]) }}" style="text-decoration: none; transition: transform 0.3s ease; display: block;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                                            <div style="width: 90px; height: 90px; background: #fff; border-radius: 1.25rem; overflow: hidden; border: 1px solid var(--border-color); margin-bottom: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.06); position: relative;">
                                                <img src="{{ $poolProd->main_image_url }}" alt="{{ $poolProd->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <p style="font-size: 0.65rem; color: var(--text-secondary); text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; font-weight: 700;">
                                                {{ $poolProd->title }}
                                            </p>
                                        </a>
                                        <button onclick="quickAddPoolProduct(event, {{ $poolProd->id }}, {{ $p_variant->id ?? 'null' }}, '{{ $p_variant->size ?? '' }}')" 
                                                style="position: absolute; top: 60px; right: -5px; width: 28px; height: 28px; border-radius: 50%; background: var(--text-primary); color: #fff; border: 2px solid #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; box-shadow: 0 4px 8px rgba(0,0,0,0.15); cursor: pointer; z-index: 5;"
                                                title="Quick Add to Cart">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="p-actions-lg">
                <div class="p-qty-selector">
                    <button onclick="changePageQty(-1)"><i class="fa-solid fa-minus"></i></button>
                    <span id="page-qty">1</span>
                    <button onclick="changePageQty(1)"><i class="fa-solid fa-plus"></i></button>
                </div>
                <button class="add-to-cart-lg btn-primary" id="add-to-cart-page-btn">
                    <span>Add to Cart</span>
                    <span class="btn-divider"></span>
                    <span id="btn-price-display">₹{{ number_format($product->starting_price, 0) }}</span>
                </button>
            </div>
            <!-- Tabby EMI Promo (Bottom) -->
            <div class="v-tabby-promo v-tabby-bottom">
                <span style="flex-grow: 1; line-height: 1.4;">or 4 interest-free payments of <strong style="color: var(--text-primary); font-size: 1.1rem;">₹<span class="tabby-emi-display">{{ number_format($product->starting_price / 4, 0) }}</span></strong> with</span>
                <span style="background: #3DF9D1; color: #000; padding: 0.25rem 0.75rem; border-radius: 0.4rem; font-weight: 900; font-size: 0.85rem; letter-spacing: -0.02em; text-transform: lowercase; display: inline-block; vertical-align: middle; margin-left: 0.5rem;">tabby</span>
            </div>
            <!-- Concentration Guide -->
            <div class="p-concentration-guide">
                <div class="concentration-grid">
                    <div class="conc-item {{ str_contains(strtolower($product->type), 'toilette') ? 'active' : '' }}">
                        <div class="conc-icon"><i class="fa-solid fa-droplet opacity-25"></i></div>
                        <div class="conc-info">
                            <span class="conc-name">EDT</span>
                            <span class="conc-desc">5-15% Oil</span>
                        </div>
                    </div>
                    <div class="conc-item {{ str_contains(strtolower($product->type), 'parfum') && !str_contains(strtolower($product->type), 'extrait') ? 'active' : '' }}">
                        <div class="conc-icon"><i class="fa-solid fa-droplet opacity-60"></i></div>
                        <div class="conc-info">
                            <span class="conc-name">EDP</span>
                            <span class="conc-desc">15-20% Oil</span>
                        </div>
                    </div>
                    <div class="conc-item {{ str_contains(strtolower($product->type), 'extrait') || str_contains(strtolower($product->type), 'oil') ? 'active' : '' }}">
                        <div class="conc-icon"><i class="fa-solid fa-droplet"></i></div>
                        <div class="conc-info">
                            <span class="conc-name">Extrait</span>
                            <span class="conc-desc">20-40% Oil</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="p-tabs">
                <div class="tab-headers">
                    <button class="tab-btn active" onclick="switchTab('desc')">Description</button>
                    <button class="tab-btn" onclick="switchTab('notes')">Olfactory Notes</button>
                    <button class="tab-btn" onclick="switchTab('shipping')">Shipping</button>
                </div>
                <div class="tab-content" id="tab-desc">
                    <p>{{ $product->description }}</p>
                </div>
                <div class="tab-content d-none" id="tab-notes">
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;"><strong>Top Notes:</strong> {{ $product->notes_top }}</li>
                        <li style="margin-bottom: 0.5rem;"><strong>Heart Notes:</strong> {{ $product->notes_heart }}</li>
                        <li style="margin-bottom: 0.5rem;"><strong>Base Notes:</strong> {{ $product->notes_base }}</li>
                    </ul>
                </div>
                <div class="tab-content d-none" id="tab-shipping">
                    <p>Free express shipping on all orders over ₹999. Delivered within 3-5 business days across India.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @php $related = \App\Models\Product::where('collection_id', $product->collection_id)->where('id', '!=', $product->id)->take(4)->get(); @endphp
    @if($related->count() > 0)
    <div style="margin-top: 8rem; margin-bottom: 4rem;">
        <h2 style="font-size: 2.5rem; color: var(--text-primary); font-family: 'Playfair Display', serif;">You Might Also Like</h2>
        <p style="color: var(--text-secondary); margin-top: 0.5rem;">Explore other treasures from this collection.</p>
        
        <div class="v-grid" style="margin-top: 3rem;">
            @foreach($related as $rel)
                @include('velvet.partials.product_card', ['product' => $rel])
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .product-page-container { padding: 1rem 0; color: var(--text-primary); overflow-x: hidden; max-width: 100%; }
    .breadcrumb { display: flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 3rem; }
    .breadcrumb a { color: inherit; text-decoration: none; transition: 0.3s; }
    .breadcrumb a:hover { color: var(--accent-color); }
    .breadcrumb i { font-size: 0.7rem; opacity: 0.5; }

    .product-core-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 5rem; align-items: start; max-width: 100%; }

    .product-gallery { position: sticky; top: calc(var(--header-height) + 2rem); height: fit-content; }
    .main-image-display img { width: 100%; height: 100%; object-fit: cover; }
    .thumb-strip { display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 0.5rem; }
    .t-item { width: 90px; height: 90px; border-radius: 1rem; border: 2px solid transparent; cursor: pointer; transition: 0.3s; object-fit: cover; }
    .t-item.active { border-color: var(--accent-color); }

    .p-title-lg { font-size: 3.5rem; font-weight: 800; color: var(--text-primary); line-height: 1.1; margin-bottom: 0.5rem; }
    .p-vendor-lg { color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em; }

    .p-price-block-lg { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; }
    .p-price-lg { font-size: 2.5rem; font-weight: 800; color: var(--text-primary); }
    .p-compare-lg { font-size: 1.5rem; text-decoration: line-through; color: var(--text-secondary); opacity: 0.6; }
    .p-quick-add-badge { width: 45px; height: 45px; background: var(--accent-color); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; margin-left: auto; }
    .p-quick-add-badge:hover { transform: scale(1.1); }

    .p-spec-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 3rem; background: var(--secondary-bg); padding: 1.5rem; border-radius: 1.5rem; border: 1px solid var(--border-color); }
    .s-label { display: block; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); margin-bottom: 0.25rem; font-weight: 700; }
    .s-value { font-weight: 600; font-size: 1rem; color: var(--text-primary); }

    /* Accords Section */
    .p-accords-section { margin-bottom: 3rem; }
    .p-section-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 1.25rem; color: var(--text-primary); text-transform: uppercase; letter-spacing: 0.05em; }
    .accords-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .accord-item { width: 100%; height: 32px; background: var(--secondary-bg); border-radius: 0.5rem; overflow: hidden; border: 1px solid var(--border-color); }
    .accord-bar { height: 100%; color: #fff; font-size: 0.75rem; display: flex; align-items: center; padding: 0 1.25rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap; transition: width 1s ease-out; }

    /* Variants */
    .p-variants-section { margin-bottom: 3rem; }
    .variant-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem; }
    .variant-card { border: 1.5px solid var(--border-color); border-radius: 1rem; padding: 1.25rem; cursor: pointer; transition: 0.3s; text-align: center; background: #fff; display: flex; flex-direction: column; gap: 0.5rem; }
    .variant-card:hover { border-color: var(--accent-color); }
    .variant-card.active { border-color: var(--accent-color); background: var(--secondary-bg); box-shadow: var(--shadow-soft); }
    .bottle-icon { font-size: 1.2rem; color: var(--accent-color); margin-bottom: 0.25rem; opacity: 0.6; }
    .v-size { font-weight: 700; font-size: 1rem; color: var(--text-primary); }
    .v-price { font-size: 0.85rem; color: var(--text-secondary); font-weight: 500; }

    /* Volume Deals */
    .pack-offer-item:hover { border-color: var(--accent-color) !important; background: var(--secondary-bg) !important; transform: translateY(-2px); }

    /* Pool Section */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Actions */
    .p-actions-lg { display: flex; gap: 1.5rem; margin-bottom: 2rem; align-items: stretch; }
    .p-qty-selector { display: flex; align-items: center; border: 1.5px solid var(--border-color); border-radius: 1rem; padding: 0.5rem; background: #fff; }
    .p-qty-selector button { border: none; background: none; width: 40px; height: 40px; font-size: 1.1rem; color: var(--text-primary); cursor: pointer; border-radius: 0.5rem; transition: 0.3s; }
    .p-qty-selector button:hover { background: var(--secondary-bg); }
    .p-qty-selector span { font-weight: 700; font-size: 1.2rem; min-width: 45px; text-align: center; }

    .add-to-cart-lg { flex-grow: 1; display: flex; align-items: center; justify-content: center; gap: 1.5rem; background: var(--text-primary); color: #fff; border: none; border-radius: 1rem; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: 0.3s; padding: 1.25rem 2rem; text-transform: uppercase; letter-spacing: 0.1em; }
    .add-to-cart-lg:hover { background: #000; transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    .btn-divider { width: 1px; height: 24px; background: rgba(255,255,255,0.2); }
    .success-btn { background: #10B981 !important; border-color: #10B981 !important; }

    /* Concentration Guide */
    .p-concentration-guide { margin-bottom: 3rem; }
    .concentration-grid { display: flex; border: 1px solid var(--border-color); border-radius: 1rem; overflow: hidden; background: #fff; }
    .conc-item { flex: 1; padding: 1.25rem; display: flex; align-items: center; gap: 1rem; border-right: 1px solid var(--border-color); position: relative; }
    .conc-item:last-child { border-right: none; }
    .conc-item.active { background: var(--secondary-bg); }
    .conc-item.active::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--accent-color); }
    .conc-icon { font-size: 1.2rem; color: var(--accent-color); }
    .conc-info { display: flex; flex-direction: column; }
    .conc-name { font-weight: 700; font-size: 0.9rem; color: var(--text-primary); }
    .conc-desc { font-size: 0.7rem; color: var(--text-secondary); white-space: nowrap; }

    /* Tabs */
    .p-tabs { border-top: 1px solid var(--border-color); padding-top: 3rem; margin-top: 2rem; }
    .tab-headers { display: flex; gap: 3rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); }
    .tab-btn { background: none; border: none; font-size: 1rem; font-weight: 700; color: var(--text-secondary); cursor: pointer; padding-bottom: 1rem; border-bottom: 2px solid transparent; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.1em; }
    .tab-btn.active { color: var(--text-primary); border-color: var(--accent-color); }
    .tab-content { line-height: 1.8; color: var(--text-secondary); font-size: 1.1rem; padding-bottom: 2rem; }
    .d-none { display: none; }

    @media (max-width: 1200px) {
        .product-core-grid { grid-template-columns: 1fr; gap: 3rem; }
        .product-details-panel { max-width: 100%; }
        .p-title-lg { font-size: 2.5rem; }
        .product-gallery { position: static; height: auto; }
    }
    
    .main-image-display {
        width: 100%;
        aspect-ratio: 1;
        background: var(--secondary-bg);
        border-radius: 2rem;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .v-tabby-promo {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
    }
    .v-tabby-top {
        margin-top: -1rem;
        margin-bottom: 2rem;
        gap: 0.6rem;
        font-size: 0.9rem;
        color: var(--text-secondary);
        background: #fdfdfd;
        padding: 0.5rem 0.75rem;
        border-radius: 0.75rem;
        width: fit-content;
        border-color: #f1f5f9;
    }
    .v-tabby-bottom {
        margin-top: 1rem;
        margin-bottom: 3rem;
        gap: 0.75rem;
        font-size: 0.95rem;
        color: var(--text-secondary);
        background: #f8fafc;
        padding: 1rem 1.5rem;
        border-radius: 1.25rem;
        width: 100%;
    }

    @media (max-width: 768px) {
        .concentration-grid { flex-direction: row; }
        .conc-item {
            flex-direction: column;
            text-align: center;
            padding: 0.75rem 0.4rem;
            gap: 0.35rem;
            border-right: 1px solid var(--border-color);
            border-bottom: none;
            justify-content: center;
            align-items: center;
        }
        .conc-item:last-child {
            border-right: none;
        }
        .conc-info {
            align-items: center;
        }
        .p-actions-lg { flex-direction: column; }
        .p-qty-selector { justify-content: center; }
        .tab-headers { gap: 1.25rem; justify-content: space-between; }
        .tab-btn { font-size: 0.85rem; }
        .main-image-display {
            border-radius: 1.5rem;
            max-width: 320px;
            margin: 0 auto 1.5rem auto;
        }
        .thumb-strip {
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .p-tabs {
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }
        .pack-offer-item {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        .pack-offer-item button {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        /* Global overflow fix */
        .product-page-container,
        .product-core-grid,
        .product-details-panel,
        .product-gallery {
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }
    }

    @media (max-width: 480px) {
        .p-title-lg { font-size: 2rem !important; }
        .p-price-lg { font-size: 2rem !important; }
        .product-page-container { padding: 0 10px; }
        .p-price-block-lg { flex-wrap: wrap; gap: 0.75rem; }
        .p-spec-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 1.25rem;
        }
        .breadcrumb {
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .p-pool-section {
            margin-top: 2rem !important;
            margin-bottom: 2rem !important;
            padding: 1rem !important;
            border-radius: 1rem !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        .v-tabby-promo {
            flex-wrap: wrap;
            gap: 0.5rem !important;
            padding: 0.75rem !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        .v-tabby-promo span {
            font-size: 0.8rem;
        }
        .concentration-grid {
            flex-direction: row !important;
        }
        .conc-item {
            flex-direction: column !important;
            text-align: center !important;
            padding: 0.75rem 0.4rem !important;
            border-right: 1px solid var(--border-color) !important;
            border-bottom: none !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 0.35rem !important;
        }
        .conc-item:last-child {
            border-right: none !important;
        }
        .conc-info {
            align-items: center !important;
        }
        .conc-name {
            font-size: 0.8rem !important;
        }
        .conc-desc {
            font-size: 0.65rem !important;
            white-space: normal !important;
        }
        .variant-grid {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 0.5rem !important;
        }
        .variant-card {
            padding: 0.75rem 0.5rem !important;
            gap: 0.25rem !important;
        }
        .bottle-icon {
            font-size: 1rem !important;
            margin-bottom: 0 !important;
        }
        .v-size {
            font-size: 0.85rem !important;
        }
        .v-price {
            font-size: 0.8rem !important;
        }
        /* Inline-styled delivery and bundle boxes */
        .product-details-panel > div[style] {
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

@endsection

@push('scripts')
<script>
    let qty = 1;

    function updateImg(src, el) {
        document.getElementById('p-main-img').src = src;
        document.querySelectorAll('.t-item').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    function selectVariant(element, price, size, id) {
        // Update active class
        document.querySelectorAll('.variant-card').forEach(card => card.classList.remove('active'));
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
        document.getElementById('page-qty').innerText = qty;
    }

    function switchTab(tab) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('d-none'));
        
        const targetBtn = Array.from(document.querySelectorAll('.tab-btn')).find(b => b.innerText.toLowerCase().includes(tab));
        if(targetBtn) targetBtn.classList.add('active');
        document.getElementById('tab-' + tab).classList.remove('d-none');
    }

    function addToCart() {
        const variantId = document.getElementById('selected-variant-id').value;
        const activeCard = document.querySelector('.variant-card.active');
        const size = activeCard ? activeCard.querySelector('.v-size').innerText : '';
        const btn = document.getElementById('add-to-cart-page-btn');
        const originalText = btn.innerHTML;

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
                    $('.cart-count-v').text(response.cartCount);
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Added!';
                    btn.classList.add('success-btn');
                    
                    // Open Drawer
                    if(typeof toggleDrawer === 'function') toggleDrawer(true);
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('success-btn');
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

    document.getElementById('add-to-cart-page-btn').addEventListener('click', addToCart);

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
                    $('.cart-count-v').text(response.cartCount);
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Added!';
                    btn.style.background = '#10B981';
                    
                    // Open Drawer
                    if(typeof toggleDrawer === 'function') toggleDrawer(true);
                    
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
                    $('.cart-count-v').text(response.cartCount);
                    btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                    btn.style.background = '#10B981';
                    
                    // Open Drawer
                    if(typeof toggleDrawer === 'function') toggleDrawer(true);
                    
                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.style.background = '';
                        btn.disabled = false;
                    }, 2000);
                }
            }
        });
    }
</script>
@endpush
