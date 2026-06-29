@extends('layouts.velvet')

@section('title', 'Velvet | Luxury Fragrance Collection')

@section('content')
<!-- Hero Section -->
<div class="velvet-hero-banner" style="margin-bottom: 5rem; border-radius: 2rem; overflow: hidden; width: 100%;">
    <picture style="width: 100%; display: block;">
        <source media="(max-width: 768px)" srcset="{{ asset('Images/Banner/Mobile.png') }}">
        <img src="{{ asset('Images/Banner/Desktop.png') }}" alt="Default Banner" style="width: 100%; height: auto; display: block;">
    </picture>
</div>

<!-- Collections Section -->
<div class="v-section-intro">
    <h2 class="v-section-title">Signature Collections</h2>
    <p class="v-section-desc">Explore our curated worlds of scent.</p>
</div>

<div class="v-collection-grid">
    @forelse($collections as $col)
    <a href="{{ route('velvet.collection', ['slug' => $col->slug]) }}" class="v-col-card">
        <div class="v-col-img">
            <img src="{{ $col->image ? asset('storage/' . $col->image) : asset('Images/g-load.webp') }}" 
                 onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                 alt="{{ $col->name }}">
            <div class="v-col-overlay">
                <h3 class="v-col-name">{{ $col->name }}</h3>
                <span class="v-col-link">Explore Collection <i class="fa-solid fa-arrow-right"></i></span>
            </div>
        </div>
    </a>
    @empty
        @foreach(['Collection 1', 'Collection 2', 'Collection 3', 'Collection 4'] as $fallbackName)
        <a href="javascript:void(0)" class="v-col-card">
            <div class="v-col-img">
                <img src="{{ asset('Images/def_img.webp') }}" alt="{{ $fallbackName }}">
                <div class="v-col-overlay">
                    <h3 class="v-col-name" style="transform: translateY(0);">{{ $fallbackName }}</h3>
                    <span class="v-col-link" style="opacity: 1; transform: translateY(0);">Explore Collection <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </div>
        </a>
        @endforeach
    @endforelse
</div>

<!-- Section Header -->
<div class="v-section-header-flex">
    <div>
        <h2 class="v-section-title">Bestsellers</h2>
        <p class="v-section-desc">The fragrances everyone is talking about.</p>
    </div>
    <div class="v-slider-arrows">
        <button class="action-btn-v" style="padding: 0.5rem; background: var(--secondary-bg); border-radius: 50%;"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="action-btn-v" style="padding: 0.5rem; background: var(--secondary-bg); border-radius: 50%;"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>

<!-- Product Grid -->
<div class="v-grid">
    @forelse($bestsellers as $item)
        @include('velvet.partials.product_card', [
            'product' => $item->product,
            'badge' => $loop->first ? 'Trending' : null
        ])
    @empty
        @foreach(['Product 1', 'Product 2', 'Product 3', 'Product 4'] as $index => $fallbackName)
        <div class="v-card">
            <div class="v-img-box">
                <a href="javascript:void(0)" style="display: block; height: 100%;">
                    @if($index == 0)
                        <span class="v-badge">Trending</span>
                    @endif
                    <img src="{{ asset('Images/def_img.webp') }}" alt="{{ $fallbackName }}">
                    <div class="social-proof-tag">
                        <i class="fa-solid fa-crown"></i>
                        <span>{{ rand(30, 120) }} sold this month</span>
                    </div>
                </a>
                <button class="v-quick-add-overlay" onclick="alert('Please add products in the admin panel.')">
                    <i class="fa-solid fa-cart-plus"></i> QUICK ADD
                </button>
            </div>
            <div class="v-details">
                <h3 class="v-name"><a href="javascript:void(0)" style="text-decoration: none; color: inherit;">{{ $fallbackName }}</a></h3>
                <p class="v-price">₹1,129</p>
            </div>
        </div>
        @endforeach
    @endforelse
</div>

<!-- Exclusive Combos Section -->
<div class="v-section-intro">
    <h2 class="v-section-title">Exclusive Combos</h2>
    <p class="v-section-desc">Luxury sets curated for the ultimate olfactory experience.</p>
</div>

<div class="v-combos-grid">
    @forelse($bundles as $bundle)
    <a href="{{ route('velvet.combo', ['slug' => $bundle->slug]) }}" class="v-combo-card">
        <div class="v-combo-img">
            <img src="{{ $bundle->image ? asset('storage/' . $bundle->image) : asset('Images/g-load.webp') }}" 
                 onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                 alt="{{ $bundle->title }}">
            <div class="social-proof-tag">
                <i class="fa-solid fa-gift"></i>
                <span>{{ rand(10, 45) }} gifted recently</span>
            </div>
        </div>
        <div class="v-combo-info">
            <span class="v-family" style="color: var(--accent-color);">Hand-Picked Set</span>
            <h3 class="v-name" style="font-size: 1.4rem; margin-top: 0.5rem;">{{ $bundle->title }}</h3>
            <div style="margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <span style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.1em;">Set Includes</span>
                <ul style="list-style: none; margin-top: 0.5rem; color: var(--text-primary); font-size: 0.85rem; opacity: 0.8;">
                    @foreach($bundle->products->take(2) as $p)
                        <li>{{ $p->title }}</li>
                    @endforeach
                    @if($bundle->products->count() > 2)
                        <li>+ {{ $bundle->products->count() - 2 }} more...</li>
                    @endif
                </ul>
            </div>
            <div style="margin-top: auto; padding-top: 2rem; display: flex; justify-content: space-between; align-items: center;">
                <span class="v-price" style="font-size: 1.3rem; color: var(--accent-color);">₹{{ number_format($bundle->total_price, 0) }}</span>
                <span style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-primary);">View Set <i class="fa-solid fa-arrow-right ml-2"></i></span>
            </div>
        </div>
    </a>
    @empty
        @foreach(['Bundle 1', 'Bundle 2', 'Bundle 3', 'Bundle 4'] as $fallbackName)
        <a href="javascript:void(0)" class="v-combo-card">
            <div class="v-combo-img">
                <img src="{{ asset('Images/def_img.webp') }}" alt="{{ $fallbackName }}">
                <div class="social-proof-tag">
                    <i class="fa-solid fa-gift"></i>
                    <span>{{ rand(10, 45) }} gifted recently</span>
                </div>
            </div>
            <div class="v-combo-info">
                <span class="v-family" style="color: var(--accent-color);">Hand-Picked Set</span>
                <h3 class="v-name" style="font-size: 1.4rem; margin-top: 0.5rem;">{{ $fallbackName }}</h3>
                <div style="margin-top: 1.5rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                    <span style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.1em;">Set Includes</span>
                    <ul style="list-style: none; margin-top: 0.5rem; color: var(--text-primary); font-size: 0.85rem; opacity: 0.8;">
                        <li>Premium Fragrance 1</li>
                        <li>Premium Fragrance 2</li>
                    </ul>
                </div>
                <div style="margin-top: auto; padding-top: 2rem; display: flex; justify-content: space-between; align-items: center;">
                    <span class="v-price" style="font-size: 1.3rem; color: var(--accent-color);">₹1,999</span>
                    <span style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-primary);">View Set <i class="fa-solid fa-arrow-right ml-2"></i></span>
                </div>
            </div>
        </a>
        @endforeach
    @endforelse
</div>

<!-- Newsletter / Membership -->
<div class="v-newsletter-box">
    <h2 class="v-section-title" style="margin-bottom: 1rem;">The Velvet Circle</h2>
    <p class="v-newsletter-desc">Subscribe to receive early access to new releases, private events, and exclusive offers.</p>
    <div class="v-newsletter-form">
        <input type="email" placeholder="Email address" style="background: #fff; border: 1px solid var(--border-color); padding: 1.25rem; border-radius: 0.75rem; color: var(--text-primary); flex-grow: 1; outline: none; box-shadow: var(--shadow-soft);">
        <button class="btn-v" style="padding: 1.25rem 2rem;">Subscribe</button>
    </div>
</div>
@endsection
