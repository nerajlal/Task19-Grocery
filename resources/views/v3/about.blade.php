@extends('v3.layouts.app')

@section('title', 'About Us - Task19 Perfumes')
<!-- {{ asset('Images/about-store.webp') }} -->
@push('styles')
<style>
    .about-hero {
        position: relative;
        height: 60vh;
        min-height: 400px;
        background-image: url('{{ asset('Images/about-store.webp') }}');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.5);
    }

    .hero-content {
        position: relative;
        color: var(--white);
        text-align: center;
        padding: 20px;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .hero-subtitle {
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .about-section {
        padding: 80px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .story-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 50px;
        align-items: center;
    }

    .story-content h2 {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        margin-bottom: 30px;
        color: var(--black);
    }

    .story-text {
        font-size: 16px;
        color: var(--text);
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 80px;
        text-align: center;
    }

    .value-card {
        padding: 40px 20px;
        background: var(--bg-light);
        border-radius: 20px;
        transition: transform 0.3s;
    }

    .value-card:hover {
        transform: translateY(-5px);
    }

    .value-icon {
        font-size: 40px;
        margin-bottom: 20px;
        color: var(--black);
    }

    .value-title {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--black);
    }

    .value-text {
        font-size: 14px;
        color: var(--text-light);
        line-height: 1.6;
    }

    @media (min-width: 768px) {
        .story-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .values-grid {
            grid-template-columns: 1fr;
        }
        .hero-title {
            font-size: 36px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="about-hero">
        <div class="hero-content">
            <h1 class="hero-title">Our Story</h1>
            <p class="hero-subtitle">Crafting India's finest fragrances with passion, expertise, and a touch of magic.</p>
        </div>
    </div>

    <!-- Brand Story -->
    <section class="about-section">
        <div class="story-grid">
            <div class="story-image">
                <img src="{{ asset('Images/about-store.webp') }}" alt="xxxx Store" style="width: 100%; border-radius: 20px;">
            </div>
            <div class="story-content">
                <h2>Why We Do, What We Do</h2>
                <p class="story-text">
                    Task19 Perfumes was born from a simple yet profound desire: to bring the art of high-quality perfumery to everyone. We believe that a fragrance is more than just a scent; it's a memory, an emotion, and a personal statement.
                </p>
                <p class="story-text">
                    As India's pioneering perfume bar, we combine traditional expertise with modern science. Our fragrances are crafted with a remarkable <strong>50% fragrance oil concentration</strong>, ensuring they linger on your skin and in the air, perfectly adapted to tropical climates.
                </p>
                <p class="story-text">
                    Every bottle tells a story of craftsmanship, dedication, and the pursuit of excellence. We invite you to find your signature scent with us.
                </p>
            </div>
        </div>

        <!-- Values -->
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon"><i class="fas fa-gem"></i></div>
                <h3 class="value-title">Premium Quality</h3>
                <p class="value-text">Sourced from the finest ingredients, our perfumes offer luxury that you can wear every day.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i class="fas fa-flask"></i></div>
                <h3 class="value-title">Expertly Crafted</h3>
                <p class="value-text">Our 50% oil concentration formula is scientifically designed for longevity and projection.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i class="fas fa-users"></i></div>
                <h3 class="value-title">Customer First</h3>
                <p class="value-text">From our store experience to online support, we are dedicated to helping you find your perfect match.</p>
            </div>
        </div>
    </section>
@endsection
