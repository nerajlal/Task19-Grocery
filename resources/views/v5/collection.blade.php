@extends('v5.layouts.app')

@section('title', $collection->name . ' | Afnan Luxury Collection')

@section('content')
    <div class="af-page-header">
        <div class="container">
            <h1 class="serif">{{ $collection->name }}</h1>
            <p>{{ $collection->description ?? 'Discover our curated selection of fine fragrances.' }}</p>
        </div>
    </div>

    <div class="container">
        <div class="af-collection-toolbar">
            <span class="af-count">{{ $products->count() }} Products Found</span>
            <div class="af-sort">
                <select>
                    <option>Sort By: Best Selling</option>
                    <option>Newest First</option>
                    <option>Price: Low to High</option>
                </select>
            </div>
        </div>

        <div class="af-product-grid-listing" style="margin-bottom: 100px;">
            @foreach($products as $product)
                @include('v5.partials.product_card', ['product' => $product])
            @endforeach
            
            @if($products->count() == 0)
                <div style="grid-column: span 3; text-align: center; padding: 100px 0;">
                    <p style="color: #999;">No products found in this collection.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .af-page-header { padding: 80px 0 60px; text-align: center; background: #fff; border-bottom: 1px solid #eee; margin-bottom: 40px; }
        .af-page-header h1 { font-size: 42px; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 2px; }
        .af-page-header p { color: var(--af-gray); font-size: 14px; letter-spacing: 1px; max-width: 600px; margin: 0 auto; }

        .af-collection-toolbar { display: flex; justify-content: space-between; align-items: center; padding-bottom: 20px; margin-bottom: 30px; }
        .af-count { font-size: 12px; font-weight: 700; color: var(--af-gray); text-transform: uppercase; letter-spacing: 1px; }
        .af-sort select { border: none; font-family: inherit; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; background: transparent; cursor: pointer; }

        .af-product-grid-listing { display: grid; grid-template-columns: repeat(4, 1fr); border-top: 1px solid var(--af-border); border-left: 1px solid var(--af-border); }

        @media (max-width: 1024px) {
            .af-product-grid-listing { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
@endsection
