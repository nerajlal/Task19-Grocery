@extends('v3.layouts.app')

@section('title', 'Terms of Service - Task19 Perfumes')

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

    .policy-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    .info-card {
        background: var(--white);
        padding: 40px;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
    }

    .info-card.full-width {
        grid-column: 1 / -1;
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
        margin-bottom: 15px;
    }

    .card-list {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .card-list li {
        margin-bottom: 8px;
        color: var(--text);
        line-height: 1.6;
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
            <h1 class="hero-title">Terms of Service</h1>
            <p class="hero-subtitle">Please read these terms carefully before accessing or using our website.</p>
        </div>
    </div>

    <div class="policy-container">
        <div class="policy-grid">

            <!-- Overview (Full Width) -->
            <div class="info-card full-width" style="text-align: center;">
                <p class="card-text" style="max-width: 800px; margin: 0 auto;">
                    This website is operated by <strong>Nurah Perfumes</strong>. Throughout the site, the terms "we", "us" and "our" refer to Nurah Perfumes. By visiting our site and/or purchasing something from us, you engage in our "Service" and agree to be bound by the following terms and conditions.
                </p>
            </div>

            <!-- General Conditions -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-gavel"></i></div>
                <h3 class="card-title">General Conditions</h3>
                <p class="card-text">
                    We reserve the right to refuse service to anyone for any reason at any time. You understand that your content (excluding credit card information) may be transferred unencrypted and involve transmissions over various networks.
                </p>
            </div>

            <!-- Accuracy -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-check-double"></i></div>
                <h3 class="card-title">Accuracy & Information</h3>
                <p class="card-text">
                    We are not responsible if information made available on this site is not accurate, complete or current. The material on this site is provided for general information only and should not be relied upon as the sole basis for making decisions.
                </p>
            </div>

            <!-- Modifications (Full Width) -->
            <div class="info-card full-width" style="background: var(--bg-light); border: none;">
                <div style="display: flex; gap: 30px; align-items: center; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 250px;">
                        <h3 class="card-title">Modifications to Service & Prices</h3>
                        <p class="card-text">
                            Prices for our products are subject to change without notice. We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time.
                        </p>
                    </div>
                    <div style="font-size: 40px; color: var(--black); opacity: 0.1;">
                        <i class="fas fa-tag"></i>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-pump-soap"></i></div>
                <h3 class="card-title">Products or Services</h3>
                <p class="card-text">
                    Certain products or services may be available exclusively online through the website. These products or services may have limited quantities and are subject to return or exchange only according to our Return Policy.
                </p>
            </div>

            <!-- User Comments -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-comments"></i></div>
                <h3 class="card-title">User Comments</h3>
                <p class="card-text">
                    If, at our request, you send certain specific submissions or without a request from us you send creative ideas, suggestions, proposals, plans, or other materials, you agree that we may, at any time, without restriction, edit, copy, publish, distribute, translate and otherwise use them.
                </p>
            </div>
            
            <!-- Contact (Full Width) -->
             <div class="info-card full-width" style="text-align: center; background: var(--black); color: white;">
                <h3 class="card-title" style="color: white;">Questions?</h3>
                <p class="card-text" style="color: rgba(255,255,255,0.8); margin-bottom: 20px;">
                    Questions about the Terms of Service should be sent to us at support@nurahperfumes.com.
                </p>
            </div>

        </div>
    </div>
@endsection
