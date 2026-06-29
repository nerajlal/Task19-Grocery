@extends('v4.layouts.app')

@section('title', $product->title . ' | Task19 Luxury Fragrance')

@section('content')
    <div class="container" style="margin-top: 30px;">
        <nav class="v4-breadcrumb">
            <a href="{{ route('v4.home') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('v4.all-products') }}">Shop</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>{{ $product->title }}</span>
        </nav>

        <div class="a-product-detail-layout" style="margin-top: 30px;">
            <!-- Left: Images -->
            <div class="a-product-media">
                <div class="a-main-image-container">
                    <img src="{{ $product->main_image_url ?? asset('Images/g-load.webp') }}" 
                         onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                         alt="{{ $product->title }}" 
                         class="a-main-image" id="mainImage">
                    
                    @if($product->compare_at_price > $product->starting_price)
                        <span class="a-detail-discount">SAVE {{ round((($product->compare_at_price - $product->starting_price) / $product->compare_at_price) * 100) }}%</span>
                    @endif

                    @if(isset($packBundles) && $packBundles->count() > 0)
                        @php 
                            $bestPack = $packBundles->sortBy('total_price')->first(); 
                            $bestQty = $bestPack->products->first()->pivot->quantity;
                        @endphp
                        <div class="v4-floating-badge">
                            <i class="fa-solid fa-tags"></i> Buy {{ $bestQty }} at ₹{{ number_format($bestPack->total_price, 0) }}
                        </div>
                    @endif
                </div>
                <div class="a-thumbnail-grid">
                    @if($product->main_image_url)
                        <img src="{{ $product->main_image_url }}" class="a-thumb active" onclick="setMainImage(this.src, this)" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                    @endif
                    @foreach($product->images as $img)
                        @php $imgUrl = (strpos($img->path, 'http') === 0) ? $img->path : Storage::url($img->path); @endphp
                        {{-- Only show if it's not the main image to avoid duplicates --}}
                        @if($imgUrl != $product->main_image_url)
                            <img src="{{ $imgUrl }}" class="a-thumb" onclick="setMainImage(this.src, this)" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Right: Details -->
            <div class="a-product-details">
                <div class="a-detail-header">
                    <div class="a-detail-cat">{{ $product->olfactory_family ?? 'Fragrance' }}</div>
                    <h1 class="serif">{{ $product->title }}</h1>
                    <div class="a-detail-price">
                        @if($product->compare_at_price > $product->starting_price)
                            <span class="a-price-old">₹{{ number_format($product->compare_at_price, 0) }}</span>
                        @endif
                        <span class="a-price-new">₹{{ number_format($product->starting_price, 0) }}</span>
                    </div>
                </div>

                <div class="v4-delivery-urgency">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Get it by <strong>{{ now()->addDays(2)->format('l, M jS') }}</strong> if you order within 4 hours.</span>
                </div>

                <div class="a-detail-description">
                    <p>{{ $product->description ?? 'Experience the essence of luxury with this exquisite fragrance. Designed for long-lasting appeal and perfect for any occasion.' }}</p>
                </div>

                <!-- Combo Promo Box -->
                @if(isset($bundle))
                <div class="v4-deal-promo">
                    <div class="v4-deal-content">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Save more with the <strong>{{ $bundle->title }}</strong> combo</span>
                    </div>
                    <a href="{{ route('v4.combo', ['id' => $bundle->id]) }}" class="v4-deal-link">
                        View Combo <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
                @endif

                <div class="a-detail-variants">
                    <h3>Select Size</h3>
                    <div class="a-variant-options">
                        @foreach($product->variants as $variant)
                            <button class="a-variant-btn {{ $loop->first ? 'active' : '' }}" 
                                    data-size="{{ $variant->size }}"
                                    data-variant-id="{{ $variant->id }}"
                                    onclick="selectVariant(this, {{ $variant->price }}, '{{ $variant->size }}')">
                                {{ $variant->size }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="a-detail-actions">
                    <div class="a-qty-selector">
                        <button onclick="updateQty(-1)">-</button>
                        <input type="number" value="1" id="productQty" readonly>
                        <button onclick="updateQty(1)">+</button>
                    </div>
                    <button class="a-add-to-cart" id="addToCartBtn" onclick="handleAddToCart()">
                        <i class="fa-solid fa-bag-shopping"></i> Add to Bag
                    </button>
                </div>

                <div class="v4-payment-promo">
                    or 4 interest-free payments of <strong>₹{{ number_format($product->starting_price / 4, 0) }}</strong> with <img src="https://cdn.tabby.ai/assets/logo.svg" alt="tabby" style="height: 14px; vertical-align: middle; margin-left: 5px;">
                </div>

                <!-- Concentration Guide -->
                <div class="v4-conc-guide">
                    <div class="conc-step {{ str_contains(strtolower($product->type), 'toilette') ? 'active' : '' }}">
                        <span class="c-name">EDT</span>
                        <span class="c-desc">5-15% Oil</span>
                    </div>
                    <div class="conc-step {{ (str_contains(strtolower($product->type), 'parfum') && !str_contains(strtolower($product->type), 'extrait')) || str_contains(strtolower($product->olfactory_family), 'edp') ? 'active' : '' }}">
                        <span class="c-name">EDP</span>
                        <span class="c-desc">15-20% Oil</span>
                    </div>
                    <div class="conc-step {{ str_contains(strtolower($product->type), 'extrait') || str_contains(strtolower($product->type), 'oil') || str_contains(strtolower($product->type), 'attar') ? 'active' : '' }}">
                        <span class="c-name">Extrait</span>
                        <span class="c-desc">20-40% Oil</span>
                    </div>
                </div>

                <!-- Special Volume Deals (Pack Of) -->
                @if(isset($packBundles) && $packBundles->count() > 0)
                <div class="v4-volume-deals">
                    <h3>Special Volume Deals</h3>
                    <div class="v4-deals-grid">
                        @foreach($packBundles as $pb)
                            @php 
                                $pb_prod = $pb->products->first();
                                $pb_variant = $pb_prod ? $pb_prod->variants->firstWhere('id', $pb_prod->pivot->product_variant_id) : null;
                            @endphp
                            @if($pb_prod)
                            <div class="v4-deal-card">
                                <div class="v4-deal-info">
                                    <span class="v4-deal-title">Buy {{ $pb_prod->pivot->quantity }} @if($pb_variant) ({{ $pb_variant->size }}) @endif</span>
                                    <span class="v4-deal-save">Save ₹{{ number_format(($pb_variant ? $pb_variant->price : $pb_prod->starting_price) * $pb_prod->pivot->quantity - $pb->total_price, 0) }}</span>
                                </div>
                                <button onclick="addPackToCart({{ $pb->id }}, event)" class="v4-deal-add-btn">
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
                    <div class="v4-pool-box">
                        <div class="v4-pool-header">
                            <span class="v4-pool-label">MIX & MATCH OFFER</span>
                            <h4>Buy any {{ $pool->min_quantity }} & get ₹{{ number_format($pool->discount_value, 0) }} off</h4>
                        </div>
                        <div class="v4-pool-grid">
                            @foreach($pool->products->take(4) as $poolProd)
                                @php $p_variant = $poolProd->variants->first(); @endphp
                                <div class="v4-pool-item {{ $poolProd->id == $product->id ? 'current' : '' }}">
                                    <div class="v4-pool-img">
                                        <img src="{{ $poolProd->main_image_url }}" alt="{{ $poolProd->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                                        <button class="v4-pool-quick-add" onclick="quickAddPoolProduct(event, {{ $poolProd->id }}, {{ $p_variant->id ?? 'null' }}, '{{ $p_variant->size ?? '' }}')">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                    <span class="v4-pool-name">{{ $poolProd->title }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="v4-fragrance-pyramid">
                    <h3 class="serif">Fragrance Pyramid</h3>
                    <div class="pyramid-container">
                        <!-- Top Notes -->
                        <div class="pyramid-layer top">
                            <div class="layer-content">
                                <span class="layer-label">TOP NOTES</span>
                                <h4 class="layer-title">Bergamot, Lemon, Pink Pepper</h4>
                            </div>
                        </div>
                        <!-- Heart Notes -->
                        <div class="pyramid-layer heart">
                            <div class="layer-content">
                                <span class="layer-label">HEART NOTES</span>
                                <h4 class="layer-title">Rose, Jasmine, Patchouli</h4>
                            </div>
                        </div>
                        <!-- Base Notes -->
                        <div class="pyramid-layer base">
                            <div class="layer-content">
                                <span class="layer-label">BASE NOTES</span>
                                <h4 class="layer-title">Oud, Amber, Musk, Vanilla</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="v4-trust-badges">
                    <div class="v4-trust-item">
                        <div class="v4-trust-icon"><i class="fa-solid fa-truck-fast"></i></div>
                        <div class="v4-trust-text">
                            <strong>FREE EXPRESS SHIPPING</strong>
                            <span>Delivery within 2-3 business days</span>
                        </div>
                    </div>
                    <div class="v4-trust-item">
                        <div class="v4-trust-icon"><i class="fa-solid fa-lock"></i></div>
                        <div class="v4-trust-text">
                            <strong>100% AUTHENTIC</strong>
                            <span>Directly from Task19 Fragrance House</span>
                        </div>
                    </div>
                    <div class="v4-trust-item">
                        <div class="v4-trust-icon"><i class="fa-solid fa-arrows-rotate"></i></div>
                        <div class="v4-trust-text">
                            <strong>7-DAY RETURNS</strong>
                            <span>Easy & hassle-free return policy</span>
                        </div>
                    </div>
                </div>

                <div class="social-proof-tag" style="position: relative; left: 0; transform: none; margin-top: 30px; display: inline-flex;">
                    <i class="fa-solid fa-eye"></i>
                    <span>{{ rand(100, 500) }} people are viewing this right now</span>
                </div>


                <div class="a-product-tabs" style="margin-top: 40px;">
                    <div class="a-tab-item active" onclick="toggleTab(this, 'desc')">Description</div>
                    <div class="a-tab-item" onclick="toggleTab(this, 'usage')">How to Use</div>
                    <div class="a-tab-item" onclick="toggleTab(this, 'ingredients')">Ingredients</div>
                </div>
                <div class="a-tab-content active" id="desc">
                    <p>{{ $product->description ?? 'Experience the essence of luxury with this exquisite fragrance. Designed for long-lasting appeal and perfect for any occasion.' }}</p>
                </div>
                <div class="a-tab-content" id="usage">
                    <p>Spray on pulse points: neck, chest, and wrists for a long-lasting fragrance experience. Avoid rubbing the skin after application as it breaks down the scent molecules.</p>
                </div>
                <div class="a-tab-content" id="ingredients">
                    <p>Alcohol Denat, Aqua (Water), Fragrance, Linalool, Limonene, Citronellol, Geraniol, Coumarin, Citral.</p>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="a-related-section">
            <h2 class="aj-title cursive text-center">YOU MAY ALSO <span class="sketch-under">LIKE</span></h2>
            <div class="a-product-grid">
                @foreach($relatedProducts->take(4) as $related)
                    @include('v4.partials.product_card', ['product' => $related])
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <style>
        .a-product-detail-layout {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 60px;
            align-items: start;
        }

        .a-product-media {
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: sticky;
            top: 120px;
            align-self: start;
        }

        .a-main-image-container {
            position: relative;
            aspect-ratio: 1;
            background: var(--bg-soft);
            border-radius: 12px;
            overflow: hidden;
            max-height: 550px;
            width: 100%;
            margin: 0 auto;
        }

        .a-main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .a-detail-discount {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--accent);
            color: #fff;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 1px;
            z-index: 5;
        }

        .v4-floating-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--aj-gold);
            color: #fff;
            padding: 8px 15px;
            border-radius: 999px;
            font-weight: 900;
            font-size: 11px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(176, 141, 87, 0.3);
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 2px solid #fff;
            animation: v4Float 3s ease-in-out infinite;
        }

        @keyframes v4Float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0); }
        }

        .a-thumbnail-grid {
            display: flex;
            gap: 15px;
        }

        .a-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: 0.3s;
            background: var(--bg-soft);
        }

        .a-thumb.active { border-color: var(--accent); }

        .a-detail-header { margin-bottom: 30px; }
        .a-detail-cat {
            font-size: 13px;
            text-transform: uppercase;
            color: var(--accent);
            letter-spacing: 2px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .a-detail-header h1 { font-size: 48px; margin-bottom: 15px; line-height: 1.1; }
        
        .a-detail-price { display: flex; align-items: baseline; gap: 15px; }
        .a-price-new { font-size: 32px; font-weight: 800; color: var(--primary); }
        .a-price-old { font-size: 20px; text-decoration: line-through; color: var(--text-muted); }

        .a-detail-description {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.8;
            margin-bottom: 40px;
        }

        .a-detail-variants { margin-bottom: 40px; }
        .a-detail-variants h3 { font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }

        .a-variant-options { display: flex; gap: 12px; }
        .a-variant-btn {
            padding: 12px 25px;
            border: 2px solid #eee;
            background: #fff;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            color: var(--aj-gray);
            position: relative;
        }

        .a-variant-btn.active { 
            border-color: var(--aj-gold); 
            background: #fffaf0; 
            color: var(--aj-gold); 
            box-shadow: 0 5px 15px rgba(176, 141, 87, 0.1);
        }
        
        .a-variant-btn.active::after {
            content: '\f058';
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            color: var(--aj-gold);
            font-size: 14px;
            border-radius: 50%;
        }

        .a-detail-actions {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .a-qty-selector {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            width: 120px;
        }

        .a-qty-selector button {
            width: 40px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }
        .a-qty-selector button:hover { background: var(--bg-soft); }

        .a-qty-selector input {
            width: 40px;
            border: none;
            text-align: center;
            font-weight: 700;
            outline: none;
        }

        .a-add-to-cart {
            flex-grow: 1;
            background: #000;
            color: #fff;
            border: none;
            padding: 18px;
            border-radius: 4px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .a-add-to-cart:hover { background: var(--aj-gold); }

        .a-detail-features {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            padding-top: 30px;
            border-top: 1px solid var(--border);
        }

        .v4-trust-badges {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--aj-border);
        }

        .v4-trust-item {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 15px;
            background: #fcfcfc;
            border-radius: 8px;
            transition: 0.3s;
        }

        .v4-trust-item:hover { background: #fffaf0; }

        .v4-trust-icon { font-size: 20px; color: var(--aj-gold); }
        
        .v4-trust-text strong { 
            display: block; 
            font-size: 10px; 
            font-weight: 900; 
            color: var(--aj-dark); 
            letter-spacing: 1px; 
            margin-bottom: 4px; 
        }
        
        .v4-trust-text span { 
            font-size: 10px; 
            color: var(--aj-gray); 
            font-weight: 600; 
            line-height: 1.4; 
            display: block;
        }

        /* Fragrance Pyramid */
        .v4-fragrance-pyramid {
            margin-top: 50px;
            padding-top: 40px;
            border-top: 1px solid var(--aj-border);
            text-align: center;
        }

        .v4-fragrance-pyramid h3 { 
            font-size: 16px; 
            letter-spacing: 2px; 
            text-transform: uppercase; 
            margin-bottom: 40px; 
            font-weight: 800; 
        }

        .pyramid-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            max-width: 500px;
            margin: 0 auto;
        }

        .pyramid-layer {
            width: 100%;
            background: #fff;
            border: 1px solid #eee;
            padding: 25px;
            position: relative;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: default;
        }

        .pyramid-layer.top { width: 50%; border-radius: 100px 100px 10px 10px; background: #fffaf0; border-color: var(--aj-gold); }
        .pyramid-layer.heart { width: 75%; border-radius: 10px; }
        .pyramid-layer.base { width: 100%; border-radius: 10px 10px 100px 100px; }

        .pyramid-layer:hover {
            transform: scale(1.02);
            border-color: var(--aj-gold);
            z-index: 2;
            box-shadow: 0 10px 30px rgba(176, 141, 87, 0.1);
        }

        .layer-label {
            display: block;
            font-size: 9px;
            font-weight: 900;
            color: var(--aj-gold);
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .layer-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--aj-dark);
            margin: 0;
        }

        @media (max-width: 1024px) {
            .pyramid-layer.top, .pyramid-layer.heart { width: 100%; }
        }

        .a-related-section { 
            margin-top: 100px; 
            padding-top: 80px;
            border-top: 1px solid #f0f0f0;
        }
        .a-related-section .aj-title { margin-bottom: 50px; }
        
        .a-product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        @media (max-width: 991px) {
            .a-product-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
        }

        @media (max-width: 1024px) {
            .a-product-detail-layout { grid-template-columns: 1fr; gap: 40px; }
            .a-product-details { max-width: 100%; }
            .a-detail-header h1 { font-size: 36px; }
            .a-main-image-container { border-radius: 0; margin: 0 -20px; }
            .a-sticky-mobile-bar { display: flex; }
            main .container { padding-bottom: 100px; }
        }

        /* Tabs */
        .a-product-tabs { display: flex; gap: 30px; border-bottom: 1px solid var(--aj-border); margin-bottom: 20px; }
        .a-tab-item { font-size: 13px; font-weight: 700; text-transform: uppercase; padding-bottom: 15px; cursor: pointer; color: var(--aj-gray); transition: 0.3s; position: relative; }
        .a-tab-item.active { color: var(--aj-dark); }
        .a-tab-item.active::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background: var(--aj-gold); }
        .a-tab-content { display: none; font-size: 14px; line-height: 1.8; color: var(--aj-gray); }
        .a-tab-content.active { display: block; }

        /* Sticky Mobile Bar */
        .a-sticky-mobile-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
            display: none;
            justify-content: space-between;
            align-items: center;
            z-index: 2000;
        }
        .a-sticky-info h4 { font-size: 14px; font-weight: 700; margin-bottom: 2px; }
        .a-sticky-info p { font-size: 16px; font-weight: 800; color: var(--aj-gold); margin: 0; }
        .a-sticky-btn { background: #000; color: #fff; border: none; padding: 12px 25px; border-radius: 4px; font-weight: 700; text-transform: uppercase; font-size: 12px; }

        /* V4 Deal Styles */
        .v4-deal-promo { background: #fdfaf5; border: 1px solid #eee; border-radius: 8px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .v4-deal-content { display: flex; align-items: center; gap: 15px; font-size: 14px; }
        .v4-deal-content i { color: var(--aj-gold); font-size: 18px; }
        .v4-deal-link { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--aj-gold); text-decoration: none; display: flex; align-items: center; gap: 8px; }

        .v4-volume-deals { margin-top: 40px; margin-bottom: 40px; }
        .v4-volume-deals h3 { font-size: 14px; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 20px; font-weight: 800; }
        .v4-deals-grid { display: flex; flex-direction: column; gap: 12px; }
        .v4-deal-card { display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border: 1.5px dashed var(--aj-border); border-radius: 8px; }
        .v4-deal-info { display: flex; flex-direction: column; gap: 4px; }
        .v4-deal-title { font-size: 14px; font-weight: 700; color: var(--aj-dark); }
        .v4-deal-save { font-size: 12px; font-weight: 800; color: #10B981; }
        .v4-deal-add-btn { background: #000; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; font-weight: 700; font-size: 12px; cursor: pointer; transition: 0.3s; }
        .v4-deal-add-btn:hover { background: var(--aj-gold); }

        .v4-pool-box { margin-top: 40px; background: #fff; border: 2px solid var(--aj-gold); border-radius: 12px; padding: 20px; }
        .v4-pool-header { text-align: center; margin-bottom: 20px; }
        .v4-pool-label { font-size: 10px; font-weight: 800; color: var(--aj-gold); letter-spacing: 2px; text-transform: uppercase; }
        .v4-pool-header h4 { font-size: 16px; font-weight: 800; color: var(--aj-dark); margin-top: 5px; }
        .v4-pool-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; }
        .v4-pool-item { text-align: center; }
        .v4-pool-img { 
            width: 100%;
            aspect-ratio: 1; 
            background: #f9f9f9; 
            border-radius: 8px; 
            overflow: hidden; 
            position: relative; 
            margin-bottom: 8px; 
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .v4-pool-item.current .v4-pool-img { border: 2px solid var(--aj-gold); }
        .v4-pool-img img { width: 100%; height: 100%; object-fit: contain; padding: 5px; }
        .v4-pool-quick-add { position: absolute; bottom: 5px; right: 5px; width: 24px; height: 24px; border-radius: 50%; background: #000; color: #fff; border: none; display: flex; align-items: center; justify-content: center; font-size: 10px; cursor: pointer; transition: 0.3s; }
        .v4-pool-quick-add:hover { background: var(--aj-gold); }
        .v4-pool-name { font-size: 10px; font-weight: 600; color: var(--aj-gray); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* Final Polish Styles */
        .v4-breadcrumb { display: flex; align-items: center; gap: 10px; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; color: var(--aj-gray); }
        .v4-breadcrumb a { text-decoration: none; color: inherit; transition: 0.3s; }
        .v4-breadcrumb a:hover { color: var(--aj-gold); }
        .v4-breadcrumb i { font-size: 8px; opacity: 0.5; }

        .v4-delivery-urgency { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #E67E22; margin-bottom: 25px; font-weight: 600; }
        .v4-delivery-urgency i { font-size: 16px; }

        .v4-payment-promo { font-size: 13px; color: var(--aj-gray); margin-bottom: 30px; padding: 10px 0; border-top: 1px solid #f9f9f9; }

        .v4-conc-guide { display: flex; border: 1px solid #eee; border-radius: 8px; overflow: hidden; margin-top: 30px; margin-bottom: 30px; }
        .conc-step { flex: 1; padding: 12px; text-align: center; display: flex; flex-direction: column; gap: 4px; position: relative; background: #fff; transition: 0.3s; }
        .conc-step:not(:last-child) { border-right: 1px solid #eee; }
        .conc-step.active { background: #fffaf0; }
        .conc-step.active::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 3px; background: var(--aj-gold); }
        .c-name { font-weight: 900; font-size: 13px; color: var(--aj-dark); }
        .c-desc { font-size: 10px; color: var(--aj-gray); font-weight: 600; }
        .conc-step.active .c-name { color: var(--aj-gold); }

        /* Responsive */
        @media (max-width: 1024px) {
            .a-product-detail-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .a-product-media {
                position: relative;
                top: 0;
            }

            .a-product-details {
                padding-top: 0;
            }

            .serif { font-size: 28px !important; }

            .a-detail-actions {
                flex-direction: column;
                gap: 15px;
            }

            .a-qty-selector, #addToCartBtn {
                width: 100%;
            }

            #addToCartBtn {
                padding: 18px;
            }

            .v4-trust-badges {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }
            .v4-trust-item {
                padding: 10px 5px;
                gap: 8px;
                text-align: center;
                align-items: center;
            }

            .v4-pool-grid {
                grid-template-columns: repeat(2, 1fr);
            }



            .pyramid-container {
                max-width: 100%;
            }

            .v4-deal-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .v4-deal-add-btn {
                width: 100%;
            }

            .a-main-image-container {
                max-height: 400px;
            }

            .a-product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .a-related-section {
                margin-top: 60px;
                padding-top: 50px;
            }
        }

        @media (max-width: 480px) {

            .v4-pool-grid {
                gap: 10px;
            }
            .a-product-detail-layout {
                padding: 0 20px;
            }

            .v4-breadcrumb {
                padding: 0 20px;
                margin-bottom: 20px;
            }

            /* Sticky Mobile Bar Styles */
            .a-sticky-mobile-bar {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background: #fff;
                padding: 15px 20px;
                padding-bottom: calc(15px + env(safe-area-inset-bottom, 0px));
                box-shadow: 0 -10px 30px rgba(0,0,0,0.08);
                z-index: 1000;
                align-items: center;
                justify-content: space-between;
                border-top: 1px solid #f0f0f0;
                animation: v4StickySlide 0.4s ease;
            }

            @keyframes v4StickySlide {
                from { transform: translateY(100%); }
                to { transform: translateY(0); }
            }

            .a-sticky-info h4 { font-size: 14px; font-weight: 800; color: var(--aj-dark); margin: 0; }
            .a-sticky-info p { font-size: 12px; font-weight: 700; color: var(--aj-gold); margin: 0; }
            .a-sticky-btn { background: #000; color: #fff; border: none; padding: 12px 25px; border-radius: 4px; font-weight: 800; font-size: 13px; cursor: pointer; transition: 0.3s; }
            .a-sticky-btn:hover { background: var(--aj-gold); }

            /* Fix whitespace below */
            body { padding-bottom: 80px; }
        }
    </style>

    <script>
        function setMainImage(src, thumb) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.a-thumb').forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
        }

        function updateQty(delta) {
            const input = document.getElementById('productQty');
            let val = parseInt(input.value) + delta;
            if(val < 1) val = 1;
            input.value = val;
        }

        function selectVariant(btn, price, size) {
            document.querySelectorAll('.a-variant-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const priceText = '₹' + price.toLocaleString();
            document.querySelector('.a-price-new').innerText = priceText;
            document.querySelector('.a-sticky-info p').innerText = priceText;
        }

        function toggleTab(btn, tabId) {
            document.querySelectorAll('.a-tab-item').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.a-tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }

        function handleAddToCart() {
            const btns = [document.getElementById('addToCartBtn'), document.querySelector('.a-sticky-btn')];
            const size = document.querySelector('.a-variant-btn.active')?.dataset.size || '';
            const qty = document.getElementById('productQty').value;
            
            // UI Feedback for all buttons
            btns.forEach(btn => {
                if(!btn) return;
                btn.dataset.originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                btn.disabled = true;
            });

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $product->id }}",
                    quantity: qty,
                    size: size
                },
                success: function(response) {
                    if(response.success) {
                        $('#cart-count').text(response.cartCount);
                        
                        // Open Cart Drawer
                        if(typeof toggleCart === 'function') {
                            setTimeout(() => {
                                toggleCart();
                            }, 500);
                        }

                        btns.forEach(btn => {
                            if(!btn) return;
                            btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                            btn.style.background = '#10B981';
                            setTimeout(() => {
                                btn.innerHTML = btn.dataset.originalHtml;
                                btn.style.background = '';
                                btn.disabled = false;
                            }, 2000);
                        });
                    }
                }
            });
        }

        function addPackToCart(bundleId, event) {
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
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

        function quickAddPoolProduct(event, productId, variantId, size) {
            event.preventDefault();
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
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
    </script>

    <!-- Sticky Mobile Bar -->
    <div class="a-sticky-mobile-bar">
        <div class="a-sticky-info">
            <h4>{{ $product->title }}</h4>
            <p>₹{{ number_format($product->starting_price, 0) }}</p>
        </div>
        <button class="a-sticky-btn" onclick="handleAddToCart()">Add to Bag</button>
    </div>
@endsection
