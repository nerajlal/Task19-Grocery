@extends('v3.layouts.app')

@section('title', 'India\'s First Perfume Bar')

@push('styles')
<style>
    /* Hero Slider */
    .hero-slider { position: relative; width: 100%; height: 500px; overflow: hidden; }
    .slide { position: absolute; inset: 0; opacity: 0; transition: opacity 1s ease; }
    .slide.active { opacity: 1; }
    .slide img { width: 100%; height: 100%; object-fit: cover; object-position: center; }
    .slider-dots { position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10; }
    .dot { width: 8px; height: 8px; background: rgba(255,255,255,0.5); border-radius: 50%; cursor: pointer; transition: background 0.3s; }
    .dot.active { background: var(--white); }

    /* Common Section */
    .section { padding: 40px 15px; max-width: 1200px; margin: 0 auto; }
    .section-header { text-align: center; margin-bottom: 30px; }
    .section-title { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: var(--black); }
    .section-title em { font-style: italic; font-weight: 400; font-family: 'Playfair Display', serif; }

    /* Product Grid */
    .product-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .product-card { background: var(--white); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: all 0.4s ease; text-decoration: none; color: inherit; display: block; border: 1px solid var(--border); }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(0,0,0,0.08); border-color: var(--gold); }
    .product-image-wrapper { position: relative; aspect-ratio: 1; background: var(--bg-light); overflow: hidden; }
    .product-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .product-card:hover .product-image { transform: scale(1.08); }
    .product-badge { position: absolute; top: 15px; left: 15px; background: var(--white); color: var(--black); padding: 5px 12px; border-radius: 30px; font-size: 10px; font-weight: 800; text-transform: uppercase; z-index: 1; box-shadow: 0 4px 10px rgba(0,0,0,0.1); letter-spacing: 0.5px; }
    .product-info { padding: 15px 12px; text-align: center; }
    .product-name { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 700; margin-bottom: 4px; color: var(--black); letter-spacing: -0.3px; line-height: 1.3; }
    .product-price { font-size: 15px; font-weight: 700; color: var(--dark-gold); display: flex; align-items: center; justify-content: center; gap: 8px; }
    .compare-price { font-size: 12px; color: var(--text-light); text-decoration: line-through; font-weight: 500; }
    .product-price span { font-weight: 500; color: var(--text-light); font-size: 12px; margin-right: 5px; text-transform: uppercase; letter-spacing: 1px; }
    .view-all-btn { display: block; width: max-content; margin: 50px auto 0; padding: 14px 40px; background: transparent; color: var(--black); text-decoration: none; border-radius: 40px; font-weight: 700; font-size: 13px; transition: all 0.3s; border: 2px solid var(--black); text-transform: uppercase; letter-spacing: 1px; }
    .view-all-btn:hover { background: var(--black); color: var(--white); transform: translateY(-2px); }
    
    .add-btn { width: 100%; padding: 10px; background: var(--black); color: var(--white); border: none; border-radius: 10px; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s; margin-top: 10px; }
    .add-btn:hover { background: var(--gold); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    
    /* Toast Notification */
    .toast { position: fixed; bottom: 100px; left: 50%; transform: translateX(-50%) translateY(100px); background: var(--black); color: var(--white); padding: 12px 24px; border-radius: 25px; font-weight: 600; font-size: 14px; z-index: 2000; opacity: 0; transition: all 0.3s; pointer-events: none; }
    .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* Store Section */
    .store-section { 
        background: radial-gradient(circle at center, #2a2a2a 0%, #111 100%); 
        color: var(--white); 
        padding: 100px 20px; 
        text-align: center; 
        position: relative; 
        overflow: hidden; 
    }
    .store-count { 
        font-size: 150px; 
        font-weight: 900; 
        line-height: 1; 
        color: transparent; 
        -webkit-text-stroke: 1px rgba(255,255,255,0.05); 
        position: absolute; 
        top: 50%; left: 50%; transform: translate(-50%, -50%); 
        z-index: 0; pointer-events: none; 
    }
    .store-title { 
        font-family: 'Playfair Display', serif; 
        font-size: 42px; 
        margin-bottom: 15px; 
        position: relative; 
        z-index: 1; 
        color: var(--white); 
    }
    .store-subtitle { 
        color: var(--gold); 
        text-transform: uppercase; 
        letter-spacing: 4px; 
        margin-bottom: 35px; 
        font-size: 13px; 
        font-weight: 700; 
        position: relative; z-index: 1;
    }
    .store-btn { 
        display: inline-block; 
        background: transparent;
        border: 1px solid var(--gold); 
        color: var(--gold); 
        padding: 14px 40px; 
        text-decoration: none; 
        text-transform: uppercase; 
        font-size: 13px; 
        letter-spacing: 2px; 
        transition: all 0.3s; 
        margin-bottom: 40px; 
        position: relative; 
        z-index: 1; 
        font-weight: 600; 
        border-radius: 50px;
    }
    .store-btn:hover { 
        background: var(--gold); 
        color: var(--black); 
        box-shadow: 0 10px 30px rgba(197, 160, 89, 0.2); 
        transform: translateY(-3px);
    }
    .store-description { 
        max-width: 700px; 
        margin: 0 auto; 
        font-size: 16px; 
        opacity: 0.7; 
        line-height: 2; 
        position: relative; 
        z-index: 1; 
    }

    /* Collection Grid */
    .collection-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    
    .collection-card {
        position: relative;
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        aspect-ratio: 3/4;
        text-decoration: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
    }
    
    .collection-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .collection-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .collection-card:hover img {
        transform: scale(1.1);
    }
    
    .collection-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent 60%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 25px;
        color: var(--white);
        opacity: 0.9;
        transition: opacity 0.3s;
    }
    
    .collection-card:hover .collection-overlay {
        opacity: 1;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent 50%);
    }
    
    .collection-name {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 5px;
        transform: translateY(0);
        transition: transform 0.3s;
    }
    
    .collection-desc {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        font-weight: 500;
        margin-top: 5px;
        transform: translateY(10px);
        opacity: 0;
        transition: all 0.3s;
    }
    
    .collection-card:hover .collection-desc {
        transform: translateY(0);
        opacity: 1;
    }
    
    @media (max-width: 900px) {
        .collection-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    }

    /* Cosmopolitan */
    .cosmopolitan-section { background: #111; padding: 80px 20px; color: var(--white); text-align: center; }
    .cosmo-header { margin-bottom: 50px; }
    .cosmo-title { font-family: 'Playfair Display', serif; font-size: 36px; color: var(--gold); margin-bottom: 15px; }
    .cosmo-subtitle { font-size: 15px; opacity: 0.7; max-width: 500px; margin: 0 auto; line-height: 1.6; }
    .cosmopolitan-section .product-card { background: #222; color: var(--white); border: 1px solid #333; }
    .cosmopolitan-section .product-image-wrapper { background: #1a1a1a; }
    .cosmopolitan-section .product-name { color: var(--white); }
    .cosmopolitan-section .product-price { color: var(--gold); }
    .cosmopolitan-section .product-price span { color: rgba(255,255,255,0.4); }

    /* Video Section */
    .video-section { position: relative; width: 100%; height: 60vh; overflow: hidden; }
    .video-section video { width: 100%; height: 100%; object-fit: cover; }
    .video-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; }
    .video-text { font-family: 'Playfair Display', serif; font-size: 36px; color: var(--white); font-weight: 700; text-align: center; padding: 20px; line-height: 1.2; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }

    /* Gender Carousel */
    /* Gender Grid */
    .gender-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .gender-card {
        position: relative;
        height: 500px;
        border-radius: 24px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .gender-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }

    .gender-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .gender-card:hover img {
        transform: scale(1.08); /* Enhance zoom */
    }

    .gender-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.6) 0%, transparent 50%); /* Softer gradient */
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 40px;
        opacity: 0.9;
        transition: opacity 0.3s;
    }

    .gender-card:hover .gender-overlay {
        opacity: 1;
        background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, transparent 60%);
    }

    .gender-title {
        color: var(--white);
        font-family: 'Playfair Display', serif;
        font-size: 28px; /* Larger title */
        font-weight: 700;
        letter-spacing: 1px;
        text-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    /* Mobile Adjustment */
    @media (max-width: 768px) {
        .gender-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        .gender-card {
            height: 350px;
        }
    }

    /* Testimonials */
    .testimonials { background: var(--bg-light); padding: 100px 20px; }
    .testimonial-slider { display: flex; overflow-x: auto; gap: 30px; padding: 20px 10px 40px; scrollbar-width: none; -ms-overflow-style: none; scroll-snap-type: x mandatory; }
    .testimonial-slider::-webkit-scrollbar { display: none; }
    .testimonial-card { 
        min-width: 350px; 
        background: var(--white); 
        padding: 50px 35px; 
        border-radius: 24px; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.03); 
        border: 1px solid var(--border); 
        scroll-snap-align: center; 
        position: relative; 
        display: flex; 
        flex-direction: column; 
        justify-content: center; 
        align-items: center; 
        text-align: center; 
        transition: transform 0.3s;
    }
    .testimonial-card:hover { transform: translateY(-5px); box-shadow: 0 15px 50px rgba(0,0,0,0.06); }
    .testimonial-card::before { 
        content: '\201C'; 
        font-family: 'Playfair Display', serif; 
        font-size: 80px; 
        color: var(--gold); 
        opacity: 0.2; 
        line-height: 1; 
        margin-bottom: -40px; 
    }
    .testimonial-text { 
        font-family: 'Playfair Display', serif; 
        font-size: 20px; 
        line-height: 1.6; 
        margin-bottom: 30px; 
        color: var(--black); 
        font-style: italic; 
    }
    .testimonial-author { 
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; 
        color: var(--black); 
        font-size: 13px; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        margin-bottom: 5px; 
    }
    .testimonial-location { 
        font-size: 11px; 
        color: var(--text-light); 
        text-transform: uppercase; 
        letter-spacing: 1px; 
    }

    /* Popup */
    .popup-newsletter { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.9); background: var(--white); padding: 50px; border-radius: 20px; text-align: center; max-width: 450px; width: 90%; z-index: 2000; opacity: 0; pointer-events: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .popup-newsletter.active { opacity: 1; transform: translate(-50%, -50%) scale(1); pointer-events: all; }
    .popup-close { position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 30px; cursor: pointer; color: #ccc; transition: color 0.3s; }
    .popup-close:hover { color: var(--black); }
    .popup-tag { font-size: 13px; font-weight: 700; color: var(--gold); letter-spacing: 2px; margin-bottom: 15px; text-transform: uppercase; }
    .popup-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; line-height: 1.2; margin-bottom: 8px; color: var(--black); }
    .popup-subtitle { font-size: 14px; letter-spacing: 3px; margin-bottom: 25px; font-weight: 600; color: var(--text-light); }
    .popup-code { background: #fafafa; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 2px dashed var(--gold); }
    .popup-code-text { font-size: 11px; font-weight: 700; color: var(--text-light); margin-bottom: 5px; text-transform: uppercase; }
    .popup-code-value { font-size: 24px; font-weight: 900; color: var(--black); letter-spacing: 2px; }

    /* Newsletter Form */
    .newsletter-form { display: flex; align-items: center; background: #f9f9f9; padding: 5px; border-radius: 30px; border: 1px solid #eee; }
    .newsletter-input { flex: 1; border: none; background: transparent; padding: 12px 20px; outline: none; font-size: 14px; color: #333; }
    .newsletter-btn { background: var(--black); color: var(--white); border: none; padding: 12px 30px; border-radius: 25px; font-weight: 700; cursor: pointer; font-size: 13px; letter-spacing: 1px; transition: background 0.3s; }
    .newsletter-btn:hover { background: var(--gold); }

    /* Press */
    .press-section { text-align: center; padding: 60px 20px; border-top: 1px solid var(--border); background: var(--bg-light); }
    .press-title { font-family: 'Playfair Display', serif; font-size: 24px; margin-bottom: 40px; color: var(--black); }
    .press-slider { display: flex; justify-content: center; gap: 50px; align-items: center; flex-wrap: wrap; opacity: 0.6; }
    .press-logo { height: 30px; object-fit: contain; filter: grayscale(100%); transition: filter 0.3s, opacity 0.3s; }
    .press-logo:hover { filter: grayscale(0%); opacity: 1; }

    /* About Section */
    .about-section { display: grid; gap: 40px; padding: 80px 20px; align-items: center; max-width: 1200px; margin: 0 auto; }
    .about-image img { width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .about-title { font-family: 'Playfair Display', serif; font-size: 42px; margin-bottom: 25px; line-height: 1.2; color: var(--black); }
    .about-text { margin-bottom: 25px; line-height: 1.9; color: var(--text-light); font-size: 16px; }
    .about-text strong { color: var(--black); }
    .about-btn { display: inline-block; background: var(--black); color: var(--white); padding: 14px 35px; border-radius: 30px; text-decoration: none; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: transform 0.3s; }
    .about-btn:hover { transform: translateY(-3px); background: var(--gold); }

    /* Features */
    .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; padding: 60px 20px; border-top: 1px solid var(--border); text-align: center; background: var(--white); max-width: 1200px; margin: 0 auto; }
    .feature { padding: 20px; transition: transform 0.3s; }
    .feature:hover { transform: translateY(-5px); }
    .feature-icon { font-size: 36px; margin-bottom: 20px; color: var(--gold); }
    .feature-title { font-weight: 700; font-size: 14px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; color: var(--black); }
    .feature-text { font-size: 13px; color: var(--text-light); line-height: 1.6; }

    /* Mobile Features */
    @media (max-width: 768px) {
        .features {
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 30px 10px;
        }
        
        .feature {
            padding: 5px;
        }
        
        .feature-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .feature-title {
            font-size: 10px;
            margin-bottom: 5px;
        }

        .feature-text {
            font-size: 9px;
            line-height: 1.3;
            padding: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    }

    /* Desktop Media Queries */
    @media (min-width: 768px) {
        .section { padding: 80px 20px; }
        .hero-slider { height: 90vh; }
        .product-grid { grid-template-columns: repeat(4, 1fr); gap: 30px; }
        .category-grid { grid-template-columns: repeat(4, 1fr); }
        .blog-grid { grid-template-columns: repeat(3, 1fr); }
        .about-section { grid-template-columns: 1fr 1fr; gap: 80px; }
        .video-text { font-size: 56px; }
        .section-title { font-size: 42px; }
        .store-count { font-size: 160px; margin-bottom: -55px; }
        .store-title { font-size: 48px; }
    }

    /* Social Proof Tag */
    .social-proof-tag {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        color: var(--black);
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 2;
        border: 1px solid rgba(197, 160, 89, 0.2);
        transition: all 0.4s ease;
    }
    .product-card:hover .social-proof-tag, .collection-card:hover .social-proof-tag {
        transform: translateX(-50%) translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    .social-proof-tag i { color: var(--dark-gold); font-size: 10px; }
    .social-proof-tag.collection-tag {
        bottom: auto;
        top: 15px;
        left: 15px;
        transform: none;
    }
    .collection-card:hover .social-proof-tag.collection-tag {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')

    <!-- Hero Slider -->
    <div class="hero-slider">
        @forelse($sliders as $key => $slider)
        <div class="slide {{ $key == 0 ? 'active' : '' }}">
            <picture>
                <source media="(max-width: 768px)" srcset="{{ Storage::url($slider->image_mobile) }}">
                <img src="{{ Storage::url($slider->image_desktop) }}" alt="{{ $slider->title ?? 'Task19 Perfumes' }}">
            </picture>
        </div>
        @empty
        <div class="slide active">
            <picture>
                <source media="(max-width: 768px)" srcset="{{ asset('Images/Banner/Mobile.png') }}">
                <img src="{{ asset('Images/Banner/Desktop.png') }}" alt="Default Slider">
            </picture>
        </div>
        @endforelse
        
        @if($sliders->count() > 1)
        <div class="slider-dots">
            @foreach($sliders as $key => $slider)
            <div class="dot {{ $key == 0 ? 'active' : '' }}" data-slide="{{ $key }}"></div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Bestsellers -->
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Discover <em>Our Bestsellers</em></h2>
        </div>
        <div class="product-grid">
            @forelse($bestsellers as $item)
                @if($item->product)
                <a href="{{ route('v3.product', ['id' => $item->product->id]) }}" class="product-card">
                    <div class="product-image-wrapper">
                        <!-- Create a fresh/new badge logic for 7 days -->
                        @if($item->product->created_at->diffInDays(now()) < 7)
                            <span class="product-badge">New</span>
                        @endif
                        
                        @if($item->product->main_image_url)
                            <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product->title }}" class="product-image" onerror="handleImageError(this)">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light text-secondary">
                                <i class="fas fa-image fa-2x opacity-25"></i>
                            </div>
                        @endif

                        <div class="social-proof-tag">
                            <i class="fas fa-fire"></i>
                            <span>{{ rand(45, 180) }} bought this last week</span>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $item->product->title }}</h3>
                        <p class="product-price">
                            @if($item->product->compare_at_price > $item->product->starting_price)
                                <span class="compare-price">₹{{ number_format($item->product->compare_at_price, 0) }}</span>
                            @endif
                            <span>From</span> ₹{{ number_format($item->product->starting_price, 0) }}
                        </p>
                        <button class="add-btn" onclick="event.preventDefault(); addToCart({{ $item->product->id }}, '{{ $item->product->title }}', this, 'product')">Add to Cart</button>
                    </div>
                </a>
                @endif
            @empty
                <!-- Fallback Static Content if DB is empty -->
                <a href="javascript:void(0)" class="product-card">
                    <div class="product-image-wrapper">
                        <span class="product-badge">New</span>
                        <img src="{{ asset('Images/def_img.webp') }}" alt="Product 1" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Product 1</h3>
                        <p class="product-price"><span>From</span> ₹1,129</p>
                    </div>
                </a>
                 <a href="javascript:void(0)" class="product-card">
                    <div class="product-image-wrapper">
                        <span class="product-badge">New</span>
                         <img src="{{ asset('Images/def_img.webp') }}" alt="Product 2" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Product 2</h3>
                        <p class="product-price"><span>From</span> ₹1,129</p>
                    </div>
                </a>
                 <a href="javascript:void(0)" class="product-card">
                    <div class="product-image-wrapper">
                        <span class="product-badge">New</span>
                         <img src="{{ asset('Images/def_img.webp') }}" alt="Product 3" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Product 3</h3>
                        <p class="product-price"><span>From</span> ₹1,129</p>
                    </div>
                </a>
                 <a href="javascript:void(0)" class="product-card">
                    <div class="product-image-wrapper">
                        <span class="product-badge">New</span>
                         <img src="{{ asset('Images/def_img.webp') }}" alt="Product 4" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Product 4</h3>
                        <p class="product-price"><span>From</span> ₹1,129</p>
                    </div>
                </a>
            @endforelse
        </div>
        <a href="{{ route('v3.all-products') }}" class="view-all-btn">View All Perfumes</a>
    </section>

    <!-- Store Section -->
    <div class="store-section" id="stores">
        <!-- <div class="store-count">60</div> -->
        <h2 class="store-title">Stores Near You</h2>
        <p class="store-subtitle">Find a store near you</p>
        <a href="#" class="store-btn">Locate Stores</a>
        <p class="store-description">
            Task19 Perfumes is India's pioneering perfume brand offering top-notch, value for money fragrances with exceptional expertise in the art & science of perfumery.
        </p>
    </div>

    <!-- Our Fragrances -->
    <section class="section" id="signature">
        <div class="section-header">
            <h2 class="section-title">Our <em>Collections</em></h2>
        </div>
        <div class="collection-grid">
            @forelse($collections as $collection)
            <a href="{{ route('v3.collection', ['category' => $collection->slug]) }}" class="collection-card">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($collection->image) }}" alt="{{ $collection->name }}" onerror="handleImageError(this)">
                <div class="social-proof-tag collection-tag">
                    <i class="fas fa-heart"></i>
                    <span>{{ rand(1, 5) }}.{{ rand(1, 9) }}k people like this</span>
                </div>
                <div class="collection-overlay">
                    <h3 class="collection-name">{{ $collection->name }}</h3>
                    <p class="collection-desc">{{ $collection->description }}</p>
                </div>
            </a>
            @empty
            <!-- Fallback if empty -->
            <a href="javascript:void(0)" class="collection-card">
                <img src="{{ asset('Images/def_img.webp') }}" alt="Fresh" onerror="handleImageError(this)">
                <div class="social-proof-tag collection-tag">
                    <i class="fas fa-heart"></i>
                    <span>{{ rand(1, 5) }}.{{ rand(1, 9) }}k people like this</span>
                </div>
                <div class="collection-overlay">
                    <h3 class="collection-name">FRESH</h3>
                    <p class="collection-desc">Crisp & Invigorating</p>
                </div>
            </a>
            <a href="javascript:void(0)" class="collection-card">
                <img src="{{ asset('Images/def_img.webp') }}" alt="Oriental" onerror="handleImageError(this)">
                <div class="social-proof-tag collection-tag">
                    <i class="fas fa-heart"></i>
                    <span>{{ rand(1, 5) }}.{{ rand(1, 9) }}k people like this</span>
                </div>
                <div class="collection-overlay">
                    <h3 class="collection-name">ORIENTAL</h3>
                    <p class="collection-desc">Warm & Spicy</p>
                </div>
            </a>
            <a href="javascript:void(0)" class="collection-card">
                <img src="{{ asset('Images/def_img.webp') }}" alt="Floral" onerror="handleImageError(this)">
                <div class="social-proof-tag collection-tag">
                    <i class="fas fa-heart"></i>
                    <span>{{ rand(1, 5) }}.{{ rand(1, 9) }}k people like this</span>
                </div>
                <div class="collection-overlay">
                    <h3 class="collection-name">FLORAL</h3>
                    <p class="collection-desc">Soft & Romantic</p>
                </div>
            </a>
            <a href="javascript:void(0)" class="collection-card">
                <img src="{{ asset('Images/def_img.webp') }}" alt="Citrus" onerror="handleImageError(this)">
                <div class="social-proof-tag collection-tag">
                    <i class="fas fa-heart"></i>
                    <span>{{ rand(1, 5) }}.{{ rand(1, 9) }}k people like this</span>
                </div>
                <div class="collection-overlay">
                    <h3 class="collection-name">CITRUS</h3>
                    <p class="collection-desc">Zesty & Bright</p>
                </div>
            </a>
            @endforelse
        </div>
    </section>

    <!-- Cosmopolitan / Bundles -->
    <div class="cosmopolitan-section" id="cosmopolitan">
        <div class="cosmo-header">
            <h2 class="cosmo-title"><em>Exclusive Combo Offers</em></h2>
            <p class="cosmo-subtitle">Discover our curated bundles and save more on your favorite scents.</p>
        </div>
        <div class="product-grid">
            @forelse($bundles as $bundle)
            <a href="{{ route('v3.combo', ['id' => $bundle->id]) }}" class="product-card">
                <div class="product-image-wrapper">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($bundle->image) }}" alt="{{ $bundle->title }}" class="product-image" onerror="handleImageError(this)">
                    @if($bundle->discount_value > 0)
                    <span class="product-badge" style="background: #d32f2f;">
                        {{ $bundle->discount_type == 'percentage' ? ' ' . number_format($bundle->discount_value) . '%' : 'SAVE ₹' . number_format($bundle->discount_value) }}
                    </span>
                    @endif

                    <div class="social-proof-tag">
                        <i class="fas fa-shopping-bag"></i>
                        <span>{{ rand(20, 80) }} people joined the squad</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $bundle->title }}</h3>
                    <p class="product-price">
                        @if($bundle->discount_value > 0)
                            <span class="compare-price">₹{{ number_format($bundle->base_price, 0) }}</span>
                        @endif
                        ₹{{ number_format($bundle->total_price, 0) }}
                    </p>
                    <button class="add-btn" onclick="event.preventDefault(); addToCart({{ $bundle->id }}, '{{ $bundle->title }}', this, 'bundle')">Add to Cart</button>
                </div>
            </a>
            @empty
            <!-- Static Fallback if no bundles -->
            <a href="javascript:void(0)" class="product-card">
                <div class="product-image-wrapper">
                    <img src="{{ asset('Images/def_img.webp') }}" alt="Bundle 1" class="product-image" onerror="handleImageError(this)">
                    <span class="product-badge" style="background: #d32f2f;">SAVE 20%</span>
                    <div class="social-proof-tag">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Popular Choice</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Bundle 1</h3>
                    <p class="product-price">₹1,999</p>
                </div>
            </a>
            <a href="javascript:void(0)" class="product-card">
                <div class="product-image-wrapper">
                    <img src="{{ asset('Images/def_img.webp') }}" alt="Bundle 2" class="product-image" onerror="handleImageError(this)">
                    <span class="product-badge" style="background: #d32f2f;">SAVE 20%</span>
                    <div class="social-proof-tag">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Popular Choice</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Bundle 2</h3>
                    <p class="product-price">₹1,999</p>
                </div>
            </a>
            <a href="javascript:void(0)" class="product-card">
                <div class="product-image-wrapper">
                    <img src="{{ asset('Images/def_img.webp') }}" alt="Bundle 3" class="product-image" onerror="handleImageError(this)">
                    <span class="product-badge" style="background: #d32f2f;">SAVE 20%</span>
                    <div class="social-proof-tag">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Popular Choice</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Bundle 3</h3>
                    <p class="product-price">₹1,999</p>
                </div>
            </a>
            <a href="javascript:void(0)" class="product-card">
                <div class="product-image-wrapper">
                    <img src="{{ asset('Images/def_img.webp') }}" alt="Bundle 4" class="product-image" onerror="handleImageError(this)">
                    <span class="product-badge" style="background: #d32f2f;">SAVE 20%</span>
                    <div class="social-proof-tag">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Popular Choice</span>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Bundle 4</h3>
                    <p class="product-price">₹1,999</p>
                </div>
            </a>
            @endforelse
        </div>
        <a href="{{ route('v3.combos') }}" class="view-all-btn" style="background: var(--gold);">View All Combos</a>
    </div>

    <!-- Video Section -->
    <div class="video-section">
        <video autoplay loop muted playsinline>
            <source src="https://myop.in/cdn/shop/videos/c/vp/d3c4018982b7463b856b22c551804e7d/d3c4018982b7463b856b22c551804e7d.HD-1080p-3.3Mbps-48643562.mp4?v=0" type="video/mp4">
        </video>
        <div class="video-overlay">
            <h2 class="video-text">A gift that lasts a lifetime</h2>
        </div>
    </div>

    <!-- Shop By Gender -->
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Shop By <em>Gender</em></h2>
        </div>
        <div class="gender-grid">
            <a href="{{ route('v3.collection', ['gender' => 'for-him']) }}" class="gender-card">
                <img src="{{ asset('Images/gender-him.webp') }}" alt="For Him">
                <div class="gender-overlay">
                    <h3 class="gender-title">For Him</h3>
                </div>
            </a>

            <a href="{{ route('v3.collection', ['gender' => 'for-her']) }}" class="gender-card">
                <img src="{{ asset('Images/gender-her.webp') }}" alt="For Her">
                <div class="gender-overlay">
                    <h3 class="gender-title">For Her</h3>
                </div>
            </a>

            <a href="{{ route('v3.collection', ['gender' => 'unisex']) }}" class="gender-card">
                <img src="{{ asset('Images/gender-unisex.webp') }}" alt="Unisex">
                <div class="gender-overlay">
                    <h3 class="gender-title">Unisex</h3>
                </div>
            </a>
        </div>
    </section>

    <!-- Testimonials -->
    <div class="testimonials">
        <div class="section-header">
            <h2 class="section-title">What Our <em>Customers Say</em></h2>
        </div>
        <div class="testimonial-slider">
            <div class="testimonial-card">
                <p class="testimonial-text">The fragrance is absolutely mesmerizing and stays with you all day. Truly a <em>premium experience</em> that stands out.</p>
                <p class="testimonial-author">— Ananya Iyer</p>
                <p class="testimonial-location">Mumbai</p>
            </div>

            <div class="testimonial-card">
                <p class="testimonial-text">I was looking for a unique gift, and xxxx was the perfect choice. The <em>packaging is as exquisite</em> as the scent itself.</p>
                <p class="testimonial-author">— Rahul Menon</p>
                <p class="testimonial-location">Kochi</p>
            </div>

            <div class="testimonial-card">
                <p class="testimonial-text">Finally found a perfume that matches my personality. Bold, distinct, and <em>incredibly long-lasting</em>. Highly recommended!</p>
                <p class="testimonial-author">— Priya Sharma</p>
                <p class="testimonial-location">Bangalore</p>
            </div>

            <div class="testimonial-card">
                <p class="testimonial-text">The quality is comparable to top international luxury brands but at a <em>much better price point</em>. My new go-to for fragrances.</p>
                <p class="testimonial-author">— Arjun Das</p>
                <p class="testimonial-location">Chennai</p>
            </div>
        </div>
    </div>

    <!-- Press -->
    <div class="press-section">
        <h2 class="press-title">As <em>seen</em> on</h2>
        <div class="press-slider">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Elle_Magazine.svg/1200px-Elle_Magazine.svg.png" alt="Elle" class="press-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Times_of_India_logo.svg/1200px-Times_of_India_logo.svg.png" alt="TOI" class="press-logo">
            <img src="https://cdn.worldvectorlogo.com/logos/vogue-logo.svg" alt="Vogue" class="press-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Elle_Magazine.svg/1200px-Elle_Magazine.svg.png" alt="Magazine" class="press-logo">
        </div>
    </div>

    <!-- About -->
    <div class="about-section" id="about">
        <div class="about-image">
            <img src="{{ asset('Images/about-store.webp') }}" alt="MYOP Store">
        </div>
        <div>
            <h2 class="about-title"><em>Why We Do,</em> What We Do</h2>
            <p class="about-text">Task19 Perfumes is India's first perfume brand known for <strong>high-quality, long-lasting</strong> fragrances with unparalleled expertise in the art and science of perfumery.</p>
            <p class="about-text">xxxx perfumes, reformulated with <strong>50% fragrance oil concentration</strong> last longer in tropical weather conditions.</p>
            <a href="{{ route('v3.about') }}" class="about-btn">Learn More</a>
        </div>
    </div>

    <!-- Blog -->
    <!-- <section class="section">
        <div class="section-header">
            <h2 class="section-title">From the <em>Journal</em></h2>
        </div>
        <div class="blog-grid">
            <div class="blog-card">
                <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=800&q=80" alt="Blog" class="blog-image">
                <div class="blog-content">
                    <p class="blog-date">Dec 03, 2025</p>
                    <h3 class="blog-title">Green Apple Used in Perfumes</h3>
                    <a href="/blog/green-apple" class="blog-link">Read more →</a>
                </div>
            </div>

            <div class="blog-card">
                <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?w=800&q=80" alt="Blog" class="blog-image">
                <div class="blog-content">
                    <p class="blog-date">Nov 26, 2025</p>
                    <h3 class="blog-title">Sandalwood - The Instant Wood Fragrance</h3>
                    <a href="/blog/sandalwood" class="blog-link">Read more →</a>
                </div>
            </div>

            <div class="blog-card">
                <img src="https://images.unsplash.com/photo-1587556930832-5e67d85c8f05?w=800&q=80" alt="Blog" class="blog-image">
                <div class="blog-content">
                    <p class="blog-date">Nov 22, 2025</p>
                    <h3 class="blog-title">October Newsletter</h3>
                    <a href="/blog/newsletter" class="blog-link">Read more →</a>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Features -->
    <div class="features">
        <div class="feature">
            <div class="feature-icon"><i class="fas fa-truck"></i></div>
            <h3 class="feature-title">Free Shipping</h3>
            <p class="feature-text">Free shipping on orders above ₹399 across India</p>
        </div>

        <div class="feature">
            <div class="feature-icon"><i class="fas fa-undo"></i></div>
            <h3 class="feature-title">Easy Returns</h3>
            <p class="feature-text">Simple return process with the perfumes</p>
        </div>

        <div class="feature">
            <div class="feature-icon"><i class="fas fa-lock"></i></div>
            <h3 class="feature-title">Secure Payment</h3>
            <p class="feature-text">Your payment information is processed securely</p>
        </div>
    </div>

    <!-- Popup Newsletter -->
    <div class="menu-overlay" id="popupOverlay"></div>
    <div class="popup-newsletter" id="popup">
        <button class="popup-close" onclick="closePopup()">×</button>
        <p class="popup-tag">First Time?</p>
        <h2 class="popup-title">JOIN THE <em>#SCENTSQUAD</em></h2>
        <p class="popup-subtitle">AND GET 20% OFF!</p>
        <div class="popup-code">
            <p class="popup-code-text">USE CODE:</p>
            <p class="popup-code-value">FIRSTSCENT20</p>
        </div>
        </form>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">Added to cart! 🎉</div>

@endsection

@push('scripts')
<script>
    // Image Fallback
    function handleImageError(img) {
        if (!img.getAttribute('data-error-handled')) {
            img.setAttribute('data-error-handled', 'true');
            img.src = '{{ asset("Images/g-load.webp") }}';
        }
    }

    // Hero Slider
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    if (slides.length > 0) {
        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        setInterval(nextSlide, 4000);

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                currentSlide = i;
                showSlide(i);
            });
        });
    }

    // Popup
    setTimeout(() => {
        const popup = document.getElementById('popup');
        const alertOverlay = document.getElementById('popupOverlay');
        if(popup && alertOverlay) {
            popup.classList.add('active');
            alertOverlay.classList.add('active');
        }
    }, 5000);

    function closePopup() {
        const popup = document.getElementById('popup');
        const alertOverlay = document.getElementById('popupOverlay');
        if(popup) popup.classList.remove('active');
        if(alertOverlay) alertOverlay.classList.remove('active');
    }

    const alertOverlay = document.getElementById('popupOverlay');
    if(alertOverlay) alertOverlay.addEventListener('click', closePopup);

    function addToCart(id, title, btn, type = 'product') {
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '...';

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: id,
                quantity: 1,
                type: type
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const toast = document.getElementById('toast');
                if(toast) {
                    toast.textContent = (title || 'Item') + ' added to cart!';
                    toast.classList.add('show');
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 2500);
                }
                
                if(navigator.vibrate) navigator.vibrate(50);
                
                const cartBadge = document.querySelector('.cart-count'); 
                if(cartBadge) {
                    cartBadge.innerText = data.cartCount;
                    cartBadge.style.display = 'flex';
                }
            } else {
                alert(data.message || 'Error adding to cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
</script>
@endpush
