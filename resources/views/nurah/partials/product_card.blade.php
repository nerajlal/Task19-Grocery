<div class="product-card">
    <a href="{{ route('v1.product', ['id' => $product->id]) }}" class="card-img">
        @php 
            $imagePath = $product->main_image_url;
            if (!$imagePath) {
                // Fallback to legacy path if it exists or hardcoded images/ folder
                $legacyImg = $product->image ?? 'Images/products/p' . $product->id . '.png';
                if (Str::startsWith($legacyImg, 'Images/')) {
                    $imagePath = asset($legacyImg);
                } else {
                    $imagePath = asset('Images/g-load.webp');
                }
            }
        @endphp
        <img src="{{ $imagePath }}" alt="{{ $product->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
        <div class="social-proof-tag">
            <i class="fa-solid fa-fire"></i>
            <span>{{ rand(45, 180) }} bought this week</span>
        </div>
    </a>
    <div class="card-info">
        <span class="p-price">₹{{ number_format($product->starting_price, 2) }}</span>
        <a href="{{ route('v1.product', ['id' => $product->id]) }}" class="p-name">{{ $product->title }}</a>
        <span class="p-meta">{{ $product->olfactory_family }} • {{ $product->type }}</span>
    </div>
    <button class="cart-add-btn" data-product-id="{{ $product->id }}" data-default-size="{{ $product->variants->first()->size ?? '' }}">
        <i class="fa-solid fa-plus"></i>
    </button>
</div>
