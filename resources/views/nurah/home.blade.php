@extends('layouts.storefront')

@section('title', 'VESPR Perfumes | Luxury Fragrance House')
@section('meta_description', 'Experience the art of scent with VESPR Perfumes. Explore our artisanal collection of luxury fragrances, exclusive combos, and signature oils.')
@section('meta_keywords', 'VESPR perfumes, luxury scent, artisanal fragrance, signature perfume, perfume house')

@section('content')
    <!-- Hero Section -->
    <div class="hero-banner">
        <div class="hero-content">
            <h1 class="hero-title">Elevate Your Presence</h1>
            <p class="hero-subtitle">Discover VESPR's curated collection of artisanal fragrances. Crafted for those who appreciate the finer things in life.</p>
            <a href="{{ route('v1.all-products') }}" class="btn-primary">Explore Collection</a>
        </div>
        <img src="{{ asset('Images/hero-banner.png') }}" alt="VESPR Perfume" class="hero-image">
    </div>
    
    <!-- USP Trust Bar -->
    <div class="usp-bar">
        <div class="usp-item">
            <i class="fa-solid fa-circle-check"></i>
            <div class="usp-text">
                <span class="usp-title">100% Authentic</span>
                <span class="usp-desc">Direct from VESPR</span>
            </div>
        </div>
        <div class="usp-item">
            <i class="fa-solid fa-truck-fast"></i>
            <div class="usp-text">
                <span class="usp-title">Express Delivery</span>
                <span class="usp-desc">Across all major cities</span>
            </div>
        </div>
        <div class="usp-item">
            <i class="fa-solid fa-lock"></i>
            <div class="usp-text">
                <span class="usp-title">Secure Payment</span>
                <span class="usp-desc">100% Protected transactions</span>
            </div>
        </div>
        <div class="usp-item">
            <i class="fa-solid fa-rotate-left"></i>
            <div class="usp-text">
                <span class="usp-title">Easy Returns</span>
                <span class="usp-desc">14-Day easy window</span>
            </div>
        </div>
    </div>

    <!-- Featured Categories Grid (Quick Access) -->
    <!-- <div class="department-section">
        <div class="section-header">
            <h2 class="section-title">Shop by Family</h2>
        </div>
        <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
            @php 
                $families = [
                    ['name' => 'Floral', 'icon' => 'fa-leaf', 'color' => '#fdf2f2', 'slug' => 'floral'],
                    ['name' => 'Fresh', 'icon' => 'fa-wind', 'color' => '#f0fdfa', 'slug' => 'fresh'],
                    ['name' => 'Oriental', 'icon' => 'fa-moon', 'color' => '#fffbeb', 'slug' => 'oriental'],
                    ['name' => 'Woody', 'icon' => 'fa-tree', 'color' => '#fefaf2', 'slug' => 'woody']
                ];
            @endphp
            @foreach($families as $fam)
                <a href="{{ route('v1.collection', ['category' => $fam['slug']]) }}" style="background: {{ $fam['color'] }}; padding: 2rem; border-radius: 1.5rem; text-align: center; border: 1px solid rgba(0,0,0,0.05);">
                    <i class="fa-solid {{ $fam['icon'] }}" style="font-size: 2rem; margin-bottom: 1rem; color: var(--primary-color);"></i>
                    <h3 style="font-size: 1.1rem; font-weight: 700;">{{ $fam['name'] }}</h3>
                </a>
            @endforeach
        </div>
    </div> -->

    <!-- Collections Sections (Department Style) -->
    @php 
        $collections = \App\Models\Collection::with(['products' => function($query) {
            $query->where('status', 'active')->take(8);
        }])->where('status', 1)->get(); 
        $hasProducts = $collections->contains(function($c) {
            return $c->products->count() > 0;
        });
    @endphp

    @if($collections->count() > 0 && $hasProducts)
        @foreach($collections as $collection)
            @if($collection->products->count() > 0)
            <div class="department-section" id="collection-{{ $collection->id }}">
                <div class="section-header">
                    <h2 class="section-title">{{ $collection->name }}</h2>
                    <a href="{{ route('v1.collection', ['slug' => $collection->slug]) }}" class="view-all">View all <i class="fa-solid fa-chevron-right ms-1"></i></a>
                </div>
                
                <div class="product-grid">
                    @foreach($collection->products as $product)
                        @include('nurah.partials.product_card', ['product' => $product])
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    @else
        <!-- Fallback Mock Collections and Products -->
        @foreach(['Collection 1', 'Collection 2'] as $collName)
        <div class="department-section">
            <div class="section-header">
                <h2 class="section-title">{{ $collName }}</h2>
                <a href="javascript:void(0)" class="view-all">View all <i class="fa-solid fa-chevron-right ms-1"></i></a>
            </div>
            
            <div class="product-grid">
                @foreach(['Product 1', 'Product 2', 'Product 3', 'Product 4'] as $fallbackName)
                <div class="product-card">
                    <a href="javascript:void(0)" class="card-img">
                        <img src="{{ asset('Images/def_img.webp') }}" alt="{{ $fallbackName }}">
                        <div class="social-proof-tag">
                            <i class="fa-solid fa-fire"></i>
                            <span>{{ rand(45, 180) }} bought this week</span>
                        </div>
                    </a>
                    <div class="card-info">
                        <span class="p-price">₹1,129.00</span>
                        <a href="javascript:void(0)" class="p-name">{{ $fallbackName }}</a>
                        <span class="p-meta">Fresh • Parfum</span>
                    </div>
                    <button class="cart-add-btn" onclick="alert('Please add products in the admin panel.')">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif
    
    <!-- Exclusive Combos Section -->
    @if(isset($bundles) && $bundles->count() > 0)
    <div class="department-section">
        <div class="section-header">
            <h2 class="section-title">Exclusive Combos</h2>
            <a href="{{ route('v1.combos') }}" class="view-all">View all <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
        
        <div class="product-grid">
            @foreach($bundles as $bundle)
                @include('nurah.partials.bundle_card', ['bundle' => $bundle])
            @endforeach
        </div>
    </div>
    @else
    <div class="department-section">
        <div class="section-header">
            <h2 class="section-title">Exclusive Combos</h2>
            <a href="javascript:void(0)" class="view-all">View all <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
        
        <div class="product-grid">
            @foreach(['Bundle 1', 'Bundle 2', 'Bundle 3', 'Bundle 4'] as $fallbackName)
            <div class="product-card">
                <a href="javascript:void(0)" class="card-img">
                    <img src="{{ asset('Images/def_img.webp') }}" alt="{{ $fallbackName }}">
                    <div class="social-proof-tag">
                        <i class="fa-solid fa-shopping-bag"></i>
                        <span>{{ rand(20, 60) }} bundles grabbed recently</span>
                    </div>
                    <div style="position: absolute; top: 0.5rem; right: 0.5rem; background: var(--accent-color); color: var(--primary-color); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">
                        COMBO SAVINGS
                    </div>
                </a>
                <div class="card-info">
                    <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                        <span class="p-price">₹1,999.00</span>
                    </div>
                    <a href="javascript:void(0)" class="p-name">{{ $fallbackName }}</a>
                    <span class="p-meta">2 Products Included</span>
                </div>
                <button class="cart-add-btn" onclick="alert('Please add combos in the admin panel.')">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Fragrance Stories (Video Showcase) -->
    @php
        $getEmbedUrl = function($url, $defaultId) {
            if (empty($url)) {
                $id = $defaultId;
            } else {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                    $id = $match[1];
                } else {
                    $id = trim($url);
                    if (strlen($id) !== 11) {
                        $id = $defaultId;
                    }
                }
            }
            return "https://www.youtube.com/embed/{$id}?autoplay=1&mute=1&loop=1&playlist={$id}&controls=0&modestbranding=1&rel=0&playsinline=1";
        };

        $tenantId = $currentTenant->id ?? 1;
        $videoSetting = \App\Models\TenantVideo::where('tenant_id', $tenantId)
            ->with(['video1Collection', 'video2Collection', 'video3Collection', 'video4Collection', 'video5Collection'])
            ->first();
        
        $v1 = $getEmbedUrl($videoSetting->video1_url ?? null, '167AIKitcZs');
        $v2 = $getEmbedUrl($videoSetting->video2_url ?? null, 'QM18rD-zrCs');
        $v3 = $getEmbedUrl($videoSetting->video3_url ?? null, 'P7MxjMYwU_g');
        $v4 = $getEmbedUrl($videoSetting->video4_url ?? null, 'UujTjwkuqbE');
        $v5 = $getEmbedUrl($videoSetting->video5_url ?? null, 'WamyeDrjaVA');

        $getRedirectUrl = function($videoColRelation, $themeRoutePrefix) {
            if ($videoColRelation && $videoColRelation->slug) {
                return route($themeRoutePrefix . '.collection', ['slug' => $videoColRelation->slug]);
            }
            return route($themeRoutePrefix . '.all-products');
        };

        $link1 = $getRedirectUrl($videoSetting->video1Collection ?? null, 'v1');
        $link2 = $getRedirectUrl($videoSetting->video2Collection ?? null, 'v1');
        $link3 = $getRedirectUrl($videoSetting->video3Collection ?? null, 'v1');
        $link4 = $getRedirectUrl($videoSetting->video4Collection ?? null, 'v1');
        $link5 = $getRedirectUrl($videoSetting->video5Collection ?? null, 'v1');
    @endphp
    <div class="video-section">
        <div class="section-header">
            <h2 class="section-title">Fragrance Stories</h2>
            <p class="section-subtitle" style="margin-top: 0.5rem; color: var(--text-muted);">Experience the essence of VESPR through our visual journey.</p>
        </div>
        
        <div class="video-grid">
            <div class="video-card">
                <div class="video-container">
                    <iframe src="{{ $v1 }}" title="Fragrance Story 1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <a href="{{ $link1 }}" class="video-btn">Shop Collection</a>
                </div>
            </div>
            <div class="video-card">
                <div class="video-container">
                    <iframe src="{{ $v2 }}" title="Fragrance Story 2" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <a href="{{ $link2 }}" class="video-btn">Shop Collection</a>
                </div>
            </div>
            <div class="video-card">
                <div class="video-container">
                    <iframe src="{{ $v3 }}" title="Fragrance Story 3" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <a href="{{ $link3 }}" class="video-btn">Shop Collection</a>
                </div>
            </div>
            <div class="video-card">
                <div class="video-container">
                    <iframe src="{{ $v4 }}" title="Fragrance Story 4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <a href="{{ $link4 }}" class="video-btn">Shop Collection</a>
                </div>
            </div>
            <div class="video-card">
                <div class="video-container">
                    <iframe src="{{ $v5 }}" title="Fragrance Story 5" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <a href="{{ $link5 }}" class="video-btn">Shop Collection</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="newsletter-section">
        <div class="newsletter-content">
            <h2 class="newsletter-title">Experience Excellence</h2>
            <p class="newsletter-subtitle">Join our exclusive circle and be the first to know about new artisanal launches and limited edition scents.</p>
            <form class="newsletter-input-group">
                <input type="email" placeholder="Your email address" class="newsletter-input">
                <button type="button" class="newsletter-btn">Subscribe</button>
            </form>
        </div>
    </div>
@endsection

