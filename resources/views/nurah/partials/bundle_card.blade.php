<div class="product-card">
    <a href="{{ route('v1.combo', ['id' => $bundle->id]) }}" class="card-img">
        @php 
            $imagePath = $bundle->image ? Storage::url($bundle->image) : null;
            if (!$imagePath && $bundle->type == 'pack') {
                $firstProd = $bundle->products->first();
                $imagePath = $firstProd ? $firstProd->main_image_url : asset('Images/g-load.webp');
            } elseif (!$imagePath) {
                $imagePath = asset('Images/g-load.webp');
            }
        @endphp
        <img src="{{ $imagePath }}" alt="{{ $bundle->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
        <div class="social-proof-tag">
            <i class="fa-solid fa-shopping-bag"></i>
            <span>{{ rand(20, 60) }} bundles grabbed recently</span>
        </div>
        <div style="position: absolute; top: 0.5rem; right: 0.5rem; background: var(--accent-color); color: var(--primary-color); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">
            {{ $bundle->type == 'pack' ? 'VOLUME DEAL' : 'COMBO SAVINGS' }}
        </div>
    </a>
    <div class="card-info">
        <div style="display: flex; align-items: baseline; gap: 0.5rem;">
            <span class="p-price">₹{{ number_format($bundle->total_price, 2) }}</span>
            @php
                $originalPrice = $bundle->products->sum(function($p) {
                    return $p->variants->min('price') ?? 0;
                });
            @endphp
            @if($originalPrice > $bundle->total_price)
                <span style="text-decoration: line-through; color: var(--text-muted); font-size: 0.85rem;">₹{{ number_format($originalPrice, 2) }}</span>
            @endif
        </div>
        <a href="{{ route('v1.combo', ['id' => $bundle->id]) }}" class="p-name">{{ $bundle->title }}</a>
        <span class="p-meta">{{ $bundle->products->count() }} Products Included</span>
    </div>
    <button class="cart-add-btn" data-product-id="{{ $bundle->id }}" data-type="bundle">
        <i class="fa-solid fa-plus"></i>
    </button>
</div>
