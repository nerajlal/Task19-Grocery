@extends('layouts.storefront')

@section('title', 'Shop All Fragrances | VESPR Perfumes')

@section('content')
<div class="collection-header">
    <div style="max-width: 800px;">
        <h1 class="collection-title">Luxury Fragrance Catalog</h1>
        <p style="color: var(--text-muted); margin-top: 0.5rem; font-size: 1.1rem;">Explore our complete range of artisanal perfumes, essential oils, and signature blends.</p>
    </div>
    <div class="collection-stats">
        {{ $products->count() }} items available
    </div>
</div>

<div class="collection-layout-inner">
    <!-- Exclusive Combos Section -->
    @if(isset($bundles) && $bundles->count() > 0)
    <div class="department-section" style="margin-bottom: 5rem;">
        <div class="section-header">
            <h2 class="section-title">Exclusive Combos</h2>
            <a href="{{ route('v1.combos') }}" class="view-all" style="font-weight: 600; color: var(--accent-color); font-size: 0.95rem;">View all <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>
        <div class="product-grid bundle-responsive-grid">
            @foreach($bundles->take(4) as $bundle)
                @include('nurah.partials.bundle_card', ['bundle' => $bundle])
            @endforeach
        </div>
    </div>
    @endif

    <div class="section-header" style="margin-bottom: 1.5rem;">
        <h2 class="section-title">All Products</h2>
    </div>

    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                @include('nurah.partials.product_card', ['product' => $product])
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fa-solid fa-wind mb-4" style="font-size: 4rem; opacity: 0.1;"></i>
            <h2>Our catalog is currently quiet</h2>
            <p>We are currently updating our collection. Please check back soon!</p>
            <a href="{{ route('v1.home') }}" class="btn-primary mt-4">Return Home</a>
        </div>
    @endif
</div>

<style>
    .bundle-responsive-grid {
        grid-template-columns: repeat(4, 1fr) !important;
    }

    @media (max-width: 1200px) {
        .bundle-responsive-grid {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }

    @media (max-width: 992px) {
        .bundle-responsive-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    @media (max-width: 480px) {
        .bundle-responsive-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    .collection-header {
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    
    .collection-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1.2;
    }

    .collection-stats {
        font-weight: 600;
        color: var(--text-muted);
        background: var(--section-bg);
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.9rem;
    }

    .empty-state {
        text-align: center;
        padding: 8rem 2rem;
        background: var(--section-bg);
        border-radius: 2rem;
        color: var(--text-muted);
    }
</style>

@endsection
