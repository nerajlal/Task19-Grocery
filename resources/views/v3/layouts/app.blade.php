<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Task19 Perfumes - @yield('title', 'India\'s First Perfume Bar')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        :root {
            --black: #1a1a1a;
            --white: #fffcf7;
            --gold: #c5a059;
            --dark-gold: #a68442;
            --text: #2d2d2d;
            --text-light: #6a6a6a;
            --bg-light: #f4f1ea;
            --border: #e6e2da;
            --success: #28a745;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            background: var(--bg-light); /* Changed to light bg for warmth */
        }

        /* Common Components */
        .promo-bar { background: linear-gradient(135deg, var(--black) 0%, #1a1a1a 100%); color: var(--white); padding: 12px 15px; text-align: center; font-size: 12px; font-weight: 600; position: sticky; top: 0; z-index: 1001; }
        .promo-bar span { color: var(--gold); font-weight: 700; }
        
        .mobile-header { background: var(--white); position: sticky; top: 40px; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 12px 15px; }
        .header-top { display: flex; justify-content: space-between; align-items: center; }
        .menu-btn, .back-btn { background: none; border: none; font-size: 24px; cursor: pointer; padding: 5px; }
        .logo { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 900; color: var(--black); text-decoration: none; letter-spacing: -0.5px; }
        .header-icons { display: flex; gap: 15px; align-items: center; }
        .icon-btn { background: none; border: none; font-size: 20px; cursor: pointer; position: relative; }
        .cart-count { position: absolute; top: -5px; right: -8px; background: var(--gold); color: var(--white); width: 16px; height: 16px; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        
        @media (min-width: 900px) {
            .header-icons { gap: 30px; }
            .icon-btn { font-size: 22px; }
        }

        /* Mobile Menu */
        .mobile-menu { position: fixed; top: 0; left: -100%; width: 85%; max-width: 320px; height: 100vh; background: var(--white); z-index: 2000; transition: left 0.3s ease; overflow-y: auto; box-shadow: 2px 0 20px rgba(0,0,0,0.1); }
        .mobile-menu.active { left: 0; }
        .menu-header { padding: 20px 15px; background: var(--black); color: var(--white); display: flex; justify-content: space-between; align-items: center; }
        .menu-close { background: none; border: none; color: var(--white); font-size: 28px; cursor: pointer; }
        .menu-list { list-style: none; padding: 20px 0; }
        .menu-item { border-bottom: 1px solid var(--border); }
        .menu-link { display: block; padding: 15px 20px; color: var(--text); text-decoration: none; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .menu-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1999; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
        .menu-overlay.active { opacity: 1; pointer-events: all; }

        /* Footer */
        /* Footer */
        footer { background: #262421; color: var(--white); padding: 40px 20px 20px; margin-top: auto; border-top: 1px solid rgba(255,255,255,0.05); }
        .footer-content { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.5fr; gap: 20px; margin-bottom: 20px; }
        .footer-logo { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; margin-bottom: 15px; color: var(--gold); letter-spacing: -0.5px; }
        .footer-tagline { font-size: 14px; color: #999; line-height: 1.8; margin-bottom: 15px; max-width: 300px; }
        .footer-social { display: flex; gap: 12px; }
        .social-link { width: 38px; height: 38px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: #fff; transition: all 0.3s; text-decoration: none; font-size: 14px; border: 1px solid rgba(255,255,255,0.05); }
        .social-link:hover { background: var(--gold); border-color: var(--gold); transform: translateY(-3px); color: #000; }

        .footer-heading { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; color: var(--white); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 8px; }
        .footer-links a { color: #888; text-decoration: none; font-size: 14px; transition: all 0.3s; display: inline-block; }
        .footer-links a:hover { color: var(--gold); transform: translateX(5px); }

        .newsletter-text { color: #888; font-size: 14px; margin-bottom: 15px; line-height: 1.8; }
        .footer-form { position: relative; }
        .footer-input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid #333; padding: 15px 120px 15px 20px; color: #fff; border-radius: 4px; font-size: 14px; outline: none; transition: border-color 0.3s; }
        .footer-input:focus { border-color: var(--gold); }
        .footer-btn { position: absolute; right: 5px; top: 5px; background: var(--gold); color: #000; border: none; padding: 0 25px; border-radius: 3px; font-size: 12px; font-weight: 700; text-transform: uppercase; cursor: pointer; height: calc(100% - 10px); transition: background 0.3s; letter-spacing: 1px; }
        .footer-btn:hover { background: var(--white); }

        .footer-bottom { border-top: 1px solid #222; padding-top: 15px; text-align: center; color: #555; font-size: 11px; display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; }
        .copyright { letter-spacing: 0.5px; }
        .payment-icons { display: flex; gap: 15px; font-size: 24px; opacity: 0.5; }

        @media (max-width: 900px) {
            .footer-content { grid-template-columns: 1fr 1fr; gap: 40px; }
        }
        @media (max-width: 600px) {
            .footer-content { grid-template-columns: 1fr 1fr; gap: 30px; }
            .footer-col:nth-child(1), .footer-col:nth-child(4) { grid-column: 1 / -1; text-align: center; }
            .footer-tagline { margin: 0 auto 30px; }
            .footer-social { justify-content: center; }
            .footer-bottom { flex-direction: column; gap: 20px; }
        }
        
        /* Quick Action */
        .quick-action { position: fixed; bottom: 20px; right: 20px; z-index: 990; }
        .action-btn { width: 50px; height: 50px; border-radius: 50%; background: var(--gold); color: var(--white); border: none; box-shadow: 0 4px 15px rgba(212, 165, 116, 0.4); font-size: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        
        /* Global Animations */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-in { animation: fadeIn 0.5s ease forwards; }

        /* Utilities */
        .text-center { text-align: center; }
        .mb-20 { margin-bottom: 20px; }
    </style>
    @stack('styles')
</head>
<body>
    @include('v3.partials.header')

    <main>
        @yield('content')
    </main>

    @include('v3.partials.footer')

    <script>
        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Lazy Loading Animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.section, .product-card, .category-card, .feature').forEach(el => {
            observer.observe(el);
        });

        function handleImageError(img) {
            if (!img.getAttribute('data-error-handled')) {
                img.setAttribute('data-error-handled', 'true');
                img.onerror = null;
                img.src = '{{ asset("Images/g-load.webp") }}';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
