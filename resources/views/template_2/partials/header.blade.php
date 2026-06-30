<header class="store-header" style="display: flex; flex-direction: column; align-items: stretch; height: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.03); background: #fff; border-bottom: 1px solid var(--border-color); padding: 0.5rem 0;">
    <div class="header-container" style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 2rem; gap: 2rem;">
        <a href="{{ route('v3.home') }}" class="logo" style="color: var(--accent-color); font-weight: 800; font-size: 1.6rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0;">
            <i class="fa-solid fa-leaf"></i>{{ $currentTenant->name ?? 'Fresh Grocery' }}
        </a>

        <div class="search-bar" style="flex-grow: 1; max-width: 600px; position: relative;">
            <i class="fa-solid fa-magnifying-glass search-icon" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
            <input type="text" class="search-input" placeholder="Search for fresh vegetables, fruits, dairy, or essentials..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1.5px solid var(--border-color); border-radius: 99px; outline: none; transition: 0.2s; font-size: 0.95rem;">
        </div>

        <div class="header-actions" style="display: flex; align-items: center; gap: 1.5rem; flex-shrink: 0;">
            @auth
                <a href="{{ route('account.index') }}" class="action-btn text-decoration-none" style="display: flex; flex-direction: column; align-items: center; font-size: 0.75rem; font-weight: 600; color: var(--primary-color);">
                    <i class="fa-regular fa-user" style="font-size: 1.25rem; margin-bottom: 0.25rem;"></i>
                    <span class="action-text">Account</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="action-btn text-decoration-none" style="display: flex; flex-direction: column; align-items: center; font-size: 0.75rem; font-weight: 600; color: var(--primary-color);">
                    <i class="fa-regular fa-user" style="font-size: 1.25rem; margin-bottom: 0.25rem;"></i>
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

    <!-- Dynamic Horizontal Top Navigation Menu Bar -->
    <nav class="top-nav-menu-bar" style="border-top: 1px solid var(--border-color); margin-top: 0.5rem; background: #fafafb;">
        <div style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; gap: 2rem; padding: 0.75rem 2rem; overflow-x: auto; white-space: nowrap;">
            <a href="{{ route('v3.home') }}" style="color: var(--primary-color); font-weight: 700; text-decoration: none; font-size: 0.95rem; transition: 0.2s;" class="nav-link-item hover-green">
                <i class="fa-solid fa-house me-1"></i> Home
            </a>
            <a href="{{ route('v3.all-products') }}" style="color: var(--primary-color); font-weight: 700; text-decoration: none; font-size: 0.95rem; transition: 0.2s;" class="nav-link-item hover-green">
                <i class="fa-solid fa-border-all me-1"></i> All Products
            </a>
            <a href="{{ route('v3.combos') }}" style="color: var(--primary-color); font-weight: 700; text-decoration: none; font-size: 0.95rem; transition: 0.2s;" class="nav-link-item hover-green">
                <i class="fa-solid fa-tags me-1"></i> Weekly Combos
            </a>
            @php $topCollections = \App\Models\Collection::where('status', 1)->get(); @endphp
            @foreach($topCollections as $col)
                <a href="{{ route('v3.collection', ['slug' => $col->slug]) }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none; font-size: 0.95rem; transition: 0.2s;" class="nav-link-item hover-green">
                    {{ $col->name }}
                </a>
            @endforeach
        </div>
    </nav>
</header>

<style>
    .hover-green:hover {
        color: var(--accent-color) !important;
    }
</style>
