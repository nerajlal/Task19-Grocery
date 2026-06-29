@php
    $mainImage = $product->images->where('order', 0)->first() ?? $product->images->first();
    $hoverImage = $product->images->where('order', 1)->first() ?? $product->images->skip(1)->first();
    $price = $product->starting_price;
    $comparePrice = $product->compare_at_price;
    $discount = 0;
    if($comparePrice > $price) {
        $discount = round((($comparePrice - $price) / $comparePrice) * 100);
    }
@endphp

<div class="af-p-card">
    <div class="af-p-media">
        <a href="{{ route('v5.product', ['id' => $product->id]) }}">
            <img src="{{ $mainImage ? asset('storage/' . $mainImage->path) : asset('Images/g-load.webp') }}" alt="{{ $product->title }}" class="af-p-main-img">
            @if($hoverImage)
                <img src="{{ asset('storage/' . $hoverImage->path) }}" alt="{{ $product->title }}" class="af-p-hover-img">
            @endif
        </a>

        @if($discount > 0)
            <div class="af-p-badge">-{{ $discount }}%</div>
        @elseif($product->created_at > now()->subDays(30))
            <div class="af-p-badge af-badge-new">NEW</div>
        @endif
    </div>

    <div class="af-p-info">
        <div class="af-p-meta">{{ $product->olfactory_family ?? 'Luxury Fragrance' }}</div>
        <h3 class="af-p-title"><a href="{{ route('v5.product', ['id' => $product->id]) }}">{{ $product->title }}</a></h3>
        <div class="af-p-price">
            @if($comparePrice > $price)
                <span class="af-price-old">₹{{ number_format($comparePrice, 0) }}</span>
            @endif
            <span class="af-price-new">₹{{ number_format($price, 0) }}</span>
        </div>
        
        <button class="af-quick-add" onclick="quickAddV5({{ $product->id }})">
            <span>+ ADD TO BAG</span>
        </button>
    </div>
</div>
<style>
    .af-p-card {
        background: #fff;
        padding: 6.45px 6.45px 25.8px;
        border-right: 1px solid #E8E8E8;
        border-bottom: 1px solid #E8E8E8;
        display: flex;
        flex-direction: column;
        transition: 0.3s;
        position: relative;
        height: 100%;
    }

    .af-p-media {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        margin-bottom: 15px;
        background: #fff;
    }

    .af-p-media img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .af-p-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #E32C2B;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 10px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .af-p-info { 
        text-align: center; 
        padding: 0 10px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .af-p-meta { 
        font-size: 10px; 
        color: #999; 
        text-transform: uppercase; 
        letter-spacing: 2.16px; 
        margin-bottom: 10px; 
        font-weight: 500; 
    }

    .af-p-title { 
        font-size: 12px; 
        font-weight: 500; 
        margin-bottom: 12px; 
        text-transform: uppercase; 
        letter-spacing: 2.16px; 
        line-height: 1.4; 
        min-height: 34px; 
    }
    .af-p-title a { text-decoration: none; color: #1C1C1C; }

    .af-p-price { 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 10px; 
        margin-bottom: 20px;
    }
    .af-price-old { text-decoration: line-through; color: #999; font-size: 12px; font-weight: 500; letter-spacing: 1.5px; }
    .af-price-new { font-size: 12px; font-weight: 700; color: #E32C2B; letter-spacing: 1.5px; }

    .af-quick-add {
        display: block;
        width: 100%;
        background: #000;
        color: #fff;
        border: none;
        padding: 12px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 2.16px;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
    }

    .af-quick-add:hover { background: #E32C2B; }

    @media (max-width: 768px) {
        .af-p-card { padding: 10px 10px 20px; border-right: none; }
        .af-p-title { font-size: 10px; min-height: 28px; letter-spacing: 1.5px; }
        .af-p-meta { font-size: 8px; letter-spacing: 1.5px; }
        .af-quick-add { padding: 10px; font-size: 9px; letter-spacing: 1.5px; }
    }
</style>
