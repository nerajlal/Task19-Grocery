@extends('v4.layouts.app')

@section('title', 'Our Collections | Task19 Luxury Fragrance')

@section('content')
    <div class="a-page-header">
        <div class="container">
            <h1 class="cursive aj-title">OUR <span class="sketch-under">COLLECTIONS</span></h1>
            <p>Explore our curated olfactory journeys</p>
        </div>
    </div>

    <div class="container" style="margin-bottom: 100px;">
        <div class="v4-collections-grid">
            @foreach($collections as $collection)
                <a href="{{ route('v4.collection', ['slug' => $collection->slug]) }}" class="v4-collection-card">
                    <div class="v4-collection-img">
                        <img src="{{ $collection->image ? asset('storage/' . $collection->image) : asset('Images/g-load.webp') }}" alt="{{ $collection->name }}">
                        <div class="v4-collection-overlay">
                            <span class="v4-view-link">DISCOVER NOW</span>
                        </div>
                    </div>
                    <div class="v4-collection-info">
                        <h3 class="serif">{{ $collection->name }}</h3>
                        <p>{{ $collection->description ?? 'Explore our unique range of luxury fragrances' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <style>
        .a-page-header {
            padding: 80px 0 50px;
            text-align: center;
            background: #fff;
        }
        .a-page-header p { 
            color: var(--aj-gray); 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 3px; 
            margin-top: 15px;
            font-weight: 700;
        }

        .v4-collections-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
        }

        .v4-collection-card {
            text-decoration: none;
            display: block;
            group;
        }

        .v4-collection-img {
            aspect-ratio: 0.8;
            background: #f9f9f9;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            margin-bottom: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            transition: 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .v4-collection-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .v4-collection-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.5s;
        }

        .v4-view-link {
            padding: 12px 25px;
            background: #fff;
            color: #000;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            border-radius: 4px;
            transform: translateY(20px);
            transition: 0.5s;
        }

        .v4-collection-card:hover .v4-collection-img {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        }

        .v4-collection-card:hover .v4-collection-img img {
            transform: scale(1.1);
        }

        .v4-collection-card:hover .v4-collection-overlay {
            opacity: 1;
        }

        .v4-collection-card:hover .v4-view-link {
            transform: translateY(0);
        }

        .v4-collection-info {
            text-align: center;
            padding: 0 10px;
        }

        .v4-collection-info h3 {
            font-size: 24px;
            color: var(--aj-dark);
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .v4-collection-card:hover .v4-collection-info h3 {
            color: var(--aj-gold);
        }

        .v4-collection-info p {
            font-size: 13px;
            color: var(--aj-gray);
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 991px) {
            .v4-collections-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }
        }

        @media (max-width: 576px) {
            .v4-collections-grid {
                grid-template-columns: 1fr;
            }
            .a-page-header h1 { font-size: 32px; }
        }
    </style>
@endsection
