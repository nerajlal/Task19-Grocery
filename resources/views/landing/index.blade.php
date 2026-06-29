@extends('landing.layouts.app')

@section('styles')
    <style>
        /* Hero Section */
        .hero {
            padding: 12rem 0 8rem;
            min-height: 70vh;
            display: flex;
            align-items: center;
            text-align: center;
            background: radial-gradient(circle at center, rgba(197, 160, 89, 0.05) 0%, transparent 60%);
            overflow: hidden;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero-tag {
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: block;
        }

        .hero h1 {
            font-size: 5.5rem;
            line-height: 1.05;
            margin-bottom: 2rem;
            color: var(--text-main);
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 3rem;
        }

        .hero-image-container {
            position: relative;
            height: 600px;
            z-index: 1;
        }

        .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 40px;
            box-shadow: 20px 20px 60px rgba(0, 0, 0, 0.05);
            filter: brightness(0.98);
        }

        /* Features Section */
        .section-padding {
            padding: 5rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-header h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .section-header p {
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
        }

        /* Features Section */
        .features-minimal {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 6rem;
            align-items: flex-start;
        }

        .features-text h2 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .features-text p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 400px;
        }

        .features-list-minimal {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .feature-item {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .feature-item-icon {
            color: var(--accent-gold);
            font-size: 1.5rem;
            margin-top: 0.2rem;
        }

        .feature-item-content h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .feature-item-content p {
            color: var(--text-light);
            font-size: 0.85rem;
            line-height: 1.6;
        }

        /* Template Showcase */
        .templates-section {
            background: var(--bg-color);
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
        }

        .template-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            background: white;
            transition: var(--transition);
        }

        .template-card:hover {
            transform: translateY(-10px);
        }

        .template-preview {
            height: 400px;
            background: #eee;
            position: relative;
        }

        .template-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .template-card:hover .template-preview img {
            transform: scale(1.05);
        }

        .template-info {
            padding: 2rem;
            text-align: center;
        }

        .template-tag {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent-gold);
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Pricing Section */
        .pricing {
            background: #F8F5F1;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            align-items: stretch;
        }

        .pricing-card {
            background: var(--white);
            padding: 3rem 2rem;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(197, 160, 89, 0.1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        .pricing-card.featured {
            transform: scale(1.05);
            border-color: var(--accent-gold);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.08);
            z-index: 1;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
        }

        .pricing-card.featured:hover {
            transform: scale(1.05) translateY(-5px);
        }

        .pricing-card .badge {
            position: absolute;
            top: 25px;
            right: -35px;
            background: var(--accent-gold);
            color: white;
            padding: 5px 40px;
            transform: rotate(45deg);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .price {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 1rem 0;
            font-family: 'Inter', sans-serif;
        }

        .price span {
            font-size: 1.2rem;
            color: var(--text-light);
            font-weight: 400;
        }

        .pricing-features {
            list-style: none;
            margin: 2rem 0 3rem;
            text-align: left;
            display: inline-block;
        }

        .pricing-features li {
            margin-bottom: 1rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pricing-features li i {
            color: var(--accent-gold);
        }

        /* Inquiry Section */
        .inquiry {
            text-align: center;
            background: var(--bg-color);
        }

        .inquiry-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .inquiry h2 {
            font-size: 3.5rem;
            margin-bottom: 2rem;
        }

        /* Testimonials */
        .testimonials {
            background: var(--bg-color);
            padding: 6rem 0;
        }

        .testimonials-overflow {
            overflow: hidden;
            width: 100%;
            position: relative;
        }

        .testimonials-track {
            display: flex;
            gap: 3rem;
            animation: scroll 40s linear infinite;
            width: max-content;
        }

        .testimonials-track:hover {
            animation-play-state: paused;
        }

        .testimonial-card {
            background: var(--white);
            padding: 3.5rem 2.5rem;
            border-radius: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(197, 160, 89, 0.05);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            width: 450px;
            /* Fixed width for consistent scroll */
            flex-shrink: 0;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-50% - 1.5rem));
            }
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.06);
            border-color: var(--accent-gold);
        }

        .rating {
            color: var(--accent-gold);
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-style: italic;
            margin-bottom: 2rem;
            color: var(--text-main);
            line-height: 1.6;
            flex-grow: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
            border-top: 1px solid rgba(197, 160, 89, 0.1);
            padding-top: 1.5rem;
        }

        .author-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-info h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.1rem;
        }

        .author-info p {
            font-size: 0.75rem;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero {
                padding-top: 8rem;
                text-align: center;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .hero-image-container {
                height: 400px;
                order: -1;
            }

            .hero h1 {
                font-size: 3.5rem;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .pricing-card.featured {
                transform: scale(1);
            }

            .pricing-card.featured:hover {
                transform: translateY(-5px);
            }

            .features-minimal {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }

            .features-text p {
                margin: 0 auto;
            }

            .features-list-minimal {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: left;
            }

            .testimonial-card {
                width: 300px;
                padding: 2.5rem 2rem;
            }

            .features-grid,
            .template-grid {
                grid-template-columns: 1fr !important;
                gap: 2rem;
            }

            .section-header h2 {
                font-size: 2.5rem;
            }

            .hero h1 {
                font-size: 3rem;
            }

            .inquiry h2 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 8rem 0 4rem;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-trust div {
                flex-direction: column;
                gap: 1.5rem !important;
            }

            .hero-actions {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .hero-actions .btn-outline {
                margin-left: 0 !important;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content" data-reveal>
                <span class="hero-tag">The Fragrance OS</span>
                <h1>The Art of<br>Scent<span>.</span></h1>
                <p>The definitive e-commerce ecosystem for luxury perfume houses. From artisanal boutiques to global heritage labels, VESPR orchestrates your digital presence with absolute elegance.</p>
                <div class="hero-btns" data-reveal>
                    <a href="#inquiry" class="btn-premium">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="trust-bar" style="padding: 3rem 0; background: white; border-bottom: 1px solid rgba(0,0,0,0.03);">
        <div class="container">
            <div style="display: flex; justify-content: center; gap: 4rem; align-items: center; flex-wrap: wrap; opacity: 0.5; filter: grayscale(1);">
                <span style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 600;">MAISON L'AMOUR</span>
                <span style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 600;">SCENT & SOUL</span>
                <span style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 600;">THORNE</span>
                <span style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 600;">ROSSO</span>
                <span style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 600;">ESSENCE</span>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding">
        <div class="container">
            <div class="features-minimal">
                <div class="features-text" data-reveal>
                    <span class="hero-tag">Excellence Defined</span>
                    <h2>Platform<br>Features</h2>
                    <p>Everything you need to run a world-class fragrance brand, delivered in one seamless experience.</p>
                </div>
                <div class="features-list-minimal">
                    <div class="feature-item" data-reveal>
                        <div class="feature-item-icon"><i class="fa-solid fa-palette"></i></div>
                        <div class="feature-item-content">
                            <h3>Couture Themes</h3>
                            <p>Switch between world-class designs with a single click.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-reveal>
                        <div class="feature-item-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <div class="feature-item-content">
                            <h3>Olfactory Bundling</h3>
                            <p>Maximize revenue with intelligent fragrance combo pools.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-reveal>
                        <div class="feature-item-icon"><i class="fa-solid fa-users-gear"></i></div>
                        <div class="feature-item-content">
                            <h3>Maison Control</h3>
                            <p>Manage multiple fragrance labels from one elite dashboard.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-reveal>
                        <div class="feature-item-icon"><i class="fa-solid fa-gauge-high"></i></div>
                        <div class="feature-item-content">
                            <h3>Velvet Performance</h3>
                            <p>Ultra-fast loading for high-conversion fragrance sales.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-reveal>
                        <div class="feature-item-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                        <div class="feature-item-content">
                            <h3>Discovery SEO</h3>
                            <p>Built-in tools to dominate organic search for scents.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-reveal>
                        <div class="feature-item-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="feature-item-content">
                            <h3>Private Security</h3>
                            <p>Robust, encrypted payment flows for high-value trust.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Template Showcase Section -->
    <section id="templates" class="section-padding templates-section">
        <div class="container">
            <div class="section-header" data-reveal>
                <p>Ready-to-Use Designs</p>
                <h2>Luxury Templates</h2>
            </div>
            <div class="template-grid">
                <!-- Aura Template -->
                <div class="template-card" data-reveal>
                    <div class="template-preview">
                        <img src="{{ asset('Images/landing/v3-template.png') }}" alt="Aura Template">
                    </div>
                    <div class="template-info">
                        <span class="template-tag">V3 Theme</span>
                        <h3>Aura</h3>
                        <p style="color: var(--text-light); font-size: 0.9rem; margin-bottom: 1.5rem;">Editorial style with
                            clean typography and high-conversion layouts.</p>
                        <a href="javascript:void(0)" onclick="openDemoAccess(event, '{{ route('v3.home') }}')" class="btn-outline"
                            style="padding: 0.6rem 1.5rem; font-size: 0.8rem;">Live Demo</a>
                    </div>
                </div>

                <!-- Velvet Template -->
                <div class="template-card" data-reveal>
                    <div class="template-preview">
                        <img src="{{ asset('Images/landing/v2-template.png') }}" alt="Velvet Template">
                    </div>
                    <div class="template-info">
                        <span class="template-tag">V2 Theme</span>
                        <h3>Velvet</h3>
                        <p style="color: var(--text-light); font-size: 0.9rem; margin-bottom: 1.5rem;">A high-end,
                            minimalist aesthetic for boutique fragrance houses.</p>
                        <a href="javascript:void(0)" onclick="openDemoAccess(event, '{{ route('velvet.home') }}')" class="btn-outline"
                            style="padding: 0.6rem 1.5rem; font-size: 0.8rem;">Live Demo</a>
                    </div>
                </div>

                <!-- Classic Template -->
                <div class="template-card" data-reveal>
                    <div class="template-preview">
                        <img src="{{ asset('Images/landing/v1-template.png') }}" alt="Classic Template">
                    </div>
                    <div class="template-info">
                        <span class="template-tag">V1 Theme</span>
                        <h3>Classic</h3>
                        <p style="color: var(--text-light); font-size: 0.9rem; margin-bottom: 1.5rem;">The original heritage
                            design, focused on product storytelling.</p>
                        <a href="javascript:void(0)" onclick="openDemoAccess(event, '{{ route('v1.home') }}')" class="btn-outline"
                            style="padding: 0.6rem 1.5rem; font-size: 0.8rem;">Live Demo</a>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 4rem;" data-reveal>
                <a href="{{ route('landing.templates') }}" class="btn-premium">View All Templates</a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header" data-reveal>
                <p>Voices of Excellence</p>
                <h2>Trusted by Curators</h2>
            </div>
            <div class="testimonials-overflow">
                <div class="testimonials-track">
                    <!-- Review 1 -->
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text">"The Aura theme captures our brand's heritage perfectly. The backend
                            efficiency is unmatched for scaling globally."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&auto=format&fit=crop"
                                alt="Client" class="author-img">
                            <div class="author-info">
                                <h4>Marcello Davila</h4>
                                <p>Maison l'Amour</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Switching to VESPR was the best decision for our boutique. The
                            multi-theme engine is a total game changer."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&auto=format&fit=crop"
                                alt="Client" class="author-img">
                            <div class="author-info">
                                <h4>Elena Rosso</h4>
                                <p>Scent & Soul</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Ultra-fast performance and incredible support. Our conversion rates
                            have never been higher than with the Velvet theme."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=150&auto=format&fit=crop"
                                alt="Client" class="author-img">
                            <div class="author-info">
                                <h4>Julian Thorne</h4>
                                <p>Thorne Fragrances</p>
                            </div>
                        </div>
                    </div>

                    <!-- Duplicate for Seamless Loop -->
                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text">"The Aura theme captures our brand's heritage perfectly. The backend
                            efficiency is unmatched for scaling globally."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&auto=format&fit=crop"
                                alt="Client" class="author-img">
                            <div class="author-info">
                                <h4>Marcello Davila</h4>
                                <p>Maison l'Amour</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Switching to VESPR was the best decision for our boutique. The
                            multi-theme engine is a total game changer."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&auto=format&fit=crop"
                                alt="Client" class="author-img">
                            <div class="author-info">
                                <h4>Elena Rosso</h4>
                                <p>Scent & Soul</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Ultra-fast performance and incredible support. Our conversion rates
                            have never been higher than with the Velvet theme."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=150&auto=format&fit=crop"
                                alt="Client" class="author-img">
                            <div class="author-info">
                                <h4>Julian Thorne</h4>
                                <p>Thorne Fragrances</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section-padding pricing">
        <div class="container">
            <div class="section-header" data-reveal>
                <p>Simple, Transparent</p>
                <h2>Investment</h2>
            </div>
            <div class="pricing-grid">
                <!-- Boutique Plan -->
                <div class="pricing-card" data-reveal>
                    <span class="hero-tag" style="color: var(--text-light)">Boutique</span>
                    <div class="price">$10<span>/month</span></div>
                    <p style="margin-bottom: 1.5rem; font-size: 0.9rem;">Perfect for emerging artisanal fragrance houses.</p>
                    <ul class="pricing-features" style="flex-grow: 1;">
                        <li><i class="fa-solid fa-check"></i> Up to 50 Fragrances</li>
                        <li><i class="fa-solid fa-check"></i> Nurah Classic Theme</li>
                        <li><i class="fa-solid fa-check"></i> Essence Inventory Tools</li>
                        <li><i class="fa-solid fa-check"></i> Concierge Support</li>
                    </ul>
                    <a href="#contact" class="btn-outline">Select Boutique</a>
                </div>

                <!-- Maison Plan -->
                <div class="pricing-card featured" data-reveal>
                    <div class="badge">ESTABLISHED</div>
                    <span class="hero-tag" style="color: var(--accent-gold)">Maison</span>
                    <div class="price">$20<span>/month</span></div>
                    <p style="margin-bottom: 1.5rem; font-size: 0.9rem;">The complete ecosystem for scaling luxury maisons.</p>
                    <ul class="pricing-features" style="flex-grow: 1;">
                        <li><i class="fa-solid fa-check"></i> Unlimited Fragrances</li>
                        <li><i class="fa-solid fa-check"></i> Full Template Library</li>
                        <li><i class="fa-solid fa-check"></i> Olfactory Combo Engine</li>
                        <li><i class="fa-solid fa-check"></i> Priority WhatsApp Care</li>
                    </ul>
                    <a href="#contact" class="btn-premium">Select Maison</a>
                </div>

                <!-- Heritage Plan -->
                <div class="pricing-card" data-reveal>
                    <span class="hero-tag" style="color: var(--text-main)">Heritage</span>
                    <div class="price">$49<span>/month</span></div>
                    <p style="margin-bottom: 1.5rem; font-size: 0.9rem;">Bespoke solutions for global fragrance legends.</p>
                    <ul class="pricing-features" style="flex-grow: 1;">
                        <li><i class="fa-solid fa-check"></i> White-label Experience</li>
                        <li><i class="fa-solid fa-check"></i> Bespoke Domain Integration</li>
                        <li><i class="fa-solid fa-check"></i> Dedicated Brand Partner</li>
                        <li><i class="fa-solid fa-check"></i> Full API & Webhook Access</li>
                    </ul>
                    <a href="#contact" class="btn-outline">Select Heritage</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Inquiry Section -->
    <section id="contact" class="section-padding inquiry">
        <div class="container">
            <div class="inquiry-content" data-reveal>
                <p class="hero-tag">Connect With Us</p>
                <h2>Ready to transform your brand?</h2>
                <p style="margin-bottom: 3rem; font-size: 1.1rem;">Join the elite fragrance houses using VESPR Perfume SaaS
                    to power their digital presence.</p>
                <a href="https://wa.me/your-number" class="btn-premium" style="padding: 1.2rem 4rem; font-size: 1.1rem;">
                    <i class="fa-brands fa-whatsapp" style="margin-right: 10px;"></i> Chat on WhatsApp
                </a>
                <div style="margin-top: 2rem;">
                    <p style="color: var(--text-light); font-size: 0.9rem;">Or email us at: <a
                            href="mailto:perfume@vespr.com"
                            style="color: var(--accent-gold); text-decoration: none;">perfume@vespr.com</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection