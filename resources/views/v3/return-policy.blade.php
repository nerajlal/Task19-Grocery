@extends('v3.layouts.app')

@section('title', 'Return & Refund Policy - Task19 Perfumes')

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

    .info-card.process-card {
        background: var(--bg-light);
        border: none;
        align-items: center;
        text-align: center;
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

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        width: 100%;
        margin-top: 30px;
    }

    .step-item {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        position: relative;
    }

    .step-number {
        width: 30px;
        height: 30px;
        background: var(--black);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin: 0 auto 15px;
    }

    @media (max-width: 768px) {
        .policy-grid {
            grid-template-columns: 1fr;
        }
        .steps-grid {
            grid-template-columns: 1fr;
        }
        .hero-title {
            font-size: 32px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Header -->
    <div class="page-hero">
        <div class="hero-content">
            <h1 class="hero-title">Returns & Refunds</h1>
            <p class="hero-subtitle">Simple, straightforward, and no questions asked for 7 days.</p>
        </div>
    </div>

    <div class="policy-container">
        <div class="policy-grid">

            <!-- Return Window -->
            <div class="info-card">
                <div class="card-icon"><i class="far fa-calendar-alt"></i></div>
                <h3 class="card-title">7-Day Easy Returns</h3>
                <p class="card-text">
                    You have 7 days from the date of delivery to initiate a return. We verify this window using our delivery partner's tracking system.
                </p>
            </div>

            <!-- Eligibility -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                <h3 class="card-title">Eligibility</h3>
                <p class="card-text">
                    To be eligible, the item must be unused, in its original packaging with seals intact, and accompanied by the proof of purchase.
                </p>
            </div>

            <!-- Refund Process (Visual Step) -->
            <div class="info-card full-width process-card">
                <h3 class="card-title">COD Refund Process</h3>
                <p class="card-text" style="max-width: 600px;">
                    Since you paid via Cash on Delivery, we cannot refund to source. Here is how we process your refund securely to your bank account or UPI.
                </p>

                <div class="steps-grid">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <strong>Request Return</strong>
                        <p style="font-size: 13px; margin-top: 5px;">Email us your Order ID</p>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <strong>Pickup</strong>
                        <p style="font-size: 13px; margin-top: 5px;">Courier picks up in 2-3 days</p>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <strong>Inspection</strong>
                        <p style="font-size: 13px; margin-top: 5px;">Quality Check at warehouse</p>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <strong>Refund</strong>
                        <p style="font-size: 13px; margin-top: 5px;">Via Bank Transfer or UPI</p>
                    </div>
                </div>
            </div>

            <!-- Damaged Items -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <h3 class="card-title">Damaged / Defective</h3>
                <p class="card-text">
                    Received a leaking or broken bottle? Email us with a photo within 24 hours. We will promptly send a free replacement without any hassle.
                </p>
            </div>

            <!-- Shipping Fee -->
            <div class="info-card">
                <div class="card-icon"><i class="fas fa-truck"></i></div>
                <h3 class="card-title">Return Shipping</h3>
                <p class="card-text">
                    Returns for defects are free. For "change of mind" returns, a nominal shipping deduction of ₹100 applies to cover reverse logistics.
                </p>
            </div>

            <!-- Contact (Full Width) -->
             <div class="info-card full-width" style="text-align: center; background: var(--black); color: white;">
                <h3 class="card-title" style="color: white;">Ready to initiate a return?</h3>
                <p class="card-text" style="color: rgba(255,255,255,0.8); margin-bottom: 20px;">
                    Our support team is here to help you through every step.
                </p>
                <a href="mailto:support@xxxxperfumes.com" style="display: inline-block; background: white; color: black; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 700; width: fit-content; margin: 0 auto;">Email Support</a>
            </div>

        </div>
    </div>
@endsection
