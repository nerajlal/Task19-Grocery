@extends('layouts.velvet')

@section('title', 'Velvet | ' . $bundle->title)

@section('content')
<div class="v-combo-detail-layout">
    <!-- Combo Image Gallery -->
    <div class="v-combo-media">
        <div class="v-combo-gallery">
            <img src="{{ $bundle->image ? asset('storage/' . $bundle->image) : asset('Images/g-load.webp') }}" 
                 onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                 style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        
        <!-- Included Products Preview -->
        <div style="margin-top: 2rem; display: flex; gap: 1.5rem; justify-content: center;">
            @foreach($bundle->products as $p)
                <div style="width: 80px; height: 80px; border-radius: 1rem; overflow: hidden; border: 2px solid #fff; box-shadow: var(--shadow-soft);">
                    <img src="{{ $p->main_image_url ?? asset('Images/g-load.webp') }}" 
                         onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Combo Details -->
    <div class="v-combo-details">
        <span class="v-family" style="font-size: 0.8rem; letter-spacing: 0.3em; display: block;">Exclusive Experience</span>
        <h1 style="margin-top: 0.5rem; line-height: 1.2;">{{ $bundle->title }}</h1>
        
        <div style="margin-top: 2rem; display: flex; align-items: center; gap: 2rem;">
            <span style="font-size: 2.5rem; font-weight: 800; color: var(--accent-color);">₹{{ number_format($bundle->total_price, 0) }}</span>
            <span style="padding: 0.5rem 1rem; background: var(--secondary-bg); border-radius: 99px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary);">Limited Set</span>
        </div>

        <p style="margin-top: 2rem; color: var(--text-secondary); line-height: 1.8; font-size: 1.1rem;">{{ $bundle->description }}</p>

        <!-- What's Inside List -->
        <div style="margin-top: 4rem;">
            <h3 style="font-size: 1.25rem; margin-bottom: 2rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-primary);">The Masterpiece Includes</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($bundle->products as $product)
                <div style="display: flex; align-items: center; gap: 1.5rem; padding: 1.5rem; background: var(--secondary-bg); border-radius: 1.5rem; border: 1px solid var(--border-color);">
                    <div style="width: 60px; height: 60px; border-radius: 0.75rem; overflow: hidden; flex-shrink: 0;">
                        <img src="{{ $product->main_image_url ?? asset('Images/g-load.webp') }}" 
                             onerror="this.src='{{ asset('Images/g-load.webp') }}'"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                        <h4 style="font-size: 1.1rem; font-weight: 700;">{{ $product->title }}</h4>
                        <span style="font-size: 0.75rem; color: var(--accent-color); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700;">{{ $product->olfactory_family ?? 'Signature Scents' }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div style="margin-top: 5rem; display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
            <button class="btn-v" style="width: 100%; padding: 1.5rem; font-size: 1rem; border: none; cursor: pointer;">
                Add Combo to Bag
            </button>
            <p style="text-align: center; font-size: 0.85rem; color: var(--text-secondary);">
                <i class="fa-solid fa-truck-fast mr-2"></i> Complimentary Express Shipping on all Combos
            </p>
        </div>
    </div>
</div>
@endsection
