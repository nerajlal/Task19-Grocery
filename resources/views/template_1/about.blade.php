@extends('layouts.storefront')

@section('title', 'Our Legacy | VESPR Perfumes')

@section('content')
<div class="about-hero">
    <div class="about-hero-content">
        <span class="eyebrow">The Essence of Excellence</span>
        <h1 class="about-title">Crafting Memories <br> Through Scent</h1>
        <p class="about-subtitle">A journey from the world's finest flower fields to your skin. VESPR Perfumes is more than a fragrance house—it's a tribute to the art of fine living.</p>
    </div>
</div>

<div class="about-container">
    <!-- Our Philosophy Section -->
    <section class="about-section philosophy">
        <div class="section-grid">
            <div class="section-image">
                <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&q=80&w=800" alt="Artisanal Extraction">
            </div>
            <div class="section-text">
                <span class="section-badge">Our Philosophy</span>
                <h2 class="h1">The Alchemy of Nature</h2>
                <p>VESPR Perfumes was born from a singular vision: to bridge the gap between traditional artisanal perfumery and the modern desire for unique, long-lasting signatures.</p>
                <p>We don't just sell perfumes; we curate olfactory experiences. Every raw material is ethically sourced, from the petals of Grasse to the precious woods of the East, ensuring that every drop remains true to its heritage.</p>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="stat-num">100%</span>
                        <span class="stat-label">Natural Oils</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">48h</span>
                        <span class="stat-label">Lasting Power</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- The Process Section -->
    <section class="about-section process inverted">
        <div class="section-grid">
            <div class="section-text">
                <span class="section-badge">The Process</span>
                <h2 class="h1">Meticulous Craftsmanship</h2>
                <p>Each fragrance undergoes a rigorous aging process, allowing the complex notes to mature and harmonize. This patience results in the depth and sillage that VESPR is renowned for.</p>
                <ul class="check-list">
                    <li><i class="fa-solid fa-check"></i> Small-batch distillation for purity.</li>
                    <li><i class="fa-solid fa-check"></i> Hand-poured in artisanal glass.</li>
                    <li><i class="fa-solid fa-check"></i> Zero synthetic fillers or phthalates.</li>
                </ul>
            </div>
            <div class="section-image">
                <img src="https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&q=80&w=800" alt="Perfumer at work">
            </div>
        </div>
    </section>

    <!-- Values / USP Section -->
    <section class="values-grid">
        <div class="value-card">
            <i class="fa-solid fa-leaf"></i>
            <h3>Ethical Sourcing</h3>
            <p>We work directly with local farmers to ensure fair trade and sustainable harvesting methods.</p>
        </div>
        <div class="value-card">
            <i class="fa-solid fa-flask-vial"></i>
            <h3>Precision Blending</h3>
            <p>Our master perfumers balance over 150 individual ingredients for a single signature scent.</p>
        </div>
        <div class="value-card">
            <i class="fa-solid fa-shield-heart"></i>
            <h3>Signature Sillage</h3>
            <p>Designed to linger gracefully, our scents are built on high-concentration oil bases.</p>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="about-cta">
        <div class="cta-inner">
            <h2>Experience the Difference</h2>
            <p>Ready to find your signature scent? Explore our collections today.</p>
            <div style="display: flex; gap: 1.5rem; justify-content: center; margin-top: 2rem;">
                <a href="{{ route('v1.all-products') }}" class="btn-primary">Shop All Perfumes</a>
                <a href="{{ route('v1.combos') }}" class="btn-outline">Exclusive Combos</a>
            </div>
        </div>
    </section>
</div>

<style>
    /* About Page Specific Styling */
    .about-hero {
        height: 50vh;
        min-height: 400px;
        background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=1600');
        background-size: cover;
        background-position: center;
        background-attachment: scroll; /* Changed from fixed for better mobile support */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 0 0 2rem 2rem;
        margin-top: -2rem;
        padding: 0 1.5rem;
    }

    @media (min-width: 992px) {
        .about-hero { background-attachment: fixed; height: 60vh; border-radius: 0 0 4rem 4rem; }
    }

    .about-hero-content { max-width: 800px; color: #fff; }
    .eyebrow { text-transform: uppercase; letter-spacing: 0.3em; font-weight: 700; color: var(--accent-color); font-size: 0.85rem; display: block; margin-bottom: 1.25rem; }
    .about-title { font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 1.5rem; }
    .about-subtitle { font-size: 1.15rem; opacity: 0.9; line-height: 1.6; }

    .about-container { max-width: 1200px; margin: 0 auto; padding: 4rem 1.5rem; }

    .about-section { margin-bottom: 6rem; }
    .section-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
    .inverted .section-text { order: 1; }
    .inverted .section-image { order: 2; }

    .section-image img { width: 100%; border-radius: 2rem; box-shadow: var(--shadow-md); }
    .section-badge { display: inline-block; padding: 0.4rem 1rem; background: var(--section-bg); color: var(--primary-color); border-radius: 99px; font-weight: 700; font-size: 0.8rem; margin-bottom: 1.25rem; }
    .h1 { font-size: 2.5rem; font-weight: 800; color: var(--primary-color); margin-bottom: 1.25rem; }
    .section-text p { font-size: 1.1rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 1.25rem; }

    .stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 2rem; }
    .stat-num { display: block; font-size: 2rem; font-weight: 800; color: var(--accent-color); }
    .stat-label { font-size: 0.9rem; font-weight: 700; color: var(--primary-color); }

    .check-list { list-style: none; margin-top: 1.5rem; }
    .check-list li { margin-bottom: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 0.75rem; color: var(--primary-color); font-size: 1rem; }
    .check-list i { color: #10b981; font-size: 0.9rem; }

    .values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin: 6rem 0; }
    .value-card { background: #fff; padding: 3rem 2rem; border-radius: 2rem; border: 1px solid var(--border-color); text-align: center; transition: 0.4s; }
    .value-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-md); border-color: var(--accent-color); }
    .value-card i { font-size: 2.5rem; color: var(--accent-color); margin-bottom: 1.5rem; }
    .value-card h3 { font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.75rem; }
    .value-card p { color: var(--text-muted); line-height: 1.5; font-size: 0.95rem; }

    .about-cta { background: var(--primary-color); color: #fff; padding: 4rem 2rem; border-radius: 3rem; text-align: center; }
    .cta-inner h2 { font-size: 2.25rem; font-weight: 800; margin-bottom: 1.25rem; }
    .cta-inner p { font-size: 1.1rem; opacity: 0.8; margin-bottom: 2rem; }
    
    .btn-outline { display: inline-block; padding: 0.9rem 2rem; border-radius: 99px; border: 2px solid rgba(255,255,255,0.3); color: #fff; text-decoration: none; font-weight: 700; transition: 0.3s; font-size: 0.95rem; }
    .btn-outline:hover { background: #fff; color: var(--primary-color); border-color: #fff; }

    @media (max-width: 992px) {
        .about-container { padding: 4rem 1.25rem; }
        .section-grid { grid-template-columns: 1fr; gap: 3rem; text-align: center; }
        .about-title { font-size: 2.5rem; }
        .h1 { font-size: 2.2rem; }
        .values-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .inverted .section-text { order: 2; }
        .inverted .section-image { order: 1; }
        .check-list li { justify-content: center; }
        .stat-grid { justify-content: center; }
        .about-cta { padding: 3.5rem 1.5rem; border-radius: 2rem; }
        .cta-inner h2 { font-size: 1.8rem; }
        
        .btn-stack { display: flex; flex-direction: column; gap: 1rem; align-items: center; }
    }

    @media (max-width: 480px) {
        .about-title { font-size: 2.2rem; }
        .about-subtitle { font-size: 1rem; }
        .h1 { font-size: 1.8rem; }
        .stat-num { font-size: 1.75rem; }
    }
</style>
@endsection
