@extends('v4.layouts.app')

@section('title', $bundle->title . ' | Exclusive Set | Task19 Luxury Fragrance')

@section('content')
    <div class="container" style="margin-top: 30px;">
        <nav class="v4-breadcrumb">
            <a href="{{ route('v4.home') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('v4.combos') }}">Combos</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>{{ $bundle->title }}</span>
        </nav>

        <div class="v4-bundle-detail-layout" style="margin-top: 50px;">
            <!-- Left: Bundle Image -->
            <div class="v4-bundle-media">
                <div class="v4-bundle-main-img">
                    <img src="{{ Storage::url($bundle->image) }}" alt="{{ $bundle->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                    <div class="v4-bundle-discount-badge">SAVE ₹{{ number_format($bundle->products->sum(fn($p) => $p->starting_price) - $bundle->total_price, 0) }}</div>
                </div>
            </div>

            <!-- Right: Bundle Details -->
            <div class="v4-bundle-info">
                <div class="v4-bundle-header">
                    <div class="v4-bundle-cat">EXCLUSIVE CURATED SET</div>
                    <h1 class="serif">{{ $bundle->title }}</h1>
                    <div class="v4-bundle-price">
                        <span class="v4-price-old">₹{{ number_format($bundle->products->sum(fn($p) => $p->starting_price), 0) }}</span>
                        <span class="v4-price-new">₹{{ number_format($bundle->total_price, 0) }}</span>
                    </div>
                </div>

                <div class="v4-bundle-description">
                    <p>{{ $bundle->description ?? 'Experience the ultimate luxury with this hand-picked selection of our finest fragrances, bundled together for an incomparable value.' }}</p>
                </div>

                <div class="v4-bundle-includes">
                    <h3>SET INCLUDES</h3>
                    <div class="v4-included-list">
                        @foreach($bundle->products as $product)
                            <div class="v4-included-item">
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                                <div class="v4-included-text">
                                    <strong>{{ $product->title }}</strong>
                                    <span>{{ $product->olfactory_family }} • Full Size</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="v4-bundle-actions" style="margin-top: 40px;">
                    <button class="v4-bundle-add-btn" onclick="addBundleToCart({{ $bundle->id }}, event)">
                        <i class="fa-solid fa-bag-shopping"></i> Add Exclusive Set to Bag
                    </button>
                </div>

                <div class="v4-bundle-features">
                    <div class="v4-feat-item"><i class="fa-solid fa-truck-fast"></i> Free Express Shipping</div>
                    <div class="v4-feat-item"><i class="fa-solid fa-gift"></i> Luxury Gift Packaging</div>
                </div>
            </div>
        </div>

        <!-- Related Combos -->
        @if($relatedBundles->count() > 0)
        <div class="v4-related-combos">
            <h2 class="cursive aj-title text-center">YOU MAY ALSO <span class="sketch-under">LIKE</span></h2>
            <div class="v4-combos-mini-grid">
                @foreach($relatedBundles as $rel)
                    <a href="{{ route('v4.combo', ['id' => $rel->id]) }}" class="v4-mini-combo-card">
                        <img src="{{ Storage::url($rel->image) }}" alt="{{ $rel->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                        <div class="v4-mini-info">
                            <h4>{{ $rel->title }}</h4>
                            <span class="v4-mini-price">₹{{ number_format($rel->total_price, 0) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <style>
        .v4-breadcrumb { display: flex; align-items: center; gap: 10px; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; color: var(--aj-gray); }
        .v4-breadcrumb a { text-decoration: none; color: inherit; transition: 0.3s; }
        .v4-breadcrumb a:hover { color: var(--aj-gold); }
        .v4-breadcrumb i { font-size: 8px; opacity: 0.5; }

        .v4-bundle-detail-layout { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 80px; align-items: start; }

        .v4-bundle-main-img { position: relative; border-radius: 15px; overflow: hidden; background: #f9f9f9; border: 1px solid #eee; }
        .v4-bundle-main-img img { width: 100%; height: auto; display: block; }
        .v4-bundle-discount-badge { position: absolute; top: 30px; left: 30px; background: var(--aj-gold); color: #fff; padding: 8px 20px; font-size: 12px; font-weight: 900; text-transform: uppercase; border-radius: 4px; letter-spacing: 1px; box-shadow: 0 10px 20px rgba(176, 141, 87, 0.3); }

        .v4-bundle-cat { font-size: 12px; font-weight: 800; color: var(--aj-gold); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 15px; }
        .v4-bundle-info h1 { font-size: 48px; line-height: 1.1; margin-bottom: 20px; color: var(--aj-dark); }
        .v4-bundle-price { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
        .v4-price-old { text-decoration: line-through; color: #999; font-size: 20px; }
        .v4-price-new { font-size: 32px; font-weight: 800; color: var(--aj-gold); }

        .v4-bundle-description { font-size: 16px; line-height: 1.8; color: var(--aj-gray); margin-bottom: 40px; }

        .v4-bundle-includes h3 { font-size: 14px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px; font-weight: 800; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .v4-included-list { display: flex; flex-direction: column; gap: 20px; }
        .v4-included-item { display: flex; align-items: center; gap: 20px; padding: 15px; background: #fdfdfd; border: 1px solid #f5f5f5; border-radius: 8px; transition: 0.3s; }
        .v4-included-item:hover { border-color: var(--aj-gold); background: #fff; transform: translateX(10px); }
        .v4-included-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
        .v4-included-text strong { display: block; font-size: 15px; color: var(--aj-dark); margin-bottom: 3px; }
        .v4-included-text span { font-size: 12px; color: var(--aj-gray); font-weight: 600; }

        .v4-bundle-add-btn { width: 100%; background: #000; color: #fff; border: none; padding: 20px; border-radius: 6px; font-weight: 700; text-transform: uppercase; font-size: 14px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 15px; }
        .v4-bundle-add-btn:hover { background: var(--aj-gold); transform: translateY(-5px); box-shadow: 0 15px 30px rgba(176, 141, 87, 0.2); }

        .v4-bundle-features { display: flex; gap: 30px; margin-top: 30px; padding-top: 30px; border-top: 1px solid #eee; }
        .v4-feat-item { font-size: 12px; font-weight: 700; color: var(--aj-gray); display: flex; align-items: center; gap: 10px; }
        .v4-feat-item i { color: var(--aj-gold); font-size: 16px; }

        .v4-related-combos { margin-top: 100px; margin-bottom: 100px; padding-top: 80px; border-top: 1px solid #f0f0f0; }
        .v4-combos-mini-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-top: 50px; }
        .v4-mini-combo-card { text-decoration: none; display: block; transition: 0.3s; }
        .v4-mini-combo-card:hover { transform: translateY(-10px); }
        .v4-mini-combo-card img { width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: 8px; margin-bottom: 15px; border: 1px solid #eee; }
        .v4-mini-info h4 { font-size: 16px; color: var(--aj-dark); margin-bottom: 5px; }
        .v4-mini-price { font-size: 14px; font-weight: 800; color: var(--aj-gold); }

        @media (max-width: 1024px) {
            .v4-bundle-detail-layout { grid-template-columns: 1fr; gap: 40px; }
            .v4-bundle-info h1 { font-size: 36px; }
            .v4-combos-mini-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>

    <script>
        function addBundleToCart(bundleId, event) {
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: bundleId,
                    quantity: 1,
                    type: 'bundle'
                },
                success: function(response) {
                    if(response.success) {
                        $('#cart-count').text(response.cartCount);
                        btn.innerHTML = '<i class="fa-solid fa-check"></i> Added to Bag';
                        btn.style.background = '#10B981';
                        setTimeout(() => {
                            btn.innerHTML = originalHtml;
                            btn.style.background = '';
                            btn.disabled = false;
                        }, 2000);
                    }
                }
            });
        }
    </script>
@endsection
