@extends('layouts.velvet')

@section('title', 'Velvet | All Fragrances')

@section('content')
<!-- Page Header -->
<div style="margin-bottom: 4rem;">
    <span class="v-family" style="font-size: 0.8rem; letter-spacing: 0.3em;">The Catalog</span>
    <h1 style="font-size: 3.5rem; color: var(--text-primary); margin-top: 0.5rem;">All Fragrances</h1>
    <p style="color: var(--text-secondary); margin-top: 1rem; max-width: 600px; font-size: 1.1rem;">Explore our complete olfactory universe, from deep ouds to ethereal florals.</p>
</div>

<!-- Product Grid -->
<div class="v-grid">
    @foreach($products as $product)
        @include('velvet.partials.product_card', ['product' => $product])
    @endforeach
</div>
@endsection
