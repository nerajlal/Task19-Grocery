@extends('v5.layouts.app')

@section('title', 'Our Collections | Afnan Luxury Collection')

@section('content')
    <div class="af-page-header">
        <div class="container">
            <h1 class="serif">Our Collections</h1>
            <p>Discover the unique stories behind our fragrance families</p>
        </div>
    </div>

    <div class="container">
        <div class="af-collections-grid">
            @foreach($collections as $collection)
                <a href="{{ route('v5.collection', ['slug' => $collection->slug]) }}" class="af-coll-card">
                    <div class="af-coll-img">
                        <img src="{{ $collection->image ? asset('storage/' . $collection->image) : asset('Images/g-load.webp') }}" alt="{{ $collection->name }}">
                        <div class="af-coll-overlay">
                            <span>EXPLORE</span>
                        </div>
                    </div>
                    <div class="af-coll-info">
                        <h3 class="serif">{{ $collection->name }}</h3>
                        <p>{{ $collection->description ?? 'Discover the exquisite craftsmanship of this collection.' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <style>
        .af-page-header { padding: 80px 0 60px; text-align: center; background: #fff; }
        .af-page-header h1 { font-size: 42px; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 2px; }
        .af-page-header p { color: var(--af-gray); font-size: 14px; letter-spacing: 1px; }

        .af-collections-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 100px; }
        
        .af-coll-card { text-decoration: none; color: inherit; display: block; group; }
        .af-coll-img { aspect-ratio: 0.8; overflow: hidden; position: relative; margin-bottom: 25px; background: var(--af-light); }
        .af-coll-img img { width: 100%; height: 100%; object-fit: cover; transition: 1s cubic-bezier(0.165, 0.84, 0.44, 1); }
        
        .af-coll-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; opacity: 0; transition: 0.4s; }
        .af-coll-overlay span { border: 1px solid #fff; color: #fff; padding: 10px 30px; font-size: 11px; font-weight: 700; letter-spacing: 2px; transform: translateY(20px); transition: 0.4s; }

        .af-coll-card:hover .af-coll-img img { transform: scale(1.05); }
        .af-coll-card:hover .af-coll-overlay { opacity: 1; }
        .af-coll-card:hover .af-coll-overlay span { transform: translateY(0); }

        .af-coll-info { text-align: center; }
        .af-coll-info h3 { font-size: 24px; margin-bottom: 10px; }
        .af-coll-info p { font-size: 13px; color: var(--af-gray); line-height: 1.6; max-width: 300px; margin: 0 auto; }

        @media (max-width: 991px) {
            .af-collections-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .af-collections-grid { grid-template-columns: 1fr; }
        }
    </style>
@endsection
