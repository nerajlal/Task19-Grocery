@extends('v5.layouts.app')

@section('title', $product->title . ' | Afnan Luxury Collection')

@section('content')
    <div class="af-p-container">
        <div class="container">
            <div class="af-p-grid">
                <!-- Media Gallery -->
                <div class="af-p-gallery">
                    @foreach($product->images as $image)
                        <div class="af-p-img-box">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->title }}">
                        </div>
                    @endforeach
                </div>

                <!-- Product Info -->
                <div class="af-p-summary">
                    <div class="af-p-sticky">
                        <nav class="af-p-breadcrumb">
                            <a href="{{ route('v5.home') }}">Home</a> / 
                            <a href="{{ route('v5.all-products') }}">Perfumes</a> /
                            <span>{{ $product->title }}</span>
                        </nav>

                        <div class="af-p-header">
                            <span class="af-p-tag">{{ $product->olfactory_family ?? 'Exclusive' }}</span>
                            <h1 class="serif">{{ $product->title }}</h1>
                            <div class="af-p-price-row">
                                <span class="af-p-price">₹{{ number_format($product->starting_price, 0) }}</span>
                                @if($product->compare_at_price > $product->starting_price)
                                    <span class="af-p-old">₹{{ number_format($product->compare_at_price, 0) }}</span>
                                    <span class="af-p-save">SAVE {{ round((($product->compare_at_price - $product->starting_price) / $product->compare_at_price) * 100) }}%</span>
                                @endif
                            </div>
                        </div>

                        <div class="af-p-options">
                            <div class="af-option-label">Select Size</div>
                            <div class="af-size-grid">
                                @foreach($product->variants as $index => $variant)
                                    <button class="af-size-btn {{ $index == 0 ? 'active' : '' }}" 
                                            data-price="{{ $variant->price }}" 
                                            data-compare="{{ $variant->compare_at_price }}"
                                            data-sku="{{ $variant->sku }}">
                                        {{ $variant->size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="af-p-actions">
                            <button class="af-add-btn">ADD TO BAG</button>
                            <button class="af-wish-btn"><i class="fa-regular fa-heart"></i></button>
                        </div>

                        <div class="af-p-details">
                            <div class="af-accordion">
                                <div class="af-acc-item active">
                                    <div class="af-acc-header">Description <i class="fa-solid fa-chevron-down"></i></div>
                                    <div class="af-acc-content">
                                        <p>{{ $product->description }}</p>
                                    </div>
                                </div>
                                <div class="af-acc-item">
                                    <div class="af-acc-header">Fragrance Notes <i class="fa-solid fa-chevron-down"></i></div>
                                    <div class="af-acc-content">
                                        <div class="af-notes-grid">
                                            @if($product->notes_top)
                                                <div class="af-note"><strong>Top:</strong> {{ $product->notes_top }}</div>
                                            @endif
                                            @if($product->notes_heart)
                                                <div class="af-note"><strong>Heart:</strong> {{ $product->notes_heart }}</div>
                                            @endif
                                            @if($product->notes_base)
                                                <div class="af-note"><strong>Base:</strong> {{ $product->notes_base }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .af-p-container { padding: 50px 0 100px; }
        .af-p-grid { display: grid; grid-template-columns: 1fr 450px; gap: 80px; }

        .af-p-gallery { display: flex; flex-direction: column; gap: 20px; }
        .af-p-img-box { background: #f9f9f9; border-radius: 4px; overflow: hidden; }
        .af-p-img-box img { width: 100%; display: block; }

        .af-p-sticky { position: sticky; top: 130px; }
        .af-p-breadcrumb { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-bottom: 30px; }
        .af-p-breadcrumb a { text-decoration: none; color: inherit; }
        
        .af-p-tag { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--af-red); display: block; margin-bottom: 15px; }
        .af-p-header h1 { font-size: 36px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; }
        
        .af-p-price-row { display: flex; align-items: center; gap: 20px; margin-bottom: 40px; }
        .af-p-price { font-size: 24px; font-weight: 700; }
        .af-p-old { text-decoration: line-through; color: #999; font-size: 18px; }
        .af-p-save { background: #000; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 2px; }

        .af-option-label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; }
        .af-size-grid { display: flex; gap: 10px; margin-bottom: 40px; }
        .af-size-btn { border: 1px solid #eee; background: #fff; padding: 12px 25px; font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .af-size-btn.active { border-color: #000; background: #000; color: #fff; }

        .af-p-actions { display: flex; gap: 15px; margin-bottom: 50px; }
        .af-add-btn { flex: 1; background: var(--af-black); color: #fff; border: none; padding: 20px; font-weight: 700; font-size: 13px; letter-spacing: 2px; cursor: pointer; }
        .af-wish-btn { width: 60px; border: 1px solid #eee; background: #fff; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s; }
        .af-wish-btn:hover { border-color: #000; }

        .af-acc-item { border-bottom: 1px solid #eee; }
        .af-acc-header { padding: 20px 0; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .af-acc-content { padding-bottom: 20px; font-size: 14px; color: var(--af-gray); line-height: 1.8; display: none; }
        .af-acc-item.active .af-acc-content { display: block; }
        .af-acc-item.active i { transform: rotate(180deg); }

        @media (max-width: 1024px) {
            .af-p-grid { grid-template-columns: 1fr; }
            .af-p-gallery { order: 2; }
            .af-p-summary { order: 1; }
            .af-p-sticky { position: static; }
        }
    </style>

    <script>
        $('.af-acc-header').click(function() {
            $(this).parent().toggleClass('active');
        });

        $('.af-size-btn').click(function() {
            $('.af-size-btn').removeClass('active');
            $(this).addClass('active');
            $('.af-p-price').text('₹' + parseInt($(this).data('price')).toLocaleString());
            // Update compare price logic here
        });
    </script>
@endsection
