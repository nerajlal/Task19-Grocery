@extends('v4.layouts.app')

@section('title', 'Exclusive Combos & Bundles | Task19 Luxury Fragrance')

@section('content')
    <div class="container" style="margin-top: 50px;">
        <nav class="v4-breadcrumb">
            <a href="{{ route('v4.home') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Exclusive Combos</span>
        </nav>

        <header class="v4-page-header text-center" style="margin-top: 60px; margin-bottom: 80px; position: relative; z-index: 1;">
            <h1 class="cursive aj-title">EXCLUSIVE <span class="sketch-under">COMBOS</span></h1>
            <p class="serif" style="font-size: 18px; color: var(--aj-gray); max-width: 600px; margin: 20px auto 0;">Experience the art of layering with our curated sets, designed to provide a complete and lasting luxury experience.</p>
        </header>

        <div class="v4-combos-grid">
            @foreach($bundles as $bundle)
                <div class="v4-combo-card">
                    <div class="v4-combo-media">
                        <img src="{{ Storage::url($bundle->image) }}" alt="{{ $bundle->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                        <div class="v4-combo-badge">SAVE ₹{{ number_format($bundle->products->sum(fn($p) => $p->starting_price) - $bundle->total_price, 0) }}</div>
                    </div>
                    <div class="v4-combo-info">
                        <h3 class="serif">{{ $bundle->title }}</h3>
                        <div class="v4-combo-meta">
                            <span>{{ $bundle->products->count() }} Premium Items</span>
                        </div>
                        <div class="v4-combo-price">
                            <span class="v4-price-old">₹{{ number_format($bundle->products->sum(fn($p) => $p->starting_price), 0) }}</span>
                            <span class="v4-price-new">₹{{ number_format($bundle->total_price, 0) }}</span>
                        </div>
                        <a href="{{ route('v4.combo', ['id' => $bundle->id]) }}" class="v4-combo-btn">Explore Set</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .v4-breadcrumb { display: flex; align-items: center; gap: 10px; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; color: var(--aj-gray); }
        .v4-breadcrumb a { text-decoration: none; color: inherit; transition: 0.3s; }
        .v4-breadcrumb a:hover { color: var(--aj-gold); }
        .v4-breadcrumb i { font-size: 8px; opacity: 0.5; }

        .v4-combos-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            margin-bottom: 100px;
        }

        .v4-combo-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            overflow: hidden;
            transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .v4-combo-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.08); }

        .v4-combo-media { position: relative; overflow: hidden; background: #f9f9f9; }
        .v4-combo-media img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; }
        .v4-combo-card:hover .v4-combo-media img { transform: scale(1.1); }
        .v4-combo-badge { position: absolute; top: 15px; left: 15px; background: var(--aj-gold); color: #fff; padding: 5px 12px; font-size: 10px; font-weight: 900; text-transform: uppercase; border-radius: 4px; letter-spacing: 1px; }

        .v4-combo-info { padding: 40px; display: flex; flex-direction: column; justify-content: center; }
        .v4-combo-info h3 { font-size: 28px; margin-bottom: 15px; color: var(--aj-dark); }
        .v4-combo-meta { font-size: 12px; color: var(--aj-gray); text-transform: uppercase; font-weight: 700; letter-spacing: 1.5px; margin-bottom: 20px; }
        .v4-combo-price { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
        .v4-price-old { text-decoration: line-through; color: #999; font-size: 16px; }
        .v4-price-new { font-size: 24px; font-weight: 800; color: var(--aj-gold); }
        .v4-combo-btn { background: #000; color: #fff; text-decoration: none; text-align: center; padding: 15px; border-radius: 4px; font-weight: 700; text-transform: uppercase; font-size: 12px; transition: 0.3s; }
        .v4-combo-btn:hover { background: var(--aj-gold); }

        @media (max-width: 991px) {
            .v4-combos-grid { grid-template-columns: 1fr; gap: 30px; }
            .v4-combo-info { padding: 30px; }
            .v4-combo-info h3 { font-size: 24px; }
        }
        @media (max-width: 768px) {
            .v4-combo-card { grid-template-columns: 1fr; }
            .v4-combo-media { aspect-ratio: 1; }
        }
    </style>
@endsection
