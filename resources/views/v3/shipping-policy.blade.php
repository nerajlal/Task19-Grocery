@extends('v3.layouts.app')

@section('title', 'Shipping Policy - Task19 Perfumes')

@push('styles')
<style>
    .page-hero {
        position: relative;
        height: 40vh;
        min-height: 300px;
        background-color: var(--black);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 50px;
    }

    .hero-content {
        position: relative;
        color: var(--white);
        text-align: center;
        padding: 20px;
        z-index: 2;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .hero-subtitle {
        font-size: 16px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        letter-spacing: 0.5px;
    }

    .policy-container {
        max-width: 1200px;
        margin: 0 auto 80px;
        padding: 0 20px;
    }

    /* Grid Layout */
    .policy-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    /* Cards */
    .info-card {
        background: var(--white);
        padding: 40px;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .info-card.full-width {
        grid-column: 1 / -1;
        background: var(--bg-light);
        border: none;
    }

    .info-card.highlight {
        background: #f8f9fa;
        border-left: 5px solid var(--black);
    }

    .card-icon {
        font-size: 32px;
        margin-bottom: 20px;
        color: var(--black);
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--black);
    }

    .card-text {
        font-size: 15px;
        line-height: 1.7;
        color: var(--text);
        margin-bottom: 0;
    }

    .card-list {
        padding-left: 20px;
        margin-top: 15px;
    }

    .card-list li {
        margin-bottom: 8px;
        color: var(--text);
    }

    .contact-link {
        color: var(--black);
        font-weight: 700;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .policy-grid {
            grid-template-columns: 1fr;
        }
        .hero-title {
            font-size: 32px;
        }
        .info-card {
            padding: 25px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Header -->
    <div class="page-hero">
        <div class="hero-content">
            <h1 class="hero-title">Shipping Policy</h1>
            <p class="hero-subtitle">Fast, secure, and reliable delivery across India.</p>
        </div>
    </div>

    <!-- Grid Content -->
    <div class="policy-container">
        <div class="policy-grid">
            
            <!-- Intro (Full Width) -->
            <div class="info-card full-width" style="text-align: center; background: white; border: 1px solid var(--border);">
                <p class="card-text" style="font-size: 18px; max-width: 800px; margin: 0 auto;">
                    At Nurah Perfumes, we understand that waiting for your favorite scent is hard. That's why we've partnered with India's best logistics services to ensure your order reaches you safely and on time.
                </p>
            </div>

            <!-- Delivery Areas -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3 class="card-title">Delivery Areas</h3>
                <p class="card-text">
                    We deliver to over 10,000+ pincodes across India. From bustling metro cities to quiet towns, we ensure comprehensive coverage. You can check availability at checkout.
                </p>
            </div>

            <!-- Shipping Charges -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-shipping-fast"></i></div>
                <h3 class="card-title">Free Shipping</h3>
                <p class="card-text">
                    We hate hidden fees as much as you do. Enjoy <strong>Free Shipping</strong> on every single order, regardless of the value. The price you see is the price you pay.
                </p>
            </div>

            <!-- Payment Method (COD Highlight) -->
            <div class="info-card full-width highlight">
                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 300px;">
                        <h3 class="card-title" style="font-size: 28px;">Cash on Delivery</h3>
                        <p class="card-text">
                            To build trust and ensure your convenience, we operate exclusively on a <strong>Cash on Delivery (COD)</strong> basis. You pay only when the package is physically in your hands.
                        </p>
                    </div>
                    <div style="font-size: 50px; color: var(--text-light); opacity: 0.2;">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                </div>
            </div>

            <!-- Timelines -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-clock"></i></div>
                <h3 class="card-title">Delivery Timelines</h3>
                <ul class="card-list">
                    <li><strong>Metro Cities:</strong> 3-5 business days</li>
                    <li><strong>Rest of India:</strong> 5-7 business days</li>
                    <li><strong>Remote Areas:</strong> 7-10 business days</li>
                </ul>
            </div>

            <!-- Tracking -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-box-open"></i></div>
                <h3 class="card-title">Order Tracking</h3>
                <p class="card-text">
                    Once dispatched (within 24 hours), you'll receive a tracking link via <strong>SMS and Email</strong>. Use it to follow your package's journey in real-time.
                </p>
            </div>

            <!-- Support (Full Width) -->
            <div class="info-card full-width" style="display: flex; gap: 20px; align-items: center; justify-content: center; flex-wrap: wrap; text-align: center;">
                <div>
                     <h3 class="card-title" style="margin-bottom: 5px;">Damaged Package?</h3>
                     <p class="card-text">Do not accept tampered visual packages.</p>
                </div>
                <a href="mailto:support@nurahperfumes.com" style="background: var(--black); color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600;">Contact Support</a>
            </div>

        </div>
    </div>
@endsection
