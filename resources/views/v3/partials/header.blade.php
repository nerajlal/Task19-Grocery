<!-- Promo Bar -->
<div class="promo-bar">
    Free Shipping on all orders above <span>₹399</span>
</div>

<!-- Mobile Header -->
<div class="mobile-header">
    <div class="header-top">
        <button class="menu-btn" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
        <a href="{{ route('v3.home') }}" class="logo">{{ $currentTenant->name ?? 'Task19 Perfumes' }}</a>
        <div class="header-icons">
            <button class="icon-btn" onclick="openSearch()"><i class="fas fa-search"></i></button>
            @auth
                <a href="{{ route('account.index', ['tenant_id' => session('active_tenant_id', 1)]) }}" class="icon-btn" style="color: inherit;" title="My Account"><i class="fas fa-user"></i></a>
            @else
                <a href="javascript:void(0)" onclick="openLogin()" class="icon-btn" style="color: inherit;"><i class="fas fa-user"></i></a>
            @endauth
            <a href="{{ route('v3.cart') }}" class="icon-btn" style="color: inherit;">
                <i class="fas fa-shopping-cart"></i>
                @php
                    if(auth()->check()) {
                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                    } else {
                        $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                    }
                @endphp
                <span class="cart-count" style="{{ $cartCount > 0 ? 'display: flex;' : 'display: none;' }}">{{ $cartCount }}</span>
            </a>
        </div>
    </div>
    <div class="header-search-inline" id="inlineSearch">
        <form action="{{ route('v3.collection') }}" method="GET" class="inline-search-form">
            <button type="submit" class="inline-search-icon"><i class="fas fa-search"></i></button>
            <input type="text" name="q" placeholder="Search..." class="inline-search-input" id="inlineSearchInput">
            <button type="button" class="inline-search-close" onclick="closeSearch()"><i class="fas fa-times"></i></button>
        </form>
    </div>
</div>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="menu-header">
        <span>MENU</span>
        <button class="menu-close" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
    </div>
    <ul class="menu-list">
        <li class="menu-item"><a href="{{ route('v3.home') }}" class="menu-link">Home</a></li>
        <!-- <li class="menu-item"><a href="{{ route('v3.collection') }}" class="menu-link">Shop All</a></li> -->
        <li class="menu-item"><a href="{{ route('v3.all-products') }}" class="menu-link">All Products</a></li>
        <!-- <li class="menu-item"><a href="{{ route('v3.collection') }}" class="menu-link">Categories</a></li> -->
        <li class="menu-item"><a href="{{ route('v3.combos') }}" class="menu-link">Combo Offers</a></li>
        <li class="menu-item"><a href="{{ route('v3.about') }}" class="menu-link">About Us</a></li>
        <li class="menu-item"><a href="{{ route('v3.contact') }}" class="menu-link">Contact</a></li>
    </ul>
</div>
<div class="menu-overlay" id="menuOverlay" onclick="toggleMenu()"></div>

<!-- Login Modal -->
<div class="login-modal" id="loginModal">
    <div class="login-content">
        <button class="login-close" onclick="closeLogin()"><i class="fas fa-times"></i></button>
        <h2 class="login-title">Welcome Back</h2>
        <p class="login-subtitle">Sign in to access your account</p>
        
        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            
            @if($errors->any() && session('open_login'))
                <div class="alert alert-danger" style="color: red; font-size: 13px; margin-bottom: 10px;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <input type="email" name="email" class="form-input" placeholder="Email Address" required value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-input" placeholder="Password" required>
            </div>
            
            <button type="submit" class="login-btn">Sign In</button>
        </form>
        
        <div class="divider"><span>OR</span></div>
        <a href="{{ route('google.login') }}" class="google-btn" style="text-decoration: none;"><i class="fab fa-google"></i> Continue with Google</a>
        
        <div class="login-footer">
            <a href="#" class="forgot-link">Forgot Password?</a>
            <p class="signup-text">Don't have an account? <a href="javascript:void(0)" onclick="openRegister()">Create one</a></p>
        </div>
    </div>
</div>

@if(session('open_register'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        openRegister();
    });
</script>
@endif

@if(session('open_login'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        openLogin();
    });
</script>
@endif

<!-- Register Modal -->
<div class="login-modal" id="registerModal">
    <div class="login-content">
        <button class="login-close" onclick="closeRegister()"><i class="fas fa-times"></i></button>
        <h2 class="login-title">Create Account</h2>
        <p class="login-subtitle">Join us for exclusive offers & updates</p>
        
        <form class="login-form" action="{{ route('register') }}" method="POST">
            @csrf
            
            @if($errors->any() && session('open_register'))
                <div class="alert alert-danger" style="color: red; font-size: 13px; margin-bottom: 10px;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <input type="text" name="name" class="form-input" placeholder="Full Name" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-input" placeholder="Email Address" required value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <input type="tel" name="phone" class="form-input" placeholder="Phone Number" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-input" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="login-btn">Create Account</button>
        </form>
        
        <div class="divider"><span>OR</span></div>
        <a href="{{ route('google.login') }}" class="google-btn" style="text-decoration: none;"><i class="fab fa-google"></i> Continue with Google</a>
        
        <div class="login-footer">
            <p class="signup-text">Already have an account? <a href="javascript:void(0)" onclick="openLogin()">Sign in</a></p>
        </div>
    </div>
</div>

<style>
    /* Inline Search Styles */
    .header-search-inline {
        position: absolute;
        top: 0;
        right: 0;
        width: 0;
        height: 100%;
        background: var(--white);
        z-index: 20;
        display: flex;
        align-items: center;
        padding: 0; /* Padding handled by child or dynamically */
        overflow: hidden;
        transition: width 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
    }
    
    /* No longer hiding header-top, search bar will cover it */
    
    .mobile-header.search-active .header-search-inline {
        width: calc(100% - 130px);
        padding: 0 10px; /* Restore padding when open */
    }

    .inline-search-form {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 300px; /* Prevent layout squashing during anim */
    }
    
    .inline-search-input {
        flex: 1;
        border: none;
        background: #f8f8f8;
        padding: 10px 15px;
        border-radius: 20px;
        font-size: 14px;
        outline: none;
        color: var(--black);
    }
    
    .inline-search-icon, .inline-search-close {
        background: none;
        border: none;
        font-size: 18px;
        color: var(--black);
        cursor: pointer;
        padding: 5px;
    }

    /* Login Modal Styles */
    .login-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 3000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        padding: 20px;
    }
    
    .login-modal.active {
        opacity: 1;
        pointer-events: all;
    }
    
    .login-content {
        background: var(--white);
        width: 100%;
        max-width: 400px;
        border-radius: 16px;
        padding: 40px 30px;
        position: relative;
        transform: translateY(20px);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .login-modal.active .login-content {
        transform: translateY(0);
    }
    
    .login-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
    }
    
    .login-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 5px;
        color: var(--black);
    }
    
    .login-subtitle {
        text-align: center;
        color: var(--text-light);
        font-size: 14px;
        margin-bottom: 30px;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border 0.3s;
    }
    
    .form-input:focus {
        border-color: var(--black);
    }
    
    .login-btn {
        width: 100%;
        padding: 14px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 14px;
        cursor: pointer;
        margin-top: 10px;
        letter-spacing: 1px;
    }
    
    .login-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
    }
    
    .forgot-link {
        display: block;
        color: var(--text-light);
        text-decoration: none;
        margin-bottom: 15px;
    }
    
    .signup-text {
        color: var(--text);
    }
    
    .signup-text a {
        color: var(--black);
        font-weight: 700;
        text-decoration: underline;
    }
    
    /* Social Login */
    .divider {
        display: flex;
        align-items: center;
        margin: 20px 0;
        color: #ccc;
        font-size: 12px;
        font-weight: 600;
    }
    
    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #eee;
    }
    
    .divider span {
        padding: 0 10px;
    }
    
    .google-btn {
        width: 100%;
        padding: 12px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-weight: 600;
        color: var(--text);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .google-btn:hover {
        background: #f8f8f8;
        border-color: #ccc;
    }
</style>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('menuOverlay');
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
        
        if (menu.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    function openSearch() {
        const header = document.querySelector('.mobile-header');
        header.classList.add('search-active');
        const input = document.getElementById('inlineSearchInput');
        if (input) setTimeout(() => input.focus(), 100);
    }

    function closeSearch() {
        const header = document.querySelector('.mobile-header');
        header.classList.remove('search-active');
    }
    
    function openLogin() {
        closeRegister(); // Ensure register is closed
        const modal = document.getElementById('loginModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLogin() {
        const modal = document.getElementById('loginModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openRegister() {
        closeLogin(); // Ensure login is closed
        const modal = document.getElementById('registerModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeRegister() {
        const modal = document.getElementById('registerModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Close modal on outside click
    window.addEventListener('click', function(e) {
        if (e.target.id === 'loginModal') closeLogin();
        if (e.target.id === 'registerModal') closeRegister();
    });
</script>
