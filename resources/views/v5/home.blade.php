@extends('v5.layouts.app')

@section('content')
    <!-- Hero Slider -->
    <div class="af-hero">
        <div class="af-slides">
            @foreach($sliders as $index => $slide)
                <div class="af-slide {{ $index == 0 ? 'active' : '' }}">
                    <picture>
                        <source media="(max-width: 768px)" srcset="{{ Storage::url($slide->image_mobile) }}">
                        <img src="{{ Storage::url($slide->image_desktop) }}" alt="{{ $slide->title }}">
                    </picture>
                    <div class="af-hero-content">
                        <h2 class="serif">{{ $slide->title }}</h2>
                        <a href="{{ route('v5.all-products') }}" class="af-btn">Discover Now</a>
                    </div>
                </div>
            @endforeach

            @if($sliders->count() == 0)
                <div class="af-slide active">
                    <picture>
                        <source media="(max-width: 768px)" srcset="{{ asset('Images/Banner/Mobile.png') }}">
                        <img src="{{ asset('Images/Banner/Desktop.png') }}" alt="Default Banner">
                    </picture>
                    <div class="af-hero-content">
                        <h2 class="serif">The Essence of Heritage</h2>
                        <a href="{{ route('v5.all-products') }}" class="af-btn">Discover Now</a>
                    </div>
                </div>
            @endif
        </div>
        <div class="af-slider-dots">
            @foreach($sliders as $index => $slide)
                <div class="af-dot {{ $index == 0 ? 'active' : '' }}" onclick="setSlide({{ $index }})"></div>
            @endforeach
        </div>
    </div>

    <!-- Featured Categories -->
    <section class="af-section">
        <div class="container">
            <div class="af-cat-grid">
                @foreach($collections->take(3) as $collection)
                    <a href="{{ route('v5.collection', ['slug' => $collection->slug]) }}" class="af-cat-card">
                        <div class="af-cat-img">
                            <img src="{{ $collection->image ? asset('storage/' . $collection->image) : asset('Images/g-load.webp') }}" alt="{{ $collection->name }}">
                        </div>
                        <h3>{{ $collection->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Bestsellers -->
    <section class="af-section" style="background: var(--af-light);">
        <div class="container">
            <h2 class="af-section-title">Our Bestsellers</h2>
            <div class="af-product-grid">
                @foreach($products->take(4) as $product)
                    @include('v5.partials.product_card', ['product' => $product])
                @endforeach
            </div>
            <div style="text-align: center; margin-top: 50px;">
                <a href="{{ route('v5.all-products') }}" class="af-btn-outline">View All Perfumes</a>
            </div>
        </div>
    </section>

    <!-- Narrative Section -->
    <section class="af-narrative">
        <div class="af-narrative-img">
            <img src="{{ asset('Images/afnan_narrative_banner.png') }}" alt="Afnan Narrative">
        </div>
        <div class="af-narrative-text">
            <div class="af-narrative-box">
                <span class="af-subtitle">Premium Craftsmanship</span>
                <h2 class="serif">Elegance in Every Drop</h2>
                <p>Designed for those who appreciate the finer things in life, our fragrances are a blend of traditional expertise and modern innovation.</p>
                <a href="{{ route('v5.all-products') }}" class="af-btn-dark">Explore Collection</a>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="af-section">
        <div class="container">
            <h2 class="af-section-title">New Arrivals</h2>
            <div class="af-product-grid">
                @foreach($products->skip(4)->take(4) as $product)
                    @include('v5.partials.product_card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <!-- Brand Values Marquee -->
    <div class="af-marquee-bar">
        <div class="af-marquee-inner">
            <span>&bull; WORLDWIDE SHIPPING &bull; 100% AUTHENTIC FRAGRANCES &bull; PREMIUM CRAFTSMANSHIP &bull; LUXURY REDEFINED &bull; </span>
            <span>&bull; WORLDWIDE SHIPPING &bull; 100% AUTHENTIC FRAGRANCES &bull; PREMIUM CRAFTSMANSHIP &bull; LUXURY REDEFINED &bull; </span>
        </div>
    </div>

    <!-- Lifestyle Gallery -->
    <section class="af-section">
        <div class="container">
            <h2 class="af-section-title">Follow the Journey</h2>
            <div class="af-insta-grid">
                <div class="af-insta-item"><img src="https://india.afnan.com/cdn/shop/files/insta_1.jpg" onerror="this.src='https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=600'" alt="Insta 1"></div>
                <div class="af-insta-item"><img src="https://india.afnan.com/cdn/shop/files/insta_2.jpg" onerror="this.src='https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&q=80&w=600'" alt="Insta 2"></div>
                <div class="af-insta-item"><img src="https://india.afnan.com/cdn/shop/files/insta_3.jpg" onerror="this.src='https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&q=80&w=600'" alt="Insta 3"></div>
                <div class="af-insta-item"><img src="https://india.afnan.com/cdn/shop/files/insta_4.jpg" onerror="this.src='https://images.unsplash.com/photo-1615484477778-ca3b77940c25?auto=format&fit=crop&q=80&w=600'" alt="Insta 4"></div>
                <div class="af-insta-item"><img src="https://india.afnan.com/cdn/shop/files/insta_5.jpg" onerror="this.src='https://images.unsplash.com/photo-1592914610354-fd354ea45e48?auto=format&fit=crop&q=80&w=600'" alt="Insta 5"></div>
            </div>
        </div>
    </section>

    <style>
        /* Marquee */
        .af-marquee-bar { background: #000; color: #fff; padding: 20px 0; overflow: hidden; white-space: nowrap; border-top: 1px solid #222; border-bottom: 1px solid #222; }
        .af-marquee-inner { display: inline-block; animation: marquee 20s linear infinite; }
        .af-marquee-inner span { font-size: 14px; font-weight: 700; letter-spacing: 3px; margin-right: 50px; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* Insta Grid */
        .af-insta-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; }
        .af-insta-item { aspect-ratio: 1; overflow: hidden; position: relative; }
        .af-insta-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; filter: grayscale(100%); }
        .af-insta-item:hover img { transform: scale(1.1); filter: grayscale(0%); }
        .af-insta-item::after { content: '\f16d'; font-family: 'Font Awesome 6 Brands'; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 24px; opacity: 0; transition: 0.3s; }
        .af-insta-item:hover::after { opacity: 1; }

        @media (max-width: 991px) {
            .af-insta-grid { grid-template-columns: repeat(3, 1fr); }
            .af-insta-item:nth-child(n+4) { display: none; }
        }
    </style>
            <div class="af-product-grid">
                @foreach($products->skip(4)->take(4) as $product)
                    @include('v5.partials.product_card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <style>
        /* Hero */
        .af-hero { position: relative; height: 90vh; background: #000; overflow: hidden; }
        .af-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: 1s ease-in-out; }
        .af-slide.active { opacity: 1; z-index: 1; }
        .af-slide img { width: 100%; height: 100%; object-fit: cover; }
        
        .af-hero-content { position: absolute; bottom: 100px; left: 50%; transform: translateX(-50%); text-align: center; color: #fff; z-index: 2; width: 100%; }
        .af-hero-content h2 { font-size: 60px; margin-bottom: 30px; letter-spacing: 2px; }
        
        .af-btn { display: inline-block; padding: 18px 45px; background: #fff; color: #000; text-decoration: none; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; border-radius: 2px; transition: 0.3s; }
        .af-btn:hover { background: var(--af-red); color: #fff; }

        .af-btn-outline { display: inline-block; padding: 15px 40px; border: 1px solid #000; color: #000; text-decoration: none; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; transition: 0.3s; }
        .af-btn-outline:hover { background: #000; color: #fff; }

        .af-slider-dots { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 10px; z-index: 2; }
        .af-dot { width: 30px; height: 2px; background: rgba(255,255,255,0.3); cursor: pointer; transition: 0.3s; }
        .af-dot.active { background: #fff; }

        /* Category Grid */
        .af-cat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .af-cat-card { text-decoration: none; color: inherit; text-align: center; }
        .af-cat-img { aspect-ratio: 1; overflow: hidden; margin-bottom: 20px; background: var(--af-light); }
        .af-cat-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s; }
        .af-cat-card:hover .af-cat-img img { transform: scale(1.05); }
        .af-cat-card h3 { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; }

        /* Product Grid */
        .af-product-grid { display: grid; grid-template-columns: repeat(4, 1fr); border-top: 1px solid var(--af-border); border-left: 1px solid var(--af-border); }

        /* Narrative */
        .af-narrative { display: grid; grid-template-columns: 1.2fr 0.8fr; height: 700px; background: #fff; }
        .af-narrative-img img { width: 100%; height: 100%; object-fit: cover; }
        .af-narrative-text { display: flex; align-items: center; justify-content: center; padding: 100px; }
        .af-narrative-box { max-width: 400px; }
        .af-subtitle { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--af-red); margin-bottom: 20px; }
        .af-narrative-box h2 { font-size: 42px; margin-bottom: 25px; line-height: 1.2; }
        .af-narrative-box p { font-size: 15px; color: var(--af-gray); margin-bottom: 40px; line-height: 1.8; }
        
        .af-btn-dark { display: inline-block; padding: 15px 40px; background: #000; color: #fff; text-decoration: none; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; }

        @media (max-width: 1024px) {
            .af-product-grid { grid-template-columns: repeat(2, 1fr); }
            .af-narrative { grid-template-columns: 1fr; height: auto; }
            .af-hero-content h2 { font-size: 36px; }
        }
        @media (max-width: 600px) {
            .af-cat-grid { grid-template-columns: 1fr; }
            .af-hero { height: 70vh; }
        }
    </style>

    <script>
        let cur = 0;
        const total = {{ $sliders->count() ?: 1 }};
        function setSlide(n) {
            $('.af-slide').removeClass('active');
            $('.af-dot').removeClass('active');
            $('.af-slide').eq(n).addClass('active');
            $('.af-dot').eq(n).addClass('active');
            cur = n;
        }
        function auto() {
            cur = (cur + 1) % total;
            setSlide(cur);
        }
        if(total > 1) setInterval(auto, 5000);
    </script>
@endsection
