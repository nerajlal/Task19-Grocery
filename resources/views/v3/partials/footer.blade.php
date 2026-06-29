<!-- Footer -->
<footer>
    <div class="footer-content">
        <!-- Brand Column -->
        <div class="footer-col">
            <div class="footer-logo">{{ $currentTenant->name ?? 'Task19 Perfumes' }}</div>
            <p class="footer-tagline">Crafting memories through scents. India's first perfume bar offering exceptional,
                long-lasting fragrances.</p>
            <div class="footer-social">
                <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <!-- Shop Column -->
        <div class="footer-col">
            <h3 class="footer-heading">Shop</h3>
            <ul class="footer-links">
                <li><a href="{{ route('v3.collection', ['category' => 'fresh']) }}">Fresh Collection</a></li>
                <li><a href="{{ route('v3.collection', ['category' => 'oriental-woody']) }}">Oriental & Woody</a></li>
                <li><a href="{{ route('v3.collection', ['category' => 'floral']) }}">Floral Collection</a></li>
                <li><a href="{{ route('v3.all-products') }}">All Perfumes</a></li>
                <li><a href="{{ route('v3.combos') }}">Combo Offers</a></li>
            </ul>
        </div>

        <!-- Support Column -->
        <div class="footer-col">
            <h3 class="footer-heading">Support</h3>
            <ul class="footer-links">
                <li><a href="{{ route('v3.about') }}">About Us</a></li>
                <li><a href="{{ route('v3.contact') }}">Contact Us</a></li>
                <!-- <li><a href="#">Store Locator</a></li> -->
                <li><a href="{{ route('v3.shipping-policy') }}">Shipping Policy</a></li>
                <li><a href="{{ route('v3.return-policy') }}">Returns & Exchanges</a></li>
                <li><a href="{{ route('v3.terms-of-service') }}">Terms of Service</a></li>
            </ul>
        </div>

        <!-- Chat Support Column -->
        <div class="footer-col">
            <h3 class="footer-heading">Need Assistance?</h3>
            <p class="newsletter-text">Have questions concerning our perfumes? Chat with our support team for instant
                assistance.</p>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="copyright">
            © {{ date('Y') }} {{ $currentTenant->name ?? 'Task19 Perfumes' }}. All rights reserved.
            <span style="opacity: 0.7; margin-left: 5px;">Developed by <a href="#" target="_blank"
                    style="color: var(--gold); text-decoration: none; font-weight: bold;">Task19</a></span>
        </div>
        <div class="payment-icons">
            <i class="fab fa-cc-visa"></i>
            <i class="fab fa-cc-mastercard"></i>
            <i class="fab fa-cc-amex"></i>
            <i class="fab fa-google-pay"></i>
        </div>
    </div>
</footer>

<!-- Quick Action Button -->
<div class="quick-action">
    <a href="https://wa.me/8547470675" target="_blank" class="action-btn"
        style="background-color: #25D366; display: flex; align-items: center; justify-content: center; text-decoration: none;">
        <i class="fab fa-whatsapp" style="font-size: 24px;"></i>
    </a>
</div>