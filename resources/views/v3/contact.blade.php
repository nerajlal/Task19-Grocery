@extends('v3.layouts.app')

@section('title', 'Contact Us - Task19 Perfumes')

@push('styles')
<style>
    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 50px 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 16px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 50px;
    }

    /* Contact Info */
    .info-card {
        background: var(--bg-light);
        padding: 40px;
        border-radius: 20px;
        text-align: center;
    }

    .info-item {
        margin-bottom: 30px;
    }

    .info-icon {
        width: 60px;
        height: 60px;
        background: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 24px;
        color: var(--black);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .info-title {
        font-weight: 700;
        margin-bottom: 5px;
        font-family: 'Playfair Display', serif;
        font-size: 20px;
    }

    .info-link {
        color: var(--text);
        text-decoration: none;
        transition: color 0.3s;
    }

    .info-link:hover {
        color: var(--gold);
    }

    /* Contact Form */
    .contact-form-container {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 40px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .form-input, .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-input:focus, .form-textarea:focus {
        border-color: var(--black);
        outline: none;
    }

    .form-textarea {
        height: 120px;
        resize: vertical;
    }

    .submit-btn {
        width: 100%;
        background: var(--black);
        color: var(--white);
        border: none;
        padding: 15px;
        border-radius: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .submit-btn:hover {
        opacity: 0.9;
    }

    @media (min-width: 900px) {
        .contact-grid {
            grid-template-columns: 1fr 2fr;
        }
    }
</style>
@endpush

@section('content')
    <div class="contact-container">
        <div class="page-header">
            <h1 class="page-title">Get in Touch</h1>
            <p class="page-subtitle">We'd love to hear from you. Here's how you can reach us.</p>
        </div>

        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="info-card">
                <div class="info-item">
                    <div class="info-icon"><i class="fab fa-whatsapp"></i></div>
                    <h3 class="info-title">WhatsApp Support</h3>
                    <a href="https://wa.me/917306900600" target="_blank" class="info-link">+91 730 690 0600</a>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <h3 class="info-title">Email Us</h3>
                    <a href="mailto:support@xxxx.in" class="info-link">support@xxxx.in</a>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3 class="info-title">Visit Us</h3>
                    <p class="info-link">Find a store near you</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-container">
                <form>
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-input" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea class="form-textarea" placeholder="How can we help you?"></textarea>
                    </div>
                    <button type="submit" class="submit-btn" onclick="event.preventDefault(); alert('Thank you! We will get back to you soon.')">Send Message</button>
                </form>
            </div>
        </div>
    </div>
@endsection
