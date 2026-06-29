@extends('layouts.storefront')

@section('title', ($title ?? 'Collection') . ' | VESPR Perfumes')

@section('content')
<div class="collection-header">
    <div style="max-width: 800px;">
        <h1 class="collection-title">{{ $title ?? 'Fragrances' }}</h1>
        <p style="color: var(--text-muted); margin-top: 0.5rem; font-size: 1.1rem;">Discover our selection of premium scents curated specifically for this category.</p>
    </div>
    <div class="collection-stats">
        {{ $products->count() }} items available
    </div>
</div>

<div class="collection-layout-inner">
    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
                @include('nurah.partials.product_card', ['product' => $product])
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fa-solid fa-wind mb-4" style="font-size: 4rem; opacity: 0.1;"></i>
            <h2>No fragrances found</h2>
            <p>We couldn't find any products in this selection. Please try another category.</p>
            <a href="{{ route('v1.all-products') }}" class="btn-primary mt-4">Shop All Products</a>
        </div>
    @endif
</div>

<style>
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
    
    .empty-state h2 {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .collection-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
    }
</style>
@endsection

