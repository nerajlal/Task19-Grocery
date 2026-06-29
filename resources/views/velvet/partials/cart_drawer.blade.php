<div class="cart-drawer-overlay" id="cart-drawer-overlay"></div>
<div class="cart-drawer-v" id="cart-drawer-v">
    <div class="cart-drawer-header-v">
        <h2 class="drawer-title-v">Your Selection</h2>
        <button class="close-drawer-v" id="close-cart-v"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="cart-drawer-body-v" id="cart-drawer-body">
        <!-- Items will be loaded here via AJAX -->
        <div class="cart-loader-v">
            <i class="fa-solid fa-spinner fa-spin"></i>
        </div>
    </div>

    <div class="cart-drawer-footer-v" id="cart-drawer-footer">
        <!-- Footer info (subtotal/checkout) will be loaded here or kept in shell -->
    </div>
</div>

<style>
    .cart-drawer-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 2000;
        display: none;
        transition: opacity 0.3s ease;
    }

    .cart-drawer-v {
        position: fixed;
        top: 0;
        right: -450px;
        width: 450px;
        height: 100%;
        background: #fff;
        z-index: 2001;
        transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        box-shadow: -10px 0 30px rgba(0,0,0,0.1);
    }

    .cart-drawer-v.open {
        right: 0;
    }

    .cart-drawer-header-v {
        padding: 2rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .drawer-title-v {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .close-drawer-v {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
        transition: color 0.2s;
    }

    .close-drawer-v:hover {
        color: #000;
    }

    .cart-drawer-body-v {
        flex-grow: 1;
        overflow-y: auto;
        padding: 2rem;
    }

    .cart-loader-v {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        font-size: 2rem;
        color: #ccc;
    }

    @media (max-width: 500px) {
        .cart-drawer-v {
            width: 100%;
            right: -100%;
        }
    }
</style>
