<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task19 Perfumes | Luxury Fragrance House')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Dancing+Script:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --aj-gold: #B08D57;
            --aj-dark: #1A1A1A;
            --aj-gray: #777777;
            --aj-border: #EEEEEE;
            --aj-bg: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--aj-dark);
            background: var(--aj-bg);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .serif {
            font-family: 'Playfair Display', serif;
        }

        .cursive {
            font-family: 'Dancing Script', cursive;
            text-transform: none !important;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Top Bar */
        .top-bar {
            background: #F4F4F4;
            text-align: center;
            padding: 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Header */
        header {
            background: #fff;
            padding: 10px 0;
            border-bottom: 1px solid var(--aj-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-main {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 20px;
        }

        .logo {
            text-decoration: none;
            color: var(--aj-dark);
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -1px;
            text-transform: uppercase;
            white-space: nowrap;
            grid-column: 2;
        }

        .logo span {
            color: var(--aj-gold);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 20px;
        }

        .search-bar {
            position: relative;
            max-width: 400px;
            width: 100%;
        }

        .search-bar input {
            width: 100%;
            padding: 8px 15px 8px 35px;
            border: 1.5px solid var(--aj-border);
            border-radius: 50px;
            background: #f8f8f8;
            font-size: 12px;
            outline: none;
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 12px;
        }

        .action-item {
            text-decoration: none;
            color: var(--aj-dark);
            font-size: 18px;
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: var(--aj-gold);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 26px;
            color: #000 !important;
            cursor: pointer;
            display: none;
            padding: 5px;
            transition: 0.3s;
            position: relative;
            z-index: 1001;
        }

        .menu-toggle:hover {
            color: var(--aj-gold);
        }

        /* Navigation */
        .nav-row {
            display: flex;
            justify-content: center;
            gap: 35px;
            padding: 15px 0;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
        }

        .nav-item {
            text-decoration: none;
            color: #000;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: 0.3s;
        }

        .nav-item:hover {
            color: var(--aj-gold);
        }

        /* Mobile Search */
        .mobile-search {
            display: none;
            margin-top: 10px;
            padding: 0 5px;
        }

        @media (max-width: 1100px) {
            .header-main {
                grid-template-columns: 40px 1fr 80px;
                gap: 10px;
            }

            .logo {
                grid-column: 2;
                text-align: center;
                font-size: 18px;
            }

            .search-bar {
                display: none;
            }

            .menu-toggle {
                display: block !important;
            }

            .mobile-search {
                display: block;
            }

            .header-left {
                grid-column: 1;
            }

            .header-right {
                grid-column: 3;
                gap: 15px;
            }

            .nav-row {
                display: none;
            }
        }

        /* Footer */
        footer {
            background: #8B6B3F;
            /* Brown/Gold background from screenshot */
            color: #fff;
            padding: 80px 0 40px;
            margin-top: 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
            gap: 50px;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: 900;
            color: #fff;
            text-decoration: none;
            margin-bottom: 25px;
            display: block;
            text-transform: uppercase;
        }

        .footer-logo span {
            color: var(--aj-gold);
        }

        .footer-col h4 {
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 30px;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: #fff;
            padding-left: 5px;
        }

        .footer-bottom {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 991px) {
            .header-main {
                grid-template-columns: 1fr 1fr;
            }

            .search-bar {
                display: none;
            }

            .nav-row {
                display: none;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="top-bar">
        Free Shipping on Orders Above ₹500 • COD Available • Crafting Memories Since 1951
    </div>

    <header>
        <div class="container">
            <div class="header-main">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></button>
                    <div class="search-bar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search for Perfumes...">
                    </div>
                </div>

                <a href="{{ route('v4.home') }}" class="logo">
                    {{ strtoupper($currentTenant->name ?? 'TASK19 PERFUMES') }}
                </a>

                <div class="header-right">
                    <a href="#" class="action-item"><i class="fa-regular fa-user"></i></a>
                    <a href="#" class="action-item"><i class="fa-regular fa-heart"></i></a>
                    <a href="{{ route('v4.cart') }}" class="action-item">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="cart-badge" id="cart-count">{{ \App\Services\CartService::getCount() }}</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="mobile-search">
                <div class="search-bar" style="display: block; max-width: 100%;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search for Perfumes...">
                </div>
            </div>

            <nav class="nav-row">
                <a href="{{ route('v4.home') }}" class="nav-item">Home</a>
                <a href="{{ route('v4.all-products') }}" class="nav-item">All Perfumes</a>
                <a href="{{ route('v4.combos') }}" class="nav-item">Exclusive Combos</a>
                <a href="{{ route('v4.collection') }}" class="nav-item">Collections</a>
                <!-- <a href="#" class="nav-item">About Us</a> -->
            </nav>
        </div>
    </header>

    <!-- Mobile Drawer -->
    <div class="mobile-drawer" id="mobileDrawer">
        <div class="drawer-header">
            <div class="logo">{{ strtoupper($currentTenant->name ?? 'TASK19 PERFUMES') }}</div>
            <button onclick="toggleMenu()" style="background:none; border:none; font-size:24px;"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>
        <nav class="drawer-nav">
            <a href="{{ route('v4.home') }}">Home</a>
            <a href="{{ route('v4.all-products') }}">All Perfumes</a>
            <a href="{{ route('v4.combos') }}">Exclusive Combos</a>
            <a href="{{ route('v4.collection') }}">Collections</a>
            <!-- <a href="#">About Us</a> -->
        </nav>
    </div>
    <div class="drawer-overlay" id="drawerOverlay" onclick="toggleMenu()"></div>

    <style>
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: #fff;
            z-index: 2000;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding: 30px;
        }

        .mobile-drawer.open {
            left: 0;
        }

        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .drawer-nav {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .drawer-nav a {
            text-decoration: none;
            color: #000;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
        }

        .drawer-overlay.open {
            display: block;
        }
    </style>

    <div class="drawer-overlay" id="drawerOverlay" onclick="toggleMenu()"></div>

    <!-- Cart Drawer -->
    <div class="cart-drawer" id="cartDrawer">
        <div class="drawer-header">
            <div class="logo">YOUR <span>BAG</span></div>
            <button onclick="toggleCart()" style="background:none; border:none; font-size:24px;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div id="cartDrawerContent">
            <!-- Loaded via AJAX -->
        </div>
    </div>
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>

    <style>
        .cart-drawer {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100%;
            background: #fff;
            z-index: 2005;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding: 30px;
            display: flex;
            flex-direction: column;
        }
        .cart-drawer.open { right: 0; }
        .cart-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2004; display: none; }
        .cart-overlay.open { display: block; }
        @media (max-width: 450px) { .cart-drawer { width: 100%; right: -100%; } }
    </style>

    <script>
        function toggleMenu() {
            document.getElementById('mobileDrawer').classList.toggle('open');
            document.getElementById('drawerOverlay').classList.toggle('open');
        }

        function toggleCart() {
            const drawer = document.getElementById('cartDrawer');
            const overlay = document.getElementById('cartOverlay');
            
            if(!drawer.classList.contains('open')) {
                fetchCartDrawer();
            }
            
            drawer.classList.toggle('open');
            overlay.classList.toggle('open');
        }

        function fetchCartDrawer() {
            $.ajax({
                url: "{{ route('cart.fetch') }}",
                method: "GET",
                data: { theme: 'v4' },
                success: function(html) {
                    $('#cartDrawerContent').html(html);
                }
            });
        }

        function quickAdd(productId) {
            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: productId,
                    quantity: 1
                },
                success: function(response) {
                    if(response.success) {
                        $('#cart-count').text(response.cartCount);
                        toggleCart();
                    }
                }
            });
        }

        function drawerUpdateQty(id, delta) {
            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    quantity: delta,
                    relative: true
                },
                success: function(response) {
                    if(response.success) {
                        $('#cart-count').text(response.cartCount);
                        fetchCartDrawer();
                    }
                }
            });
        }

        function drawerRemove(id) {
            $.ajax({
                url: "{{ route('cart.remove') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if(response.success) {
                        $('#cart-count').text(response.cartCount);
                        fetchCartDrawer();
                    }
                }
            });
        }
    </script>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="{{ route('v4.home') }}" class="footer-logo">
                        {{ strtoupper($currentTenant->name ?? 'TASK19 PERFUMES') }}
                    </a>
                    <p style="opacity: 0.8; font-size: 14px;">A world-class fragrance house with a legacy of excellence
                        in the art of perfumery.</p>
                    <div style="margin-top: 30px; display: flex; gap: 20px;">
                        <a href="#" style="color: #fff; font-size: 20px;"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" style="color: #fff; font-size: 20px;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" style="color: #fff; font-size: 20px;"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Collections</h4>
                    <ul class="footer-links">
                        <li><a href="#">Signature Oudh</a></li>
                        <li><a href="#">French Collection</a></li>
                        <li><a href="#">Oriental Blends</a></li>
                        <li><a href="#">Gifting Sets</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Customer Care</h4>
                    <ul class="footer-links">
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <p style="font-size: 14px; opacity: 0.8; line-height: 2;">
                        Customer@task.com<br>
                        +91 123 456 7890<br>
                        10:00 AM - 7:00 PM
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                &copy; {{ date('Y') }} {{ strtoupper($currentTenant->name ?? 'TASK19 PERFUMES') }}. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>