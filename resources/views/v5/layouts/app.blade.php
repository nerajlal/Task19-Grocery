<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Afnan Perfumes India | Buy Arabic Perfume & Attar Online')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --af-black: #1C1C1C;
            --af-gold: #B08D57;
            --af-gray: #757575;
            --af-light: #F5F5F5;
            --af-red: #D2232A;
            --af-border: #EEEEEE;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Instrument Sans', sans-serif; color: var(--af-black); background: #fff; line-height: 1.5; overflow-x: hidden; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 30px; }
        .serif { font-family: 'Playfair Display', serif; }

        /* Top Bar */
        .af-top-bar { background: var(--af-black); color: #fff; text-align: center; padding: 8px 0; font-size: 11px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase; }

        /* Header */
        .af-header { background: #fff; border-bottom: 1px solid var(--af-border); position: sticky; top: 0; z-index: 1000; transition: 0.3s; }
        .af-header.scrolled { padding: 5px 0; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }

        .af-header-main { display: flex; align-items: center; justify-content: space-between; height: 90px; }
        .af-logo { font-size: 28px; font-weight: 700; text-decoration: none; color: var(--af-black); letter-spacing: -0.5px; }
        .af-logo span { color: var(--af-red); }

        .af-nav { display: flex; gap: 35px; }
        .af-nav-item { text-decoration: none; color: var(--af-black); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; position: relative; }
        .af-nav-item::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 1.5px; background: var(--af-red); transition: 0.3s; }
        .af-nav-item:hover::after { width: 100%; }

        .af-actions { display: flex; align-items: center; gap: 25px; }
        .af-action-link { text-decoration: none; color: var(--af-black); font-size: 18px; position: relative; }
        .af-cart-count { position: absolute; top: -8px; right: -10px; background: var(--af-red); color: #fff; font-size: 10px; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; }

        /* Sections */
        .af-section { padding: 100px 0; }
        .af-section-title { font-size: 32px; font-weight: 600; margin-bottom: 50px; text-align: center; text-transform: uppercase; letter-spacing: 1px; }

        /* Footer */
        .af-footer { background: #000; color: #fff; padding: 100px 0 50px; }
        .af-footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.5fr; gap: 60px; }
        .af-footer-col h4 { font-size: 14px; font-weight: 700; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 1px; }
        .af-footer-links { list-style: none; }
        .af-footer-links li { margin-bottom: 12px; }
        .af-footer-links a { text-decoration: none; color: #aaa; font-size: 13px; transition: 0.3s; }
        .af-footer-links a:hover { color: #fff; }

        .af-newsletter input { background: transparent; border: 1px solid #333; padding: 12px 15px; color: #fff; width: 100%; margin-bottom: 15px; font-family: inherit; }
        .af-newsletter button { background: #fff; color: #000; border: none; padding: 12px 25px; font-weight: 700; font-size: 12px; cursor: pointer; width: 100%; text-transform: uppercase; }

        /* Mobile Adjustments */
        .af-menu-toggle { display: none; font-size: 24px; background: none; border: none; cursor: pointer; }

        @media (max-width: 1024px) {
            .af-nav { display: none; }
            .af-menu-toggle { display: block; }
            .af-header-main { height: 70px; }
            .af-footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 600px) {
            .af-footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
            /* Brand description: full width row 1 */
            .af-footer-col:nth-child(1) { grid-column: 1 / -1; }
            /* Shop (col 2) and Help (col 3): same row, side by side — default */
            /* Newsletter: full width last row */
            .af-footer-col:nth-child(4) { grid-column: 1 / -1; }
            .af-section { padding: 60px 0; }
            .af-section-title { font-size: 24px; }
        }

        /* Cart Drawer */
        .af-cart-drawer { position: fixed; top: 0; right: -400px; width: 400px; height: 100%; background: #fff; z-index: 2000; transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); box-shadow: -20px 0 60px rgba(0,0,0,0.1); }
        .af-cart-drawer.open { right: 0; }
        .af-drawer-header { padding: 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .af-drawer-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1999; display: none; }
        .af-drawer-overlay.open { display: block; }
    </style>
</head>

<body>
    <div class="af-top-bar">
        COMPLIMENTARY SHIPPING ON ORDERS ABOVE ₹500
    </div>

    <header class="af-header">
        <div class="container">
            <div class="af-header-top">
                <div class="af-header-left">
                    <button class="af-menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></button>
                </div>
                
                <a href="{{ route('v5.home') }}" class="af-logo">
                    {{ strtoupper($currentTenant->name ?? 'AFNAN') }}
                </a>

                <div class="af-actions">
                    <a href="#" class="af-action-link"><i class="fa-solid fa-magnifying-glass"></i></a>
                    <a href="#" class="af-action-link"><i class="fa-regular fa-user"></i></a>
                    <a href="javascript:void(0)" class="af-action-link" onclick="toggleCart()">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="af-cart-count" id="cart-count-v5">{{ \App\Services\CartService::getCount() }}</span>
                    </a>
                </div>
            </div>
            
            <nav class="af-nav">
                <a href="{{ route('v5.home') }}" class="af-nav-item">Home</a>
                <a href="{{ route('v5.all-products') }}" class="af-nav-item">All Perfumes</a>
                <a href="{{ route('v5.combos') }}" class="af-nav-item">Exclusive Combos</a>
                <a href="{{ route('v5.collection') }}" class="af-nav-item">Collections</a>
                <a href="#" class="af-nav-item">About Us</a>
            </nav>
        </div>
    </header>

    <style>
        .af-header-top { display: flex; align-items: center; justify-content: space-between; padding: 25px 0 15px; position: relative; }
        .af-header-left { flex: 1; }
        .af-logo { font-size: 32px; font-weight: 800; text-decoration: none; color: var(--af-black); letter-spacing: 2px; text-transform: uppercase; text-align: center; flex: 2; }
        .af-actions { flex: 1; display: flex; justify-content: flex-end; gap: 20px; }
        
        .af-nav { display: flex; justify-content: center; gap: 40px; padding: 15px 0 25px; border-top: 1px solid transparent;
            max-height: 80px; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease, opacity 0.3s ease; opacity: 1; }
        .af-nav-item { text-decoration: none; color: var(--af-black); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; transition: 0.3s; }
        .af-nav-item:hover { color: var(--af-red); }

        /* Smooth collapse on scroll instead of abrupt hide */
        .af-header.scrolled .af-nav { max-height: 0; padding: 0; opacity: 0; pointer-events: none; }
        .af-header.scrolled .af-header-top { padding: 12px 0; }
        .af-header.scrolled .af-logo { font-size: 24px; }

        /* Mobile drawer */
        .af-mobile-drawer { position: fixed; top: 0; left: -280px; width: 280px; height: 100%; background: #fff; z-index: 3000; transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); box-shadow: 5px 0 30px rgba(0,0,0,0.12); padding: 30px 25px; overflow-y: auto; }
        .af-mobile-drawer.open { left: 0; }
        .af-mobile-drawer-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2999; display: none; }
        .af-mobile-drawer-overlay.open { display: block; }
        .af-drawer-close { background: none; border: none; font-size: 22px; cursor: pointer; margin-bottom: 30px; display: block; }
        .af-mobile-nav { list-style: none; }
        .af-mobile-nav li { border-bottom: 1px solid #f0f0f0; }
        .af-mobile-nav a { display: block; padding: 16px 0; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: var(--af-black); text-decoration: none; }
        .af-mobile-nav a:hover { color: var(--af-red); }
    </style>

    <main>
        @yield('content')
    </main>

    <footer class="af-footer">
        <div class="container">
            <div class="af-footer-grid">
                <div class="af-footer-col">
                    <a href="#" class="af-logo" style="color: #fff; margin-bottom: 25px; display: block;">{{ strtoupper($currentTenant->name ?? 'AFNAN') }}</a>
                    <p style="color: #aaa; font-size: 13px; line-height: 1.8;">Crafting premium fragrances that capture the essence of heritage and modern luxury. Experience the world of Afnan.</p>
                </div>
                <div class="af-footer-col">
                    <h4>SHOP</h4>
                    <ul class="af-footer-links">
                        <li><a href="{{ route('v5.all-products') }}">All Perfumes</a></li>
                        <li><a href="{{ route('v5.combos') }}">Combos</a></li>
                        <li><a href="{{ route('v5.collection') }}">Collections</a></li>
                    </ul>
                </div>
                <div class="af-footer-col">
                    <h4>HELP</h4>
                    <ul class="af-footer-links">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                    </ul>
                </div>
                <div class="af-footer-col">
                    <h4>JOIN US</h4>
                    <p style="color: #aaa; font-size: 12px; margin-bottom: 15px;">Subscribe for exclusive offers and news.</p>
                    <div class="af-newsletter">
                        <input type="email" placeholder="Email Address">
                        <button>Subscribe</button>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid #111; margin-top: 60px; padding-top: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <p style="color: #555; font-size: 11px;">&copy; {{ date('Y') }} {{ $currentTenant->name ?? 'Afnan Perfumes' }}. All Rights Reserved.</p>
                <div style="display: flex; gap: 20px; color: #555; font-size: 16px;">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-youtube"></i>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cart Drawer -->
    <div class="af-drawer-overlay" id="afDrawerOverlay" onclick="toggleCart()"></div>
    <div class="af-cart-drawer" id="afCartDrawer">
        <div class="af-drawer-header">
            <h3 style="font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Shopping Bag</h3>
            <button onclick="toggleCart()" style="background:none; border:none; font-size: 20px; cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div id="af-cart-items-container" style="padding: 20px; height: calc(100% - 150px); overflow-y: auto;">
            <!-- Cart items will be loaded here -->
            <div style="text-align: center; margin-top: 50px; color: #999;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 40px; margin-bottom: 20px; opacity: 0.3;"></i>
                <p>Your bag is empty</p>
            </div>
        </div>
    </div>

    <script>
        function toggleCart() {
            $('#afCartDrawer').toggleClass('open');
            $('#afDrawerOverlay').toggleClass('open');
            if($('#afCartDrawer').hasClass('open')) {
                loadCart();
            }
        }

        function loadCart() {
            $.get("{{ route('v5.cart') }}", function(data) {
                $('#af-cart-items-container').html(data);
            });
        }

        function quickAddV5(productId) {
            $.post("{{ route('cart.add') }}", {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                quantity: 1
            }, function(res) {
                if(res.success) {
                    $('#cart-count-v5').text(res.cart_count);
                    toggleCart();
                    showNotification('Added to Bag');
                }
            });
        }

        function removeFromCartV5(cartId) {
            $.post("{{ route('cart.remove') }}", {
                _token: "{{ csrf_token() }}",
                cart_id: cartId
            }, function(res) {
                if(res.success) {
                    $('#cart-count-v5').text(res.cart_count);
                    loadCart();
                }
            });
        }

        function showNotification(msg) {
            const toast = $('<div class="af-toast">' + msg + '</div>');
            $('body').append(toast);
            setTimeout(() => toast.addClass('show'), 100);
            setTimeout(() => {
                toast.removeClass('show');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        window.onscroll = function() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                $('.af-header').addClass('scrolled');
            } else {
                $('.af-header').removeClass('scrolled');
            }
        };

        function toggleMenu() {
            $('.af-mobile-drawer').toggleClass('open');
            $('.af-mobile-drawer-overlay').toggleClass('open');
        }
    </script>

    <!-- Mobile Drawer -->
    <div class="af-mobile-drawer-overlay" onclick="toggleMenu()"></div>
    <div class="af-mobile-drawer">
        <button class="af-drawer-close" onclick="toggleMenu()"><i class="fa-solid fa-xmark"></i></button>
        <ul class="af-mobile-nav">
            <li><a href="{{ route('v5.home') }}">Home</a></li>
            <li><a href="{{ route('v5.all-products') }}">All Perfumes</a></li>
            <li><a href="{{ route('v5.combos') }}">Exclusive Combos</a></li>
            <li><a href="{{ route('v5.collection') }}">Collections</a></li>
            <li><a href="#">About Us</a></li>
        </ul>
    </div>

    <style>
        .af-toast { position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) translateY(100px); background: #000; color: #fff; padding: 12px 30px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; border-radius: 2px; transition: 0.5s cubic-bezier(0.165, 0.84, 0.44, 1); z-index: 9999; opacity: 0; }
        .af-toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }
    </style>
    @stack('scripts')
</body>

</html>
