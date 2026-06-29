@extends('v3.layouts.app')

@section('title', ($title ?? 'Fresh Perfumes') . ' - Nurah Perfumes')

@push('styles')
<style>
    /* Filter Bar */
    .filter-bar {
        background: var(--white);
        padding: 12px 15px;
        display: flex;
        gap: 10px;
        border-bottom: 1px solid var(--border);
    }

    .filter-btn,
    .sort-btn {
        flex: 1;
        padding: 10px 15px;
        background: var(--white);
        border: 2px solid var(--border);
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .filter-btn.active,
    .sort-btn.active {
        border-color: var(--black);
        background: var(--black);
        color: var(--white);
    }

    /* Toast Notification */
    .toast { position: fixed; bottom: 100px; left: 50%; transform: translateX(-50%) translateY(100px); background: var(--black); color: var(--white); padding: 12px 24px; border-radius: 25px; font-weight: 600; font-size: 14px; z-index: 3001; opacity: 0; transition: all 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* Results Bar */
    .results-bar {
        background: var(--white);
        padding: 12px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: var(--text-light);
    }

    .results-count {
        font-weight: 600;
        color: var(--black);
    }

    .view-toggle {
        display: flex;
        gap: 8px;
    }

    .view-btn {
        background: none;
        border: 1px solid var(--border);
        width: 36px;
        height: 36px;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .view-btn.active {
        background: var(--black);
        color: var(--white);
        border-color: var(--black);
    }

    /* Product Grid */
    .products-container {
        padding: 15px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .product-grid.list-view {
        grid-template-columns: 1fr;
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

    .product-card:active .product-image {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: var(--gold);
        color: var(--white);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .favorite-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background: var(--white);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .favorite-btn.active {
        color: #ff3b30;
    }

    .product-info {
        padding: 15px 12px;
        text-align: center;
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
        color: var(--black);
        letter-spacing: -0.3px;
        line-height: 1.3;
    }

    .product-price {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    
    .compare-price {
        font-size: 11px;
        color: var(--text-light);
        text-decoration: line-through;
        font-weight: 500;
    }

    .product-price span {
        font-size: 11px;
        font-weight: 500;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .quick-view-btn {
        width: 100%;
        padding: 10px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .quick-view-btn:hover {
        background: var(--gold);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* List View Styles */
    .product-grid.list-view .product-card {
        display: flex;
        flex-direction: row;
    }

    .product-grid.list-view .product-image-wrapper {
        width: 120px;
        flex-shrink: 0;
    }

    .product-grid.list-view .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 12px;
    }

    /* Bottom Sheet - Filter */
    .bottom-sheet {
        position: fixed;
        bottom: -100%;
        left: 0;
        right: 0;
        background: var(--white);
        border-radius: 20px 20px 0 0;
        box-shadow: 0 -5px 30px rgba(0,0,0,0.2);
        z-index: 200;
        transition: bottom 0.3s ease;
        max-height: 85vh;
        overflow-y: auto;
        max-width: 500px;
        margin: 0 auto;
    }

    .bottom-sheet.active {
        bottom: 0;
    }

    .sheet-header {
        position: sticky;
        top: 0;
        background: var(--white);
        padding: 20px 15px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1;
    }

    .sheet-title {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 700;
    }

    .sheet-close {
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: var(--text-light);
    }

    .sheet-content {
        padding: 20px 15px;
    }

    /* Filter Options */
    .filter-section {
        margin-bottom: 30px;
    }

    .filter-section-title {
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        color: var(--black);
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .filter-options.horizontal {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 15px;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .filter-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .filter-option input:checked + .filter-checkbox {
        background: var(--black);
        border-color: var(--black);
        color: var(--white);
    }

    .filter-label {
        font-size: 14px;
        flex: 1;
    }

    .filter-count-label {
        font-size: 12px;
        color: var(--text-light);
    }

    /* Price Range Slider */
    .price-inputs {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .price-input {
        flex: 1;
        padding: 10px 12px;
        border: 2px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    .price-slider {
        width: 100%;
        height: 6px;
        background: var(--border);
        border-radius: 3px;
        position: relative;
        margin: 20px 0;
    }

    .price-slider-fill {
        position: absolute;
        height: 100%;
        background: var(--black);
        border-radius: 3px;
    }

    /* Sheet Actions */
    .sheet-actions {
        position: sticky;
        bottom: 0;
        background: var(--white);
        padding: 15px;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 10px;
    }

    .clear-btn {
        flex: 1;
        padding: 14px;
        background: var(--white);
        border: 2px solid var(--black);
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .apply-btn {
        flex: 2;
        padding: 14px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        cursor: pointer;
    }

    /* Sort Options */
    .sort-options {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .sort-option {
        padding: 18px 15px;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
    }

    .sort-option:last-child {
        border-bottom: none;
    }

    .sort-option.active {
        background: var(--bg-light);
        font-weight: 700;
        color: var(--black);
    }

    .sort-check {
        font-size: 18px;
        color: var(--gold);
    }

    /* Overlay */
    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        z-index: 199;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .overlay.active {
        opacity: 1;
        pointer-events: all;
    }

    /* Load More */
    .load-more-container {
        padding: 20px 15px;
        text-align: center;
    }

    .load-more-btn {
        padding: 14px 40px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        cursor: pointer;
        letter-spacing: 0.5px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .empty-text {
        font-size: 14px;
        color: var(--text-light);
        margin-bottom: 20px;
    }

    .reset-filters-btn {
        padding: 12px 30px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        cursor: pointer;
    }

    /* Features */
    .features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 50px 20px;
        border-top: 1px solid var(--border);
        text-align: center;
        background: var(--white);
        margin-top: 30px;
    }

    .feature-icon {
        font-size: 32px;
        margin-bottom: 15px;
    }

    .feature-title {
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--black);
    }

    .feature-text {
        font-size: 12px;
        color: var(--text-light);
        line-height: 1.5;
        padding: 0 10px;
    }

    @media (max-width: 768px) {
        .features {
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 30px 10px;
        }
        
        .feature-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .feature-title {
            font-size: 10px;
            margin-bottom: 5px;
        }

        .feature-text {
            font-size: 9px;
            line-height: 1.3;
            padding: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-card {
        animation: fadeIn 0.4s ease forwards;
    }

    /* Loading State */
    .loading {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid var(--border);
        border-top-color: var(--black);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Quick View Modal */
    .quick-view-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 3000;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        padding: 20px;
    }

    .quick-view-modal.active {
        opacity: 1;
        pointer-events: all;
    }

    .qv-content {
        background: var(--white);
        width: 100%;
        max-width: 800px;
        border-radius: 20px;
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr;
        position: relative;
        transform: translateY(20px);
        transition: transform 0.3s ease;
        max-height: 90vh;
        overflow-y: auto;
    }

    .quick-view-modal.active .qv-content {
        transform: translateY(0);
    }

    .qv-image-container {
        width: 100%;
        aspect-ratio: 1;
        background: var(--bg-light);
    }

    .qv-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .qv-details {
        padding: 30px;
        display: flex;
        flex-direction: column;
    }

    .qv-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--white);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 10;
        color: var(--black);
    }

    .qv-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--black);
    }

    .qv-price {
        font-size: 20px;
        font-weight: 700;
        color: var(--gold);
        margin-bottom: 20px;
    }

    .qv-description {
        font-size: 14px;
        line-height: 1.6;
        color: var(--text-light);
        margin-bottom: 25px;
    }

    .qv-add-btn {
        background: var(--black);
        color: var(--white);
        border: none;
        padding: 15px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background 0.3s;
        width: 100%;
        margin-top: auto;
    }

    .qv-add-btn:hover {
        background: var(--gold);
    }

    @media (min-width: 768px) {
        .qv-content {
            grid-template-columns: 1fr 1fr;
        }
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .products-container, .filter-bar, .results-bar, .page-header {
            max-width: 1200px;
            margin: 0 auto;
        }

        .filter-bar {
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
    }

    @media (min-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Out of Stock Styles */
    .btn-blurred {
        filter: blur(2px);
        opacity: 0.6;
        pointer-events: none;
        user-select: none;
    }
    
    .out-of-stock-badge {
        position: absolute;
        bottom: 25px; /* Adjust based on button position */
        left: 50%;
        transform: translateX(-50%);
        background: #000;
        color: #fff;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 4px;
        z-index: 10;
        white-space: nowrap;
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
    <div class="page-header" style="padding: 15px; text-align: center;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700;">{{ $title ?? 'Fresh Perfumes' }}</h1>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <button class="filter-btn" onclick="openFilters()">
            <span><i class="fas fa-sliders-h"></i></span>
            <span>Filter</span>
            <span class="filter-count" id="filterCount" style="display: none;">0</span>
        </button>
        <button class="sort-btn" onclick="openSort()">
            <span><i class="fas fa-sort"></i></span>
            <span>Sort</span>
        </button>
    </div>

    <!-- Results Bar -->
    <!-- <div class="results-bar">
        <div>
            <span class="results-count" id="resultsCount">11</span> Products
        </div>
        <div class="view-toggle">
            <button class="view-btn active" onclick="setView('grid')">⊞</button>
            <button class="view-btn" onclick="setView('list')">☰</button>
        </div>
    </div> -->

    <!-- Products Grid -->
    <div class="products-container">
        <div class="product-grid" id="productGrid">
            @forelse($products as $product)
            @php
                $sizes = $product->variants->pluck('size')->map(fn($s) => strtolower($s))->implode(',');
                $stock = $product->variants->sum('stock') > 0 ? 1 : 0;
                $gender = strtolower($product->gender); 
                if($gender == 'men' || $gender == 'man') $gender = 'him';
                if($gender == 'women' || $gender == 'woman') $gender = 'her';
            @endphp
            <a href="{{ route('v3.product', ['id' => $product->id]) }}" class="product-card" 
               data-name="{{ $product->title }}" 
               data-price="{{ $product->starting_price }}" 
               data-date="{{ $product->created_at->timestamp }}" 
               data-stock="{{ $stock }}" 
               data-gender="{{ $gender }}"
               data-sizes="{{ $sizes }}">
               
                <div class="product-image-wrapper">
                    <!-- <button class="favorite-btn" onclick="toggleFavorite(event, this)"><i class="far fa-heart"></i></button> -->
                    
                    @if($product->created_at->diffInDays(now()) < 7)
                        <span class="product-badge">New</span>
                    @endif
                    
                    @if($product->main_image_url)
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->title }}" class="product-image" onerror="handleImageError(this)">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-secondary">
                            <i class="fas fa-image fa-2x opacity-25"></i>
                        </div>
                    @endif

                    <div class="social-proof-tag">
                        <i class="fas fa-fire"></i>
                        <span>{{ rand(20, 150) }} bought this week</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->title }}</h3>
                    <p class="product-price">
                        @if($product->compare_at_price > $product->starting_price)
                            <span class="compare-price">₹{{ number_format($product->compare_at_price, 0) }}</span>
                        @endif
                        <span>From</span> ₹{{ number_format($product->starting_price, 0) }}
                    </p>
                    <button class="quick-view-btn {{ $stock == 0 ? 'btn-blurred' : '' }}" 
                            onclick="{{ $stock == 0 ? 'return false;' : 'addToCart(event, ' . $product->id . ', \'' . addslashes($product->title) . '\')' }}"
                            {{ $stock == 0 ? 'disabled' : '' }}>
                        {{ $stock == 0 ? 'Out of Stock' : 'Add to Cart' }}
                    </button>
                    @if($stock == 0)
                        <div class="out-of-stock-badge">Out of Stock</div>
                    @endif
                </div>
            </a>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-25"></i>
                <p class="text-muted">No products found.</p>
            </div>
            @endforelse
        </div>

        <!-- Load More -->
        <!-- <div class="load-more-container">
            <button class="load-more-btn">Load More</button>
        </div> -->
    </div>

    <!-- Features -->
    <div class="features">
        <div class="feature">
            <div class="feature-icon"><i class="fas fa-truck"></i></div>
            <h3 class="feature-title">Free Shipping</h3>
            <p class="feature-text">Free shipping on orders above ₹399 across India</p>
        </div>

        <div class="feature">
            <div class="feature-icon"><i class="fas fa-undo"></i></div>
            <h3 class="feature-title">Easy Returns</h3>
            <p class="feature-text">Simple return process with the perfumes</p>
        </div>

        <div class="feature">
            <div class="feature-icon"><i class="fas fa-lock"></i></div>
            <h3 class="feature-title">Secure Payment</h3>
            <p class="feature-text">Your payment information is processed securely</p>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="closeSheets()"></div>

    <!-- Filter Bottom Sheet -->
    <div class="bottom-sheet" id="filterSheet">
        <div class="sheet-header">
            <h2 class="sheet-title">Filters</h2>
            <button class="sheet-close" onclick="closeSheets()">×</button>
        </div>
        <div class="sheet-content">
            <!-- Price Filter -->
            <div class="filter-section">
                <div class="filter-section-title">Price Range</div>
                <div class="price-inputs">
                    <input type="number" class="price-input" placeholder="Min ₹" value="929">
                    <input type="number" class="price-input" placeholder="Max ₹" value="1279">
                </div>
            </div>

            <!-- Availability -->
            <div class="filter-section">
                <div class="filter-section-title">Availability</div>
                <div class="filter-options">
                    <label class="filter-option">
                        <input type="checkbox" style="display: none;">
                        <div class="filter-checkbox"></div>
                        <span class="filter-label">In Stock</span>
                        <span class="filter-count-label">(11)</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" style="display: none;">
                        <div class="filter-checkbox"></div>
                        <span class="filter-label">Out of Stock</span>
                        <span class="filter-count-label">(0)</span>
                    </label>
                </div>
            </div>

            <!-- Gender -->
            <div class="filter-section">
                <div class="filter-section-title">Gender</div>
                <div class="filter-options horizontal">
                    <label class="filter-option">
                        <input type="checkbox" style="display: none;">
                        <div class="filter-checkbox"></div>
                        <span class="filter-label">For Him</span>
                        <span class="filter-count-label">(8)</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" style="display: none;">
                        <div class="filter-checkbox"></div>
                        <span class="filter-label">For Her</span>
                        <span class="filter-count-label">(2)</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" style="display: none;">
                        <div class="filter-checkbox"></div>
                        <span class="filter-label">Unisex</span>
                        <span class="filter-count-label">(1)</span>
                    </label>
                </div>
            </div>

            <!-- Size -->
            <div class="filter-section">
                <div class="filter-section-title">Size</div>
                <div class="filter-options horizontal">
                    <label class="filter-option">
                        <input type="checkbox" style="display: none;">
                        <div class="filter-checkbox"></div>
                        <span class="filter-label">50ml</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" style="display: none;">
                        <div class="filter-checkbox"></div>
                        <span class="filter-label">100ml</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="sheet-actions">
            <button class="clear-btn" onclick="clearFilters()">Clear All</button>
            <button class="apply-btn" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>

    <!-- Sort Bottom Sheet -->
    <div class="bottom-sheet" id="sortSheet">
        <div class="sheet-header">
            <h2 class="sheet-title">Sort By</h2>
            <button class="sheet-close" onclick="closeSheets()">×</button>
        </div>
        <div class="sheet-content">
            <div class="sort-options">
                <div class="sort-option active" onclick="selectSort(this, 'best-selling')">
                    <span>Best Selling</span>
                    <span class="sort-check">✓</span>
                </div>
                <div class="sort-option" onclick="selectSort(this, 'featured')">
                    <span>Featured</span>
                </div>
                <div class="sort-option" onclick="selectSort(this, 'price-asc')">
                    <span>Price: Low to High</span>
                </div>
                <div class="sort-option" onclick="selectSort(this, 'price-desc')">
                    <span>Price: High to Low</span>
                </div>
                <div class="sort-option" onclick="selectSort(this, 'alpha-asc')">
                    <span>Alphabetically: A-Z</span>
                </div>
                <div class="sort-option" onclick="selectSort(this, 'alpha-desc')">
                    <span>Alphabetically: Z-A</span>
                </div>
                <div class="sort-option" onclick="selectSort(this, 'date-new')">
                    <span>Date: New to Old</span>
                </div>
                <div class="sort-option" onclick="selectSort(this, 'date-old')">
                    <span>Date: Old to New</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="quick-view-modal" id="quickViewModal">
        <div class="qv-content">
            <button class="qv-close" onclick="closeQuickView()">×</button>
            <div class="qv-image-container">
                <img src="" alt="Product" class="qv-image" id="qvImage">
            </div>
            <div class="qv-details">
                <h2 class="qv-title" id="qvTitle">Product Name</h2>
                <div class="qv-price" id="qvPrice">₹0</div>
                <p class="qv-description">Experience the essence of luxury with this exquisite fragrance. Designed for long-lasting appeal and perfect for any occasion.</p>
                <button class="qv-add-btn">Add to Cart</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">Added to cart! 🎉</div>

<script>
    // Image Fallback
    function handleImageError(img) {
        if (!img.getAttribute('data-error-handled')) {
            img.setAttribute('data-error-handled', 'true');
            img.src = '{{ asset("Images/g-load.webp") }}';
        }
    }

    // Open/Close Sheets
    function openFilters() {
        console.log('Opening filters');
        const sheet = document.getElementById('filterSheet');
        const overlay = document.getElementById('overlay');
        if(sheet) sheet.classList.add('active');
        if(overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function openSort() {
        console.log('Opening sort');
        const sheet = document.getElementById('sortSheet');
        const overlay = document.getElementById('overlay');
        if(sheet) sheet.classList.add('active');
        if(overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSheets() {
        document.querySelectorAll('.bottom-sheet').forEach(sheet => {
            sheet.classList.remove('active');
        });
        const overlay = document.getElementById('overlay');
        if(overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // View Toggle
    function setView(view) {
        const grid = document.getElementById('productGrid');
        const viewBtns = document.querySelectorAll('.view-btn');
        
        viewBtns.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');
        
        if (view === 'list') {
            grid.classList.add('list-view');
        } else {
            grid.classList.remove('list-view');
        }
    }

    // Favorite Toggle
    function toggleFavorite(event, btn) {
        event.preventDefault();
        event.stopPropagation();
        btn.classList.toggle('active');
        btn.textContent = btn.classList.contains('active') ? '♥' : '♡';
        
        // Haptic feedback
        if (navigator.vibrate) {
            navigator.vibrate(30);
        }
    }

    // Quick View
    function quickView(event) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        
        const card = event.target.closest('.product-card');
        const imageSrc = card.querySelector('.product-image').src;
        const title = card.querySelector('.product-name').textContent;
        const price = card.querySelector('.product-price').innerHTML;

        document.getElementById('qvImage').src = imageSrc;
        document.getElementById('qvTitle').textContent = title;
        document.getElementById('qvPrice').innerHTML = price;
        
        const modal = document.getElementById('quickViewModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeQuickView() {
        document.getElementById('quickViewModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close on outside click
    document.getElementById('quickViewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeQuickView();
        }
    });

    // Filter Functions
    function clearFilters() {
        document.querySelectorAll('.filter-option input').forEach(input => {
            input.checked = false;
        });
        document.querySelectorAll('.price-input').forEach((input, index) => {
            input.value = index === 0 ? '' : '';
        });
        updateFilterCount();
        // Reset to show all
        document.querySelectorAll('.product-card').forEach(card => card.style.display = '');
        closeSheets();
    }

    function applyFilters() {
        const minPrice = parseInt(document.querySelector('.price-input[placeholder="Min ₹"]').value) || 0;
        const maxPrice = parseInt(document.querySelector('.price-input[placeholder="Max ₹"]').value) || 100000;
        
        // Get selected checkboxes
        const stockFilters = [];
        const genderFilters = [];
        
        // Note: This relies on specific structure. Ideally we'd give inputs IDs or specific data attrs.
        // Assuming order: Stock (In, Out), Gender (Him, Her, Unisex)
        const checkboxes = document.querySelectorAll('.filter-option input');
        
        // Availability
        if(checkboxes[0] && checkboxes[0].checked) stockFilters.push('1'); // In Stock
        if(checkboxes[1] && checkboxes[1].checked) stockFilters.push('0'); // Out of Stock
        
        // Gender
        if(checkboxes[2] && checkboxes[2].checked) genderFilters.push('him');
        if(checkboxes[3] && checkboxes[3].checked) genderFilters.push('her');
        if(checkboxes[4] && checkboxes[4].checked) genderFilters.push('unisex');

        document.querySelectorAll('.product-card').forEach(card => {
            const price = parseInt(card.dataset.price);
            const stock = card.dataset.stock;
            const gender = card.dataset.gender;
            
            let visible = true;
            
            // Price Check
            if (price < minPrice || price > maxPrice) visible = false;
            
            // Stock Check (if any selected)
            if (stockFilters.length > 0 && !stockFilters.includes(stock)) visible = false;
            
            // Gender Check (if any selected)
            if (genderFilters.length > 0 && !genderFilters.includes(gender)) visible = false;
            
            card.style.display = visible ? '' : 'none';
        });

        updateFilterCount();
        closeSheets();
    }

    function updateFilterCount() {
        const checkedCount = document.querySelectorAll('.filter-option input:checked').length;
        const countBadge = document.getElementById('filterCount');
        if (checkedCount > 0) {
            countBadge.textContent = checkedCount;
            countBadge.style.display = 'flex';
        } else {
            countBadge.style.display = 'none';
        }
    }

    // Sort Selection
    function selectSort(option, type) {
        document.querySelectorAll('.sort-option').forEach(opt => {
            opt.classList.remove('active');
            opt.querySelector('.sort-check')?.remove();
        });
        
        option.classList.add('active');
        const check = document.createElement('span');
        check.className = 'sort-check';
        check.innerHTML = '<i class="fas fa-check"></i>';
        option.appendChild(check);
        
        sortGrid(type);
        setTimeout(() => closeSheets(), 300);
    }
    
    function sortGrid(type) {
        const grid = document.getElementById('productGrid');
        const cards = Array.from(grid.children);
        
        cards.sort((a, b) => {
            switch(type) {
                case 'price-asc':
                    return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                case 'price-desc':
                    return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                case 'alpha-asc':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'alpha-desc':
                    return b.dataset.name.localeCompare(a.dataset.name);
                case 'best-selling':
                default:
                    // Use date/index as proxy for default/best-selling for now
                    return parseInt(a.dataset.date) - parseInt(b.dataset.date);
            }
        });
        
        cards.forEach(card => grid.appendChild(card));
    }

    // Checkbox Toggle
    document.querySelectorAll('.filter-option').forEach(option => {
        const checkbox = option.querySelector('input');
        const visual = option.querySelector('.filter-checkbox');
        
        option.addEventListener('click', (e) => {
            if (e.target.tagName === 'INPUT') return; // let default handle it
            e.preventDefault();
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                visual.textContent = '✓';
            } else {
                visual.textContent = '';
            }
        });
        
        // Also handle direct clicks on checkbox if not hidden
        checkbox.addEventListener('change', () => {
             if (checkbox.checked) {
                visual.textContent = '✓';
            } else {
                visual.textContent = '';
            }
        });
    });

    // Prevent body scroll when sheet is open
    const sheets = document.querySelectorAll('.bottom-sheet');
    sheets.forEach(sheet => {
        sheet.addEventListener('touchmove', (e) => {
            if (e.target.closest('.sheet-content') || e.target.closest('.sheet-header')) {
                return;
            }
            e.preventDefault();
        }, { passive: false });
    });

    // Smooth scroll reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = `${entry.target.dataset.index * 0.05}s`;
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.product-card').forEach((card, index) => {
        card.dataset.index = index;
        observer.observe(card);
    });
    // Add to Cart
    function addToCart(event, id, title) {
        event.preventDefault();
        event.stopPropagation();
        
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '...';
        
        const quantity = 1;

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id,
                quantity: quantity,
                size: null // Default/No size
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const toast = document.getElementById('toast');
                if(toast) {
                    toast.textContent = (title || 'Item') + ' added to cart!';
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 2500);
                }
                
                // Update badge
                const cartBadge = document.querySelector('.cart-count'); 
                if(cartBadge) {
                    cartBadge.innerText = data.cartCount;
                    cartBadge.style.display = 'flex';
                }
                
                if(navigator.vibrate) navigator.vibrate(50);
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
@endsection
