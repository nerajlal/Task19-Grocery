@extends('layouts.storefront')

@section('title', 'Exclusive Combos & Gift Sets | VESPR Perfumes')

@section('content')
<div class="collection-header" style="margin-bottom: 3rem;">
    <h1 class="section-title" style="font-size: 2.5rem; margin-bottom: 0.5rem;">Exclusive Combos</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem;">Discover perfectly paired fragrances and gift sets with exclusive savings.</p>
</div>

@if($bundles->count() > 0)
    <div class="product-grid">
        @foreach($bundles as $bundle)
            @include('nurah.partials.bundle_card', ['bundle' => $bundle])
        @endforeach
    </div>
@else
    <div style="text-align: center; padding: 5rem 2rem; background: var(--section-bg); border-radius: 1.5rem;">
        <i class="fa-solid fa-layer-group" style="font-size: 3rem; color: var(--border-color); margin-bottom: 1.5rem; display: block;"></i>
        <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">No Combos Available</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">We're currently curating new exclusive bundles. Please check back soon!</p>
        <a href="{{ route('v1.all-products') }}" class="btn-primary">Browse All Perfumes</a>
    </div>
@endif
@endsection
