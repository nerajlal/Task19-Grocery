@extends('template_2.layouts.app')

@section('title', ($currentTenant->name ?? 'Fresh Grocery') . ' | Farm Fresh Groceries & Daily Essentials')
@section('meta_description', 'Order farm fresh vegetables, organic fruits, dairy products, bakery goods, and daily essentials online. Super-fast home delivery guaranteed.')
@section('meta_keywords', 'online grocery store, fresh vegetables, buy organic fruits, dairy delivery, daily essentials shop')

@section('content')
    <!-- Hero Banner Section -->
    <div class="hero-banner" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); padding: 4rem 3rem; border-radius: 2rem; display: flex; flex-direction: column; align-items: center; text-align: center; justify-content: center; margin-bottom: 2rem; border: 1px solid rgba(16, 185, 129, 0.1);">
        <div class="hero-content" style="max-width: 800px; margin: 0 auto;">
            <h1 class="hero-title" style="font-size: 3.2rem; font-weight: 800; color: #064e3b; line-height: 1.15; margin-bottom: 1.5rem;">Farm Fresh Groceries <br><span style="color: var(--accent-color);">Delivered Daily</span></h1>
            <p class="hero-subtitle" style="font-size: 1.15rem; color: #065f46; margin-bottom: 2.5rem; line-height: 1.6;">Shop organic fruits, fresh vegetables, dairy, bakery items, and daily household essentials from the comfort of your home. Enjoy super-fast home delivery and unbeatable prices.</p>
            <a href="{{ route('v3.all-products') }}" class="btn-primary" style="background: var(--accent-color); color: #fff; padding: 0.95rem 2.5rem; border-radius: 9999px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); transition: all 0.2s ease;">Start Shopping <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
    
    <!-- USP Trust Bar -->
    <div class="usp-bar" style="background: #fff; border: 1px solid var(--border-color); border-radius: 1.5rem; padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <div class="usp-item" style="display: flex; align-items: center; gap: 1rem;">
            <div style="background: #ecfdf5; color: var(--accent-color); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-carrot"></i>
            </div>
            <div class="usp-text">
                <span class="usp-title" style="display: block; font-weight: 700; font-size: 0.95rem;">100% Farm Fresh</span>
                <span class="usp-desc" style="display: block; font-size: 0.75rem; color: var(--text-muted);">Sourced directly from local farms</span>
            </div>
        </div>
        <div class="usp-item" style="display: flex; align-items: center; gap: 1rem;">
            <div style="background: #ecfdf5; color: var(--accent-color); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="usp-text">
                <span class="usp-title" style="display: block; font-weight: 700; font-size: 0.95rem;">2-Hour Delivery</span>
                <span class="usp-desc" style="display: block; font-size: 0.75rem; color: var(--text-muted);">Express delivery to your doorstep</span>
            </div>
        </div>
        <div class="usp-item" style="display: flex; align-items: center; gap: 1rem;">
            <div style="background: #ecfdf5; color: var(--accent-color); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="usp-text">
                <span class="usp-title" style="display: block; font-weight: 700; font-size: 0.95rem;">Hygienically Packed</span>
                <span class="usp-desc" style="display: block; font-size: 0.75rem; color: var(--text-muted);">Handled with strict safety protocols</span>
            </div>
        </div>
        <div class="usp-item" style="display: flex; align-items: center; gap: 1rem;">
            <div style="background: #ecfdf5; color: var(--accent-color); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                <i class="fa-solid fa-rotate"></i>
            </div>
            <div class="usp-text">
                <span class="usp-title" style="display: block; font-weight: 700; font-size: 0.95rem;">No Questions Return</span>
                <span class="usp-desc" style="display: block; font-size: 0.75rem; color: var(--text-muted);">Instant returns at delivery window</span>
            </div>
        </div>
    </div>

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
            <div class="department-section" id="collection-{{ $collection->id }}" style="margin-bottom: 3rem;">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 class="section-title" style="font-weight: 800; font-size: 1.6rem; color: var(--primary-color); position: relative;">{{ $collection->name }}</h2>
                    <a href="{{ route('v3.collection', ['slug' => $collection->slug]) }}" class="view-all" style="color: var(--accent-color); text-decoration: none; font-weight: 700; font-size: 0.9rem;">View All <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.75rem;"></i></a>
                </div>
                
                <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
                    @foreach($collection->products as $product)
                        @include('template_1.partials.product_card', ['product' => $product])
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    @else
        <!-- Fallback mock products if seeder has not run yet -->
        <div class="department-section" style="margin-bottom: 3rem;">
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 class="section-title" style="font-weight: 800; font-size: 1.6rem; color: var(--primary-color);">Fresh Vegetables</h2>
                <a href="javascript:void(0)" class="view-all" style="color: var(--accent-color); text-decoration: none; font-weight: 700;">View All <i class="fa-solid fa-chevron-right ms-1"></i></a>
            </div>
            
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
                @foreach(['Fresh Tomatoes', 'Organic Bananas', 'Whole Wheat Bread', 'Organic Milk'] as $fallbackName)
                <div class="product-card" style="border: 1px solid var(--border-color); border-radius: 1rem; overflow: hidden; background: #fff; padding: 1rem; text-align: center; position: relative;">
                    <div style="background: #f8fafc; height: 160px; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        <i class="fa-solid fa-basket-shopping fa-3x text-muted opacity-20"></i>
                    </div>
                    <span style="font-weight: 800; font-size: 1.15rem; color: var(--accent-color); display: block;">₹99.00</span>
                    <h3 style="font-size: 0.95rem; font-weight: 700; margin: 0.5rem 0;">{{ $fallbackName }}</h3>
                    <button class="cart-add-btn" style="position: absolute; bottom: 10px; right: 10px; width: 36px; height: 36px; border-radius: 50%; background: #f1f5f9; border: none; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- Weekly Combos & Bundles -->
    @if(isset($bundles) && $bundles->count() > 0)
    <div class="department-section" style="margin-bottom: 3rem;">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="section-title" style="font-weight: 800; font-size: 1.6rem; color: var(--primary-color);">Weekly Grocery Combos</h2>
            <a href="{{ route('v3.combos') }}" class="view-all" style="color: var(--accent-color); text-decoration: none; font-weight: 700; font-size: 0.9rem;">View All <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
        
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
            @forelse($bundles as $bundle)
                <div class="product-card" style="border: 1px solid var(--border-color); border-radius: 1rem; overflow: hidden; background: #fff; position: relative;">
                    <a href="{{ route('v3.combo', ['id' => $bundle->id]) }}" class="card-img" style="display: block; position: relative; padding-top: 100%; background: #f8fafc;">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($bundle->image) }}" alt="{{ $bundle->title }}" onerror="this.src='{{ asset('Images/placeholder-grocery.webp') }}'" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 10px; right: 10px; background: #10b981; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                            Save Bundle
                        </div>
                    </a>
                    <div class="card-info" style="padding: 1rem; display: flex; flex-direction: column; gap: 0.25rem;">
                        <span class="p-price" style="font-weight: 800; font-size: 1.15rem; color: var(--accent-color);">₹{{ number_format($bundle->total_price, 2) }}</span>
                        <a href="{{ route('v3.combo', ['id' => $bundle->id]) }}" class="p-name" style="font-weight: 700; font-size: 0.95rem; color: var(--primary-color); text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.6rem;">{{ $bundle->title }}</a>
                        <span class="p-meta" style="font-size: 0.75rem; color: var(--text-muted);">{{ $bundle->products->count() }} Products Included</span>
                    </div>
                    <button class="cart-add-btn" data-product-id="{{ $bundle->id }}" data-type="bundle" style="position: absolute; bottom: 10px; right: 10px; width: 36px; height: 36px; border-radius: 50%; background: #f1f5f9; border: none; display: flex; align-items: center; justify-content: center; color: var(--primary-color); cursor: pointer;">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            @empty
                <!-- No Bundles -->
            @endforelse
        </div>
    </div>
    @endif

    <!-- Newsletter Section -->
    <style>
        .newsletter-input::placeholder {
            color: #94a3b8 !important;
        }
    </style>
    <div class="newsletter-section" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; padding: 4rem 2rem; border-radius: 2rem; text-align: center; margin-bottom: 2rem;">
        <div class="newsletter-content" style="max-width: 650px; margin: 0 auto;">
            <h2 class="newsletter-title" style="font-size: 2.2rem; font-weight: 800; margin-bottom: 1rem; font-family: 'Outfit', sans-serif;">Subscribe for Special Offers</h2>
            <p class="newsletter-subtitle" style="font-size: 1rem; color: #94a3b8; margin-bottom: 2rem; line-height: 1.5;">Get updates on new seasonal arrivals, farm harvest schedules, weekly coupons, and grocery discounts straight to your inbox.</p>
            <form class="newsletter-input-group">
                <input type="email" placeholder="Your email address" class="newsletter-input" style="color: var(--primary-color); outline: none;">
                <button type="button" class="newsletter-btn" style="background-color: var(--accent-color); color: #fff;">Subscribe</button>
            </form>
        </div>
    </div>
@endsection
