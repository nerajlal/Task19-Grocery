<div class="cart-drawer-overlay-n" id="cart-drawer-overlay-n"></div>
<div class="cart-drawer-n" id="cart-drawer-n">
    <div class="cart-drawer-header-n">
        <h2 class="drawer-title-n">Shopping Bag</h2>
        <button class="close-drawer-n" id="close-cart-n"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="cart-drawer-body-n" id="cart-drawer-body-n">
        <!-- Items will be loaded here via AJAX -->
        <div class="cart-loader-n">
            <i class="fa-solid fa-spinner fa-spin"></i>
        </div>
    </div>
</div>

<style>
    .cart-drawer-overlay-n {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(2px);
        z-index: 3000;
        display: none;
    }

    .cart-drawer-n {
        position: fixed;
        top: 0;
        right: -400px;
        width: 400px;
        height: 100%;
        background: #fff;
        z-index: 3001;
        transition: right 0.4s ease;
        display: flex;
        flex-direction: column;
        box-shadow: -5px 0 25px rgba(0,0,0,0.1);
    }

    .cart-drawer-n.open {
        right: 0;
    }

    .cart-drawer-header-n {
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary-color);
        color: #fff;
    }

    .drawer-title-n {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    .close-cart-n {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .cart-drawer-body-n {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1.5rem;
    }

    .cart-loader-n {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        font-size: 1.5rem;
        color: #ddd;
    }

    @media (max-width: 450px) {
        .cart-drawer-n {
            width: 100%;
            right: -100%;
        }
    }
</style>
