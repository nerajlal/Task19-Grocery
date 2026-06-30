<header class="store-header">
    <div class="header-container">
        <button id="mobile-menu-toggle" class="mobile-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a href="{{ route('v3.home') }}" class="logo" style="color: var(--accent-color); font-weight: 800; font-size: 1.5rem; text-decoration: none;">
            <i class="fa-solid fa-basket-shopping me-2"></i>{{ $currentTenant->name ?? 'Fresh Grocery' }}
        </a>

        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" class="search-input" placeholder="Search for fresh vegetables, fruits, dairy, or essentials...">
        </div>

        <div class="header-actions">
            @auth
                <a href="{{ route('account.index') }}" class="action-btn text-decoration-none">
                    <i class="fa-regular fa-user"></i>
                    <span class="action-text">Account</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="action-btn text-decoration-none">
                    <i class="fa-regular fa-user"></i>
                    <span class="action-text">Log In</span>
                </a>
            @endauth

            <a href="javascript:void(0)" class="action-btn cart-btn text-decoration-none" onclick="toggleNCart(true)">
                <i class="fa-solid fa-cart-shopping"></i>
                @php
                    $tenantId = $currentTenant->id ?? 1;
                    $cartCount = auth()->check() 
                        ? \App\Models\Cart::where('tenant_id', $tenantId)->where('user_id', auth()->id())->sum('quantity')
                        : collect(session()->get('cart', []))->sum('quantity');
                @endphp
                <span id="cart-count" class="cart-count" style="background-color: var(--accent-color);">{{ $cartCount }}</span>
            </a>
        </div>
    </div>
</header>
