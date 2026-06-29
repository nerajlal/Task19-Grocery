@extends('v3.layouts.app')

@section('title', $product->title . ' - Nurah Perfumes')

@push('styles')
<style>
    /* Image Gallery - Mobile Optimized */
    .image-gallery {
        position: relative;
    }

    .main-image-container {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        background: var(--bg-light);
        overflow: hidden;
    }

    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--gold);
        color: var(--white);
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .image-dots {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
    }

    .image-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        border: 1px solid var(--white);
        cursor: pointer;
        transition: all 0.3s;
    }

    .image-dot.active {
        background: var(--white);
        width: 20px;
        border-radius: 3px;
    }

    /* Thumbnail Strip */
    .thumbnail-strip {
        display: flex;
        gap: 8px;
        padding: 12px 15px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .thumbnail-strip::-webkit-scrollbar {
        display: none;
    }

    .thumbnail {
        min-width: 60px;
        height: 60px;
        border-radius: 8px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s;
        object-fit: cover;
    }

    .thumbnail.active {
        border-color: var(--gold);
    }

    /* Product Info Section */
    .product-info {
        padding: 20px 15px;
    }

    .product-header {
        margin-bottom: 20px;
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .product-price {
        font-size: 28px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 12px;
    }

    .rating-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .stars {
        color: #ffc107;
        font-size: 16px;
    }

    .rating-text {
        color: var(--text-light);
    }

    /* Promo Banner */
    .promo-banner {
        background: linear-gradient(135deg, var(--gold) 0%, var(--black) 100%);
        color: var(--white);
        padding: 12px 15px;
        margin: 0 -15px 20px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
    }

    .promo-code {
        font-weight: 800;
        letter-spacing: 1px;
    }

    /* Option Section */
    .option-section {
        margin-bottom: 25px;
    }

    .option-label {
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        display: block;
        color: var(--black);
    }

    /* Size Options - Mobile Optimized */
    .size-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .size-option {
        padding: 12px;
        border: 2px solid var(--border);
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: var(--white);
    }

    .size-option.active {
        border-color: var(--black);
        background: var(--black);
        color: var(--white);
    }

    .size-label {
        font-weight: 700;
        font-size: 14px;
        display: block;
        margin-bottom: 4px;
    }

    .size-price {
        font-size: 12px;
        opacity: 0.8;
    }

    /* Intensity Bar */
    .intensity-container {
        background: var(--bg-light);
        padding: 15px;
        border-radius: 10px;
    }

    .intensity-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
        text-align: center;
    }

    .intensity-bar {
        width: 100%;
        height: 6px;
        background: #ddd;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
    }

    .intensity-fill {
        position: absolute;
        height: 100%;
        background: linear-gradient(90deg, var(--gold) 0%, var(--black) 100%);
        width: 70%;
        border-radius: 3px;
    }

    /* Notes Card */
    .notes-card {
        background: var(--bg-light);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .notes-title {
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        text-align: center;
    }

    .note-item {
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
    }

    .note-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .note-type {
        font-weight: 700;
        font-size: 13px;
        color: var(--black);
        margin-bottom: 4px;
    }

    .note-list {
        font-size: 13px;
        color: var(--text-light);
    }

    /* Personality Image */
    .personality-section {
        margin-bottom: 20px;
    }

    .personality-image {
        width: 100%;
        border-radius: 12px;
        margin-top: 10px;
    }

    /* Quantity Selector - Mobile Touch Friendly */
    .quantity-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        border: 2px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    .qty-btn {
        width: 44px;
        height: 44px;
        border: none;
        background: var(--white);
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--black);
    }

    .qty-display {
        width: 50px;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        border-left: 1px solid var(--border);
        border-right: 1px solid var(--border);
    }

    /* Sticky Bottom Bar */
    .sticky-bottom {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--white);
        padding: 12px 15px;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        z-index: 99;
        display: flex;
        gap: 10px;
    }

    .add-to-cart-btn, .buy-now-btn {
        flex: 1;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .add-to-cart-btn {
        background: var(--white);
        color: var(--black);
        border: 2px solid var(--black);
    }

    .buy-now-btn {
        background: var(--black);
        color: var(--white);
    }

    .add-to-cart-btn:active {
        transform: scale(0.98);
    }

    /* Share Section */
    .share-section {
        padding: 20px 15px;
        border-top: 1px solid var(--border);
        margin-top: 20px;
    }

    .share-title {
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .share-buttons {
        display: flex;
        gap: 10px;
    }

    .share-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
    }

    /* Product Details Accordion */
    .details-section {
        padding: 20px 15px;
    }

    .detail-accordion {
        border-bottom: 1px solid var(--border);
    }

    .accordion-header {
        padding: 18px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .accordion-title {
        font-weight: 700;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .accordion-icon {
        font-size: 20px;
        transition: transform 0.3s;
    }

    .accordion-header.active .accordion-icon {
        transform: rotate(180deg);
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .accordion-content.active {
        max-height: 1000px;
        padding-bottom: 18px;
    }

    .accordion-text {
        font-size: 14px;
        line-height: 1.7;
        color: var(--text);
    }

    .detail-highlight {
        background: var(--bg-light);
        padding: 15px;
        border-radius: 10px;
        margin: 15px 0;
        text-align: center;
    }

    .highlight-badge {
        display: inline-block;
        background: var(--black);
        color: var(--white);
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .highlight-text {
        font-size: 14px;
        line-height: 1.6;
    }

    /* Reviews Section */
    .reviews-section {
        padding: 20px 15px;
        background: var(--bg-light);
    }

    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .reviews-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
    }

    .reviews-summary {
        text-align: center;
        margin-bottom: 20px;
        padding: 20px;
        background: var(--white);
        border-radius: 12px;
    }

    .review-score {
        font-size: 42px;
        font-weight: 700;
        color: var(--black);
        line-height: 1;
    }

    .review-stars {
        color: #ffc107;
        font-size: 20px;
        margin: 8px 0;
    }

    .review-count {
        font-size: 13px;
        color: var(--text-light);
    }

    .review-card {
        background: var(--white);
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 12px;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 10px;
    }

    .reviewer-name {
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .review-stars-small {
        color: #ffc107;
        font-size: 14px;
    }

    .review-text {
        font-size: 14px;
        line-height: 1.6;
        color: var(--text);
    }

    .review-label {
        font-weight: 700;
        margin-bottom: 5px;
    }

    /* FAQ Section */
    .faq-section {
        padding: 20px 15px;
    }

    .faq-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .faq-item {
        border-bottom: 1px solid var(--border);
        padding: 18px 0;
    }

    .faq-question {
        display: flex;
        justify-content: space-between;
        align-items: start;
        cursor: pointer;
        gap: 10px;
    }

    .faq-q-text {
        font-weight: 600;
        font-size: 14px;
        line-height: 1.5;
        flex: 1;
    }

    .faq-toggle {
        font-size: 20px;
        font-weight: 300;
        min-width: 20px;
        transition: transform 0.3s;
    }

    .faq-question.active .faq-toggle {
        transform: rotate(45deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .faq-answer.active {
        max-height: 500px;
        padding-top: 12px;
    }

    .faq-answer-text {
        font-size: 13px;
        line-height: 1.7;
        color: var(--text-light);
    }

    /* Footer Spacing */
    .footer-spacer {
        height: 80px;
    }

    /* Loading Animation */
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

    .animate-in {
        animation: fadeIn 0.5s ease forwards;
    }

    /* Toast Notification */
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

    /* Responsive - Tablet */
    @media (min-width: 768px) {
        .product-info {
            max-width: 600px;
            margin: 0 auto;
        }

        .main-image-container {
            max-width: 600px;
            margin: 0 auto;
        }
    }

    /* Desktop Layout Enhancements */
    @media (min-width: 900px) {
        .product-main-wrapper {
            display: grid;
            grid-template-columns: 1.2fr 1fr; /* 55% 45% ratio approx */
            gap: 40px;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            align-items: start;
        }

        .product-gallery-column {
            position: sticky;
            top: 20px;
        }

        .main-image-container {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            max-width: 100%; /* Reset max-width from previous CSS */
            aspect-ratio: auto; /* Allow natural height if needed, or keep 1 */
        }

        .thumbnail-strip {
            justify-content: center;
            margin-top: 20px;
        }

        .product-info-column {
            padding-top: 10px;
        }

        .product-info {
            max-width: 100%; /* Reset max-width */
            padding: 0;
        }

        .product-name {
            font-size: 42px;
        }

        .sticky-bottom {
            position: relative;
            box-shadow: none;
            padding: 20px 0;
            background: transparent;
            width: 100%;
            max-width: 100%;
            left: auto;
            right: auto;
            transform: none;
            bottom: auto;
            margin-top: 30px;
            border-top: 1px solid var(--border);
        }

        .add-to-cart-btn, .buy-now-btn {
            padding: 18px;
            font-size: 16px;
        }

        /* Hide mobile-only elements on desktop if needed */
        .mobile-header-back {
            display: none !important;
        }
        
        .footer-spacer {
            display: none;
        }
    }

    /* Related Products CSS - Copied from All Products Style */
    .related-products-section {
        margin-top: 40px;
        padding-bottom: 20px;
        background: var(--white);
    }
    

    
    /* Product Card Styles (Ported) */
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
        width: 100%;
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

    .product-card:active .product-image,
    .product-card:hover .product-image {
        transform: scale(1.05); /* Zoom effect */
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
        color: var(--black);
        padding: 0;
        line-height: 1;
        z-index: 2;
    }

    .favorite-btn.active {
        color: #ff3b30;
    }

    /* Override .product-info from main page for cards specifically if needed, 
       but standard class works if we scope or ensure logic matches */
    .product-card .product-info {
        padding: 12px;
        text-align: left;
    }

    .product-card .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        font-weight: 700;
        color: var(--black);
        margin: 0 0 6px 0;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-card .product-price {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 10px 0;
    }

    .quick-view-btn {
        width: 100%;
        padding: 8px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .related-scroll-container {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        padding: 0 10px 40px;
        width: 100%;
        box-sizing: border-box;
    }

    /* ... existing styles ... */

    @media (min-width: 768px) {
        .related-scroll-container {
             grid-template-columns: repeat(3, 1fr);
             gap: 20px;
        }
    }

    @media (min-width: 1024px) {
        .related-products-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .related-scroll-container {
             grid-template-columns: repeat(4, 1fr);
        }

        .product-card {
            min-width: 0;
            max-width: none;
        }

        .quick-view-btn {
            padding: 10px;
        }
    }
</style>
@endpush

@section('content')

    <!-- Mini Header with Back Button (Mobile Only) -->
    <div class="mobile-header-back" style="background:var(--white); padding:10px 15px; display:flex; align-items:center; gap:10px; border-bottom:1px solid #eee;">
        <button onclick="history.back()" style="border:none; background:none; font-size:24px; cursor:pointer;">←</button>
        <span style="font-family:'Playfair Display',serif; font-weight:700; font-size:18px;">Product Details</span>
    </div>

    <div class="product-main-wrapper">
        <!-- Left Column: Gallery -->
        <div class="product-gallery-column">
            <div class="image-gallery">
                <div class="main-image-container">
                    @if($product->created_at->diffInDays(now()) < 7)
                    <span class="image-badge">New</span>
                    @endif
                    <img src="{{ $product->main_image_url }}" alt="{{ $product->title }}" class="main-image" id="mainImage">
                </div>
                <div class="thumbnail-strip">
                    @foreach($product->images as $index => $image)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($image->path) }}" 
                         data-full-img="{{ \Illuminate\Support\Facades\Storage::url($image->path) }}" 
                         class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                         onclick="changeImage(this, {{ $index }})" 
                         alt="{{ $product->title }} View {{ $index + 1 }}">
                    @endforeach
                </div>
            </div>
            
            <!-- Desktop-only details that fit well on left side potentially, keeping it simple for now -->
        </div>

        <!-- Right Column: Product Info -->
        <div class="product-info-column">
            <div class="product-info">
                <div class="product-header">
                    <h1 class="product-name">{{ $product->title }}</h1>
                    <div class="product-price" id="productPrice">
                        @if(isset($product->compare_at_price) && $product->compare_at_price > $product->starting_price)
                            <span class="compare-price" style="text-decoration: line-through; color: #999; font-size: 0.8em; margin-right: 8px;">₹{{ number_format($product->compare_at_price, 0) }}</span>
                        @endif
                        <span class="current-price">₹{{ number_format($product->starting_price, 0) }}</span>
                    </div>

                </div>

                <!-- Promo Banner -->
                @if(isset($coupon))
                <div class="promo-banner">
                    Use code <span class="promo-code">{{ $coupon->code }}</span> for an extra {{ $coupon->type == 'percentage' ? number_format($coupon->value) . '%' : '₹' . number_format($coupon->value) }} OFF!
                </div>
                @endif

                @if(isset($bundle))
                <a href="{{ route('v3.combo', ['id' => $bundle->id]) }}" style="text-decoration: none; display: block; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <div class="promo-banner" style="background: linear-gradient(135deg, #1a1a1a 0%, #4a4a4a 100%); margin-top: 10px; color: white; display: flex; justify-content: space-between; align-items: center; padding-right: 15px;">
                        <span>Combo Offer: Buy as combo and save {{ $bundle->discount_type == 'percentage' ? number_format($bundle->discount_value) . '%' : '₹' . number_format($bundle->discount_value) }} !</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                @endif

                <!-- Size Selection -->
                <div class="option-section">
                    <label class="option-label">Select Size</label>
                    <div class="size-options">
                        @foreach($product->variants as $index => $variant)
                        <div class="size-option {{ $index === 0 ? 'active' : '' }}" 
                             data-price="{{ $variant->price }}" 
                             data-compare-at-price="{{ $variant->compare_at_price ?? '' }}"
                             onclick="selectSize(this)">
                            <span class="size-label">{{ $variant->size }}</span>
                            <span class="size-price">₹{{ number_format($variant->price, 0) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Intensity -->
                <div class="option-section">
                    <label class="option-label">Intensity</label>
                    <div class="intensity-container">
                        <div class="intensity-label">{{ $product->intensity ?? 'Medium' }}</div>
                        <div class="intensity-bar">
                            @php
                                $intensity = strtolower($product->intensity ?? 'medium');
                                $width = '60%'; // Default Medium
                                if(str_contains($intensity, 'strong') || str_contains($intensity, 'high')) $width = '100%';
                                elseif(str_contains($intensity, 'light') || str_contains($intensity, 'low')) $width = '30%';
                            @endphp
                            <div class="intensity-fill" style="width: {{ $width }}"></div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="notes-card">
                    <div class="notes-title">Notes & Composition</div>
                    @if($product->notes_top)
                    <div class="note-item">
                        <div class="note-type">▲ Top Notes</div>
                        <div class="note-list">{{ $product->notes_top }}</div>
                    </div>
                    @endif
                    @if($product->notes_heart)
                    <div class="note-item">
                        <div class="note-type">■ Middle Notes</div>
                        <div class="note-list">{{ $product->notes_heart }}</div>
                    </div>
                    @endif
                    @if($product->notes_base)
                    <div class="note-item">
                        <div class="note-type">▼ Base Notes</div>
                        <div class="note-list">{{ $product->notes_base }}</div>
                    </div>
                    @endif
                </div>


                <!-- Quantity -->
                <div class="quantity-section">
                    <label class="option-label" style="margin: 0;">Quantity</label>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="decreaseQty()">−</button>
                        <div class="qty-display" id="quantity">1</div>
                        <button class="qty-btn" onclick="increaseQty()">+</button>
                    </div>
                </div>

                 <!-- Action Buttons (Moved inside flow for desktop) -->
                 <div class="sticky-bottom">
                    <button class="add-to-cart-btn" onclick="addToCart()">
                        Add to Cart
                    </button>
                    <button class="buy-now-btn" onclick="window.location.href='{{ route('v3.checkout') }}'">
                        Buy Now
                    </button>
                </div>

                <!-- Product Details Accordion -->
                <div class="details-section">
                    <div class="detail-accordion">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span class="accordion-title">Description</span>
                            <span class="accordion-icon">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-text">
                                <strong>{{ $product->olfactory_family }}</strong>
                                <br><br>
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="detail-accordion">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span class="accordion-title">Key Features</span>
                            <span class="accordion-icon">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="detail-highlight">
                                <span class="highlight-badge">{{ $product->oil_concentration }}% Oil Concentration</span>
                                <p class="highlight-text">Experience the captivating scent that has been reformulated for the Indian tropical weather.</p>
                            </div>
                            <div class="accordion-text">
                            <div class="accordion-text">
                                <!-- Dynamic features to be added later -->
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-accordion">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span class="accordion-title">Shipping & Returns</span>
                            <span class="accordion-icon">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-text">
                                <strong>Shipping:</strong><br>
                                • Free shipping on orders above ₹399<br>
                                • Delivery within 4-10 business days<br>
                                • Order tracking available<br><br>
                                <strong>Returns:</strong><br>
                                • 14-day return policy<br>
                                • Product must be unused and in original packaging<br>
                                • Sale items are non-returnable
                            </div>
                        </div>
                    </div>
                </div>



                <!-- FAQs -->
                <div class="faq-section">
                    <h2 class="faq-title">Frequently Asked</h2>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="faq-q-text">How to make perfumes last longer?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-text">
                                First tip: Moisturize your skin before applying perfume. Dry skin tends to absorb scent faster, so using an unscented moisturizer or even a little Vaseline on your pulse points helps lock in the fragrance. Store your perfumes away from direct sunlight and heat.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="faq-q-text">Can women use men's perfumes?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-text">
                                Fragrance knows no gender. Some scents might appeal more to the opposite sex, but really, it's all about what you love. Pick the perfume that makes you feel great.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="faq-q-text">What is the right way of applying perfume?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-text">
                                Apply a moisturiser or vaseline on the skin prior to wearing a perfume. Spritz the perfume on warm points of your body and give it a moment to soak in and settle.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span class="faq-q-text">Are Nurah Perfumes long-lasting?</span>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-text">
                                Yes, Nurah Perfumes are seriously long-lasting! We source our perfume oils straight from Europe and reformulated each scent with 50% oil concentration — specially made to thrive in tropical weather.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-products-section">
        <h2 class="reviews-title" style="margin: 0 0 20px 20px; font-size: 20px;">Recently Viewed</h2>
        <div class="related-scroll-container">
            @forelse($relatedProducts as $related)
            <div class="product-card" onclick="window.location.href='{{ route('v3.product', ['id' => $related->id]) }}'">
                <div class="product-image-wrapper">
                    <button class="favorite-btn" onclick="event.stopPropagation(); toggleFavorite(this)">♡</button>
                    @if($related->created_at->diffInDays(now()) < 7)
                    <span class="product-badge">New</span>
                    @endif
                    <img src="{{ $related->main_image_url }}" class="product-image" alt="{{ $related->title }}">
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $related->title }}</h3>
                    <p class="product-price">₹{{ number_format($related->starting_price, 0) }}</p>
                    <button class="quick-view-btn" onclick="event.stopPropagation(); addToCart()">Add to Cart</button>
                </div>
            </div>
            @empty
            <div style="padding: 20px; text-align: center; width: 100%; color: var(--text-light);">
                No other products viewed yet.
            </div>
            @endforelse
    </div>

    <!-- Footer Spacer -->
    <div class="footer-spacer"></div>

    <!-- Mobile Sticky Bottom Bar (Only visible on mobile due to desktop CSS override) -->
    <!-- Note: We moved the buttons inside .product-info-column for desktop, 
         but on mobile we might want them fixed. 
         With the current CSS for desktop .sticky-bottom, it transforms into a static block.
         On mobile, it keeps original fixed styles. Good. 
    -->

    <!-- Toast Notification -->
    <div class="toast" id="toast">Added to cart! 🎉</div>

@endsection

@push('scripts')
<script>
(function() {
    // State variables
    let currentImageIndex = 0;
    let quantity = 1;
    let currentPrice = {{ $product->starting_price }};
    let currentCompareAtPrice = {{ $product->compare_at_price ?? 0 }};

    // Helper: Update Price Display
    function updatePrice() {
        const total = currentPrice * quantity;
        const productPriceEl = document.getElementById('productPrice');
        const cartPriceEl = document.getElementById('cartPrice');
        
        if (productPriceEl) {
            let priceHtml = '';
            if (currentCompareAtPrice > currentPrice) {
                priceHtml += `<span class="compare-price" style="text-decoration: line-through; color: #999; font-size: 0.8em; margin-right: 8px;">Rs. ${currentCompareAtPrice.toLocaleString()}.00</span>`;
            }
            priceHtml += `<span class="current-price">Rs. ${currentPrice.toLocaleString()}.00</span>`;
            
            productPriceEl.innerHTML = priceHtml;
        }
        if (cartPriceEl) {
            cartPriceEl.textContent = `₹${total.toLocaleString()}`;
        }
    }

    // Expose functions to window
    window.changeImage = function(thumbnail, index) {
        const mainImage = document.getElementById('mainImage');
        const gallery = document.querySelector('.image-gallery');
        
        if (!mainImage || !gallery) return;

        const thumbnails = gallery.querySelectorAll('.thumbnail');
        const dots = gallery.querySelectorAll('.image-dot');
        const fullImgSrc = thumbnail.getAttribute('data-full-img');

        if (fullImgSrc) {
            mainImage.src = fullImgSrc;
        }
        
        thumbnails.forEach(t => t.classList.remove('active'));
        thumbnail.classList.add('active');

        if (dots.length > index) {
            dots.forEach(d => d.classList.remove('active'));
            dots[index].classList.add('active');
        }

        currentImageIndex = index;
    };

    window.selectSize = function(element) {
        document.querySelectorAll('.size-option').forEach(opt => {
            opt.classList.remove('active');
        });
        element.classList.add('active');

        const price = element.getAttribute('data-price');
        const compareAt = element.getAttribute('data-compare-at-price');
        
        currentPrice = parseInt(price);
        currentCompareAtPrice = compareAt ? parseInt(compareAt) : 0;
        
        updatePrice();
    };

    window.increaseQty = function() {
        quantity++;
        const qtyEl = document.getElementById('quantity');
        if(qtyEl) qtyEl.textContent = quantity;
        updatePrice();
    };

    window.decreaseQty = function() {
        if (quantity > 1) {
            quantity--;
            const qtyEl = document.getElementById('quantity');
            if(qtyEl) qtyEl.textContent = quantity;
            updatePrice();
        }
    };

    window.addToCart = function() {
        const toast = document.getElementById('toast');
        if(toast) toast.classList.add('show');

        // Update cart count
        const cartCount = document.querySelector('.cart-count');
        if(cartCount) {
             const currentCount = parseInt(cartCount.textContent) || 0;
             cartCount.textContent = currentCount + quantity;
        }

        // Hide toast after 2 seconds
        if(toast) {
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2000);
        }

        // Haptic feedback on mobile
        if (navigator.vibrate) {
            navigator.vibrate(50);
        }
    };

    window.toggleAccordion = function(header) {
        const content = header.nextElementSibling;
        const isActive = header.classList.contains('active');

        // Close all accordions
        document.querySelectorAll('.accordion-header').forEach(h => {
            h.classList.remove('active');
            h.nextElementSibling.classList.remove('active');
        });

        // Open clicked accordion if it wasn't active
        if (!isActive) {
            header.classList.add('active');
            content.classList.add('active');
        }
    };

    window.toggleFAQ = function(question) {
        const answer = question.nextElementSibling;
        const isActive = question.classList.contains('active');

        question.classList.toggle('active');
        answer.classList.toggle('active');
    };

    window.share = function(platform) {
        const url = window.location.href;
        const text = 'Check out Inglorious perfume from Nurah Perfumes!';

        switch(platform) {
            case 'facebook':
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
                break;
            case 'whatsapp':
                window.open(`https://wa.me/?text=${text} ${url}`, '_blank');
                break;
            case 'pinterest':
                window.open(`https://pinterest.com/pin/create/button/?url=${url}`, '_blank');
                break;
            case 'email':
                window.location.href = `mailto:?subject=${text}&body=${url}`;
                break;
        }
    };

    // Initialization and Event Key Bindings
    document.addEventListener('DOMContentLoaded', () => {
        // Touch Swipe for Image Gallery
        let touchStartX = 0;
        let touchEndX = 0;

        const imageContainer = document.querySelector('.main-image-container');

        if(imageContainer){
            imageContainer.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, {passive: true});

            imageContainer.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, {passive: true});
        }

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            const gallery = document.querySelector('.image-gallery');
            if (!gallery) return;
            
            const thumbnails = gallery.querySelectorAll('.thumbnail');

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0 && currentImageIndex < thumbnails.length - 1) {
                    // Swipe left - next image
                    window.changeImage(thumbnails[currentImageIndex + 1], currentImageIndex + 1);
                } else if (diff < 0 && currentImageIndex > 0) {
                    // Swipe right - previous image
                    window.changeImage(thumbnails[currentImageIndex - 1], currentImageIndex - 1);
                }
            }
        }

        // Smooth Scroll Animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.option-section, .notes-card, .detail-accordion, .review-card').forEach(el => {
            observer.observe(el);
        });

        // Prevent scroll when at top (iOS bounce fix)
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, false);
    });
})();
</script>
@endpush