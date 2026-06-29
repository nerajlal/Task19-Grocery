<header class="store-header">
    <div class="header-container">
        <button id="mobile-menu-toggle" class="mobile-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a href="{{ route('v1.home') }}" class="logo">
            {{ $currentTenant->name ?? 'VESPR Perfumes' }}
        </a>

        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" class="search-input" placeholder="Search for luxury fragrances, oils, or collections...">
        </div>

        <div class="header-actions">
            @auth
                <a href="{{ route('account.index') }}" class="action-btn">
                    <i class="fa-regular fa-user"></i>
                    <span class="action-text">Account</span>
                </a>
            @else
                <button class="action-btn" onclick="openModal('login-modal')">
                    <i class="fa-regular fa-user"></i>
                    <span class="action-text">Log In</span>
                </button>
            @endauth

            <a href="{{ route('v1.cart') }}" class="action-btn cart-btn" id="cart-trigger-n">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="cart-count">{{ \App\Models\Cart::where('user_id', auth()->id())->count() }}</span>
            </a>
        </div>
    </div>

</header>
