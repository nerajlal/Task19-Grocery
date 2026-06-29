@extends('layouts.velvet')

@section('title', 'Velvet | ' . $collection->name)

@section('content')
<!-- Collection Header -->
<div style="margin-bottom: 4rem;">
    <span class="v-family" style="font-size: 0.8rem; letter-spacing: 0.3em;">Curated Collection</span>
    <h1 style="font-size: 3.5rem; color: var(--text-primary); margin-top: 0.5rem;">{{ $collection->name }}</h1>
    @if($collection->description)
        <p style="color: var(--text-secondary); margin-top: 1rem; max-width: 600px; font-size: 1.1rem;">{{ $collection->description }}</p>
    @endif
</div>

<!-- Product Grid -->
@if($products->count() > 0)
    <div class="v-grid">
        @foreach($products as $product)
            @include('velvet.partials.product_card', ['product' => $product])
        @endforeach
    </div>
@else
    <div style="text-align: center; padding: 10rem 2rem; background: var(--secondary-bg); border-radius: 2rem;">
        <i class="fa-solid fa-leaf" style="font-size: 3rem; color: var(--accent-color); opacity: 0.3; margin-bottom: 2rem;"></i>
        <h2 style="font-size: 1.5rem; color: var(--text-secondary);">No products found in this collection</h2>
        <a href="{{ route('velvet.all-products') }}" class="btn-v" style="margin-top: 2rem;">Explore All Fragrances</a>
    </div>
@endif
@endsection
