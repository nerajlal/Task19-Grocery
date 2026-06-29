@extends('v5.layouts.app')

@section('title', 'Exclusive Combos | Afnan Luxury Collection')

@section('content')
    <div class="af-page-header">
        <div class="container">
            <h1 class="serif">Exclusive Combos</h1>
            <p>Curated sets for the ultimate fragrance experience</p>
        </div>
    </div>

    <div class="container">
        <div class="af-combos-grid">
            @foreach($bundles as $bundle)
                <div class="af-combo-card">
                    <div class="af-combo-media">
                        <img src="{{ Storage::url($bundle->image) }}" alt="{{ $bundle->title }}" onerror="this.src='{{ asset('Images/g-load.webp') }}'">
                        <div class="af-combo-badge">Save ₹{{ number_format($bundle->products->sum(fn($p) => $p->starting_price) - $bundle->total_price, 0) }}</div>
                    </div>
                    <div class="af-combo-info">
                        <span class="af-combo-subtitle">{{ $bundle->products->count() }} PIECE SET</span>
                        <h2 class="serif">{{ $bundle->title }}</h2>
                        <div class="af-combo-price">
                            <span class="old">₹{{ number_format($bundle->products->sum(fn($p) => $p->starting_price), 0) }}</span>
                            <span class="new">₹{{ number_format($bundle->total_price, 0) }}</span>
                        </div>
                        <a href="{{ route('v5.combo', ['id' => $bundle->id]) }}" class="af-btn-dark">EXPLORE COMBO</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .af-page-header { padding: 80px 0 60px; text-align: center; background: #fff; }
        .af-page-header h1 { font-size: 42px; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 2px; }
        .af-page-header p { color: var(--af-gray); font-size: 14px; letter-spacing: 1px; }

        .af-combos-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 40px; margin-bottom: 100px; }
        
        .af-combo-card { background: #fff; border: 1px solid var(--af-border); display: flex; flex-direction: column; overflow: hidden; transition: 0.3s; }
        .af-combo-card:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.05); }

        .af-combo-media { position: relative; aspect-ratio: 1.5; overflow: hidden; background: var(--af-light); }
        .af-combo-media img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; }
        .af-combo-card:hover .af-combo-media img { transform: scale(1.05); }

        .af-combo-badge { position: absolute; top: 20px; left: 20px; background: var(--af-red); color: #fff; font-size: 10px; font-weight: 800; padding: 6px 12px; letter-spacing: 1px; }

        .af-combo-info { padding: 40px; text-align: center; }
        .af-combo-subtitle { display: block; font-size: 10px; font-weight: 700; color: var(--af-gray); letter-spacing: 2px; margin-bottom: 15px; }
        .af-combo-info h2 { font-size: 28px; margin-bottom: 15px; letter-spacing: 1px; }
        
        .af-combo-price { display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 30px; }
        .af-combo-price .old { text-decoration: line-through; color: #999; font-size: 16px; }
        .af-combo-price .new { font-size: 22px; font-weight: 700; color: var(--af-black); }

        @media (max-width: 991px) {
            .af-combos-grid { grid-template-columns: 1fr; }
        }
    </style>
@endsection
