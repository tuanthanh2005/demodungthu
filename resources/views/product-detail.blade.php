<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #7851A9;
            --primary-2: #a583c7;
            --bg: #f7f4ff;
            --text: #1f2937;
            --muted: #6b7280;
            --card: #ffffff;
            --radius: 16px;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #ffffff, var(--bg));
            color: var(--text);
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(120, 81, 169, 0.2);
        }

        .nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--primary);
            text-decoration: none;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-outline {
            background: #fff;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .cart-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #fff;
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 700;
            cursor: pointer;
            user-select: none;
        }

        /* Cart modal (same behavior as home) */
        .cart-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
        }

        .cart-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .cart-modal {
            position: fixed;
            top: 0;
            right: -420px;
            width: 100%;
            max-width: 420px;
            height: 100vh;
            background: #fff;
            z-index: 9999;
            transition: right 0.25s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        }

        .cart-modal.active {
            right: 0;
        }

        .cart-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .cart-modal-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text);
        }

        .cart-modal-close {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 0;
            background: rgba(0, 0, 0, 0.06);
            cursor: pointer;
            font-size: 1.25rem;
            line-height: 1;
        }

        .cart-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 14px 18px;
        }

        .cart-modal-item {
            display: flex;
            gap: 12px;
            padding: 12px;
            border-radius: 14px;
            background: rgba(120, 81, 169, 0.06);
            margin-bottom: 10px;
        }

        .cart-modal-item img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 12px;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        .cart-item-info {
            flex: 1;
            min-width: 0;
        }

        .cart-item-name {
            font-weight: 800;
            font-size: 0.95rem;
            color: var(--text);
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cart-item-meta {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .cart-item-price {
            color: var(--primary);
            font-weight: 800;
            margin-bottom: 8px;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            border: 0;
            background: #fff;
            cursor: pointer;
            font-weight: 900;
        }

        .qty-display {
            min-width: 26px;
            text-align: center;
            font-weight: 900;
            color: var(--text);
        }

        .cart-item-remove {
            margin-left: auto;
            width: 30px;
            height: 30px;
            border-radius: 999px;
            border: 0;
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
            cursor: pointer;
            font-weight: 900;
        }

        .cart-modal-footer {
            padding: 14px 18px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .cart-total-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .cart-checkout-btn {
            width: 100%;
            border: 0;
            padding: 12px 14px;
            border-radius: 14px;
            font-weight: 900;
            cursor: pointer;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
        }

        .page {
            max-width: 1400px;
            margin: 32px auto 80px;
            padding: 0 24px;
        }

        .detail-card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 16px 40px rgba(120, 81, 169, 0.12);
            padding: 32px;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            gap: 36px;
            margin: 0 auto;
        }

        .image-wrap {
            background: #f3eefe;
            border-radius: var(--radius);
            padding: 16px;
        }

        .main-image {
            width: 100%;
            height: 520px;
            object-fit: cover;
            border-radius: 12px;
            display: block;
        }

        .thumbs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 10px;
            margin-top: 12px;
        }

        .thumbs img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .thumbs img.active {
            border-color: var(--primary);
        }

        .detail-info h1 {
            margin: 0 0 8px;
            font-size: 2.4rem;
        }

        .price {
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--primary);
            margin: 12px 0;
        }

        .category {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(120, 81, 169, 0.15);
            color: var(--primary);
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .desc {
            color: var(--muted);
            line-height: 1.7;
            margin-top: 12px;
            font-size: 1.05rem;
        }

        .tabs {
            margin-top: 40px;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }

        .tab-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 24px;
        }

        .tab-btn {
            padding: 14px 28px;
            border: none;
            background: none;
            cursor: pointer;
            font-weight: 600;
            color: var(--muted);
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            font-size: 1.05rem;
        }

        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .product-specs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .spec-item {
            background: var(--bg);
            padding: 16px;
            border-radius: 12px;
        }

        .spec-label {
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .spec-value {
            font-weight: 700;
            color: var(--text);
        }

        .review {
            background: var(--bg);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .reviewer-name {
            font-weight: 700;
        }

        .review-rating {
            color: #fbbf24;
        }

        .review-text {
            color: var(--muted);
            line-height: 1.6;
        }

        .review-form {
            background: var(--bg);
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .rating-input {
            display: flex;
            gap: 4px;
            margin-bottom: 8px;
        }

        .rating-input input {
            display: none;
        }

        .rating-input label {
            cursor: pointer;
            font-size: 32px;
            color: #d1d5db;
            transition: color 0.2s, transform 0.2s;
        }

        .rating-input label:hover {
            transform: scale(1.1);
        }

        .rating-input input:checked ~ label {
            color: #fbbf24;
        }

        .rating-input .star:hover,
        .rating-input .star:hover ~ .star {
            color: #fbbf24;
        }

        .related-products {
            margin-top: 60px;
        }

        .related-products h2 {
            text-align: center;
            margin-bottom: 32px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 24px;
        }

        .product-card {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(120, 81, 169, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-card-body {
            padding: 16px;
        }

        .product-card h3 {
            margin: 0 0 8px;
            font-size: 1.1rem;
        }

        .product-card .price {
            font-size: 1.3rem;
            margin: 8px 0;
        }

        .desc {
            line-height: 1.6;
            color: var(--muted);
            margin: 16px 0 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .description-content {
            line-height: 1.8;
            color: var(--text);
        }

        .description-content h3 {
            color: var(--primary);
            margin-top: 24px;
            margin-bottom: 12px;
        }

        .description-content ul {
            margin: 12px 0;
            padding-left: 24px;
        }

        .description-content li {
            margin: 8px 0;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
        }

        .state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }

        .footer {
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #2d1b47, #4a3066);
            border-top: 3px solid #7851A9;
            text-align: center;
            color: white;
            margin-top: 60px;
        }

        @media (max-width: 900px) {
            .detail-card {
                grid-template-columns: 1fr;
            }
            .main-image {
                height: 360px;
            }
            .detail-info h1 {
                font-size: 2rem;
            }
            .price {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <a class="logo" href="/">🛒 SHOPPRO</a>
            <div class="nav-actions">
                <a class="btn btn-outline" href="/"> Quay lại </a>
                <div class="cart-chip" role="button" tabindex="0" onclick="toggleCart()">🛒 <span id="cartCount">0</span></div>
            </div>
        </nav>
    </header>

    <div class="cart-modal-overlay" id="cartOverlay"></div>
    <div class="cart-modal" id="cartModal" aria-hidden="true">
        <div class="cart-modal-header">
            <h3>Giỏ hàng</h3>
            <button type="button" class="cart-modal-close" onclick="closeCartModal()" aria-label="Đóng">×</button>
        </div>
        <div class="cart-modal-body">
            <div id="cartItems"></div>
        </div>
        <div class="cart-modal-footer">
            <div class="cart-total-row">
                <div>Tổng</div>
                <div id="cartTotalAmount">0</div>
            </div>
            <button type="button" class="cart-checkout-btn" onclick="goToCheckout()">Thanh toán</button>
        </div>
    </div>

    <main class="page">
        <div id="detailContainer" class="detail-card" style="display:none;"></div>
        <div id="tabsContainer" style="display:none;"></div>
        <div id="relatedProducts" class="related-products" style="display:none;"></div>
        <div id="state" class="state"></div>
    </main>

    <!-- Dynamic Footer -->
    <footer class="dynamic-footer" id="dynamicFooter">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-title" id="footerSiteName">ShopPro VIP</div>
                    <p id="footerAbout"> với đội ngũ tư vấn nhiệt tình và sản phẩm chất lượng cao.</p>
                </div>
                <div class="footer-col">
                    <div class="footer-title">Liên hệ</div>
                    <div class="footer-info">
                        <p><i class="fas fa-map-marker-alt"></i> <span id="footerAddress">123 Đường Nguyễn Văn Linh, Quận 7, TP.HCM</span></p>
                        <p><i class="fas fa-phone"></i> <a id="footerPhone" href="tel:0123456789">0123 456 789</a></p>
                        <p><i class="fas fa-envelope"></i> <a id="footerEmail" href="mailto:contact@shoppro.vn">contact@shoppro.vn</a></p>
                        <p><i class="fas fa-clock"></i> <span id="footerHours">8:00 - 22:00 (Thứ 2 - Chủ Nhật)</span></p>
                    </div>
                </div>
                <div class="footer-col">
                    <div class="footer-title">Kết nối</div>
                    <div class="footer-social">
                        <a id="footerFacebook" href="#" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i> Facebook</a>
                        <a id="footerInstagram" href="#" target="_blank" rel="noopener"><i class="fab fa-instagram"></i> Instagram</a>
                        <a id="footerTiktok" href="#" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i> TikTok</a>
                        <a id="footerYoutube" href="#" target="_blank" rel="noopener"><i class="fab fa-youtube"></i> YouTube</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-copyright" id="footerCopyright"> © 2026 ShopPro VIP | Made with ❤️ by Professional Team</div>
            </div>
        </div>
    </footer>

    <style>
        .dynamic-footer {
            background: linear-gradient(135deg, #2d1b47 0%, #4a3066 50%, #7851A9 100%);
            color: white;
            padding: 60px 0 20px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }

        .dynamic-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.05"><polygon points="0,20 50,0 100,20 150,0 200,20 250,0 300,20 350,0 400,20 450,0 500,20 550,0 600,20 650,0 700,20 750,0 800,20 850,0 900,20 950,0 1000,20 1000,100 0,100"/></svg>') repeat-x;
            animation: wave 20s linear infinite;
        }

        @keyframes wave {
            0% { background-position-x: 0; }
            100% { background-position-x: 1000px; }
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 40px;
        }

        .footer-col {
            animation: fadeInUp 0.8s ease-out;
        }

        .footer-col:nth-child(2) {
            animation-delay: 0.2s;
        }

        .footer-col:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff, #f0e6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-col p {
            margin-bottom: 12px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        .footer-info p {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .footer-info i {
            color: #f0e6ff;
            width: 20px;
            font-size: 1.1rem;
        }

        .footer-info a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-info a:hover {
            color: #f0e6ff;
            text-shadow: 0 0 10px rgba(240, 230, 255, 0.5);
        }

        .footer-social {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-social a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer-social a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .footer-social i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 40px;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }

        .footer-copyright {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            
            .dynamic-footer {
                padding: 40px 0 20px;
            }
            
            .footer-container {
                padding: 0 16px;
            }
            
            .footer-title {
                font-size: 1.3rem;
            }
        }
    </style>

    <script>
        const productSlug = @json($slug);
        let currentProduct = null;
        let cart = [];


        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price || 0);
        }

        function loadCart() {
            try {
                const saved = localStorage.getItem('cart');
                cart = saved ? JSON.parse(saved) : [];
            } catch (e) {
                cart = [];
            }
            updateCartCount();
        }

        function saveCart() {
            try {
                localStorage.setItem('cart', JSON.stringify(cart));
            } catch (e) {
                console.error('Error saving cart:', e);
            }
        }

        function updateCartCount() {
            const total = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            const el = document.getElementById('cartCount');
            if (el) el.textContent = total;
        }

        function formatCartTotal() {
            const total = cart.reduce((sum, item) => {
                const qty = Number(item.quantity) || 1;
                const price = Number(item.price) || 0;
                return sum + price * qty;
            }, 0);
            return formatPrice(total);
        }

        function openCartModal() {
            const overlay = document.getElementById('cartOverlay');
            const modal = document.getElementById('cartModal');
            if (!overlay || !modal) return;
            overlay.classList.add('active');
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            renderCartModal();
        }

        function closeCartModal() {
            const overlay = document.getElementById('cartOverlay');
            const modal = document.getElementById('cartModal');
            if (!overlay || !modal) return;
            overlay.classList.remove('active');
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
        }

        function toggleCart() {
            openCartModal();
        }

        function removeCartItem(index) {
            if (index < 0 || index >= cart.length) return;
            cart.splice(index, 1);
            saveCart();
            updateCartCount();
            renderCartModal();
        }

        function changeCartQty(index, delta) {
            const item = cart[index];
            if (!item) return;
            const next = (Number(item.quantity) || 1) + delta;
            if (next <= 0) {
                removeCartItem(index);
                return;
            }
            item.quantity = next;
            saveCart();
            updateCartCount();
            renderCartModal();
        }

        function renderCartModal() {
            const wrap = document.getElementById('cartItems');
            const totalEl = document.getElementById('cartTotalAmount');
            if (!wrap || !totalEl) return;

            if (!Array.isArray(cart) || cart.length === 0) {
                wrap.innerHTML = `<div style="text-align:center; padding: 24px 10px; color: var(--muted); font-weight: 700;">Giỏ hàng trống</div>`;
                totalEl.textContent = formatPrice(0);
                return;
            }

            wrap.innerHTML = cart.map((item, idx) => {
                const img = item.image || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop&q=80';
                const meta = [item.size, item.color].filter(Boolean).join(' • ');
                return `
                    <div class="cart-modal-item">
                        <img src="${img}" alt="${escapeHtml(item.name || 'Sản phẩm')}" onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=200&h=200&fit=crop&q=80'">
                        <div class="cart-item-info">
                            <div class="cart-item-name">${escapeHtml(item.name || 'Sản phẩm')}</div>
                            ${meta ? `<div class="cart-item-meta">${escapeHtml(meta)}</div>` : `<div class="cart-item-meta"></div>`}
                            <div class="cart-item-price">${formatPrice(item.price)}</div>
                            <div class="cart-item-controls">
                                <button type="button" class="qty-btn" data-qty-minus="${idx}">-</button>
                                <div class="qty-display">${Number(item.quantity) || 1}</div>
                                <button type="button" class="qty-btn" data-qty-plus="${idx}">+</button>
                                <button type="button" class="cart-item-remove" data-remove="${idx}" aria-label="Xóa">×</button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            totalEl.textContent = formatCartTotal();

            wrap.querySelectorAll('[data-qty-minus]').forEach(btn => {
                btn.addEventListener('click', () => changeCartQty(Number(btn.getAttribute('data-qty-minus')), -1));
            });
            wrap.querySelectorAll('[data-qty-plus]').forEach(btn => {
                btn.addEventListener('click', () => changeCartQty(Number(btn.getAttribute('data-qty-plus')), 1));
            });
            wrap.querySelectorAll('[data-remove]').forEach(btn => {
                btn.addEventListener('click', () => removeCartItem(Number(btn.getAttribute('data-remove'))));
            });
        }

        function goToCheckout() {
            if (!Array.isArray(cart) || cart.length === 0) {
                showNotification('⚠️ Giỏ hàng trống!');
                return;
            }
            saveCart();
            window.location.href = '/checkout';
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 90px;
                right: 20px;
                background: linear-gradient(135deg, #7851A9, #a583c7);
                color: white;
                padding: 12px 16px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(120, 81, 169, 0.3);
                z-index: 2000;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 2000);
        }

        function parseSpecs(specsText) {
            if (!specsText || String(specsText).trim() === '') return [];
            return String(specsText)
                .split(/\r?\n/)
                .map(line => line.trim())
                .filter(line => line.length > 0)
                .map(line => {
                    const parts = line.split(':');
                    if (parts.length === 1) {
                        return { label: line, value: '' };
                    }
                    const label = parts.shift().trim(); 
                    const value = parts.join(':').trim();
                    return { label, value };
                });
        }

        function escapeHtml(text) {
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatDetailDescription(text) {
            if (!text || String(text).trim() === '') return '<p>ChÆ°a cÃ³ mÃ´ táº£ chi tiáº¿t.</p>';

            const lines = String(text).split(/\r?\n/);
            let html = '';
            let inList = false;

            const closeList = () => {
                if (inList) {
                    html += '</ul>';
                    inList = false;
                }
            };

            lines.forEach(rawLine => {
                const line = rawLine.trim();
                if (line === '') {
                    closeList();
                    return;
                }

                if (line.startsWith('# ')) {
                    closeList();
                    html += `<h3>${escapeHtml(line.slice(2).trim())}</h3>`;
                    return;
                }

                if (line.startsWith('## ')) {
                    closeList();
                    html += `<h3>${escapeHtml(line.slice(3).trim())}</h3>`;
                    return;
                }

                if (line.startsWith('- ') || line.startsWith('* ')) {
                    if (!inList) {
                        html += '<ul>';
                        inList = true;
                    }
                    html += `<li>${escapeHtml(line.slice(2).trim())}</li>`;
                    return;
                }

                closeList();
                html += `<p>${escapeHtml(line)}</p>`;
            });

            closeList();
            return html;
        }

        function addToCart(product) {
            // Sá»­ dá»¥ng giÃ¡ tá»« variant náº¿u cÃ³
            const price = product.selectedVariant ? product.selectedVariant.price : product.price;
            const variantInfo = product.selectedVariant ? {
                variantId: product.selectedVariant.id,
                size: product.selectedVariant.size,
                color: product.selectedVariant.color
            } : null;

            const existing = cart.find(item => {
                // Náº¿u cÃ³ variant, check cáº£ variantId
                if (variantInfo && item.variantId) {
                    return Number(item.id) === Number(product.id) && Number(item.variantId) === Number(variantInfo.variantId);
                }
                return Number(item.id) === Number(product.id) && !item.variantId;
            });

            if (existing) {
                existing.quantity = (existing.quantity || 1) + 1;
            } else {
                const cartItem = {
                    id: product.id,
                    name: product.name,
                    price: price,
                    image: product.main_image || product.image,
                    quantity: 1
                };
                
                if (variantInfo) {
                    cartItem.variantId = variantInfo.variantId;
                    cartItem.size = variantInfo.size;
                    cartItem.color = variantInfo.color;
                }
                
                cart.push(cartItem);
            }
            
             saveCart();
             updateCartCount();
            const modal = document.getElementById('cartModal');
            if (modal && modal.classList.contains('active')) {
                renderCartModal();
            }
            
             let message = `✅ Đã thêm ${product.name}`;
            if (variantInfo) {
                const details = [];
                if (variantInfo.size) details.push(variantInfo.size);
                if (variantInfo.color) details.push(variantInfo.color);
                if (details.length > 0) message += ` (${details.join(', ')}`;
            }
            message += ' vào giỏ hàng!';
            
            showNotification(message);
        }

        function isProductInStock(product) {
            const variants = Array.isArray(product.variants) ? product.variants : [];
            if (variants.length > 0) {
                return variants.some(v => Number(v.stock) > 0);
            }
            if (product.in_stock === undefined || product.in_stock === null || product.in_stock === '') {
                return true;
            }
            return product.in_stock !== false && product.in_stock !== 0;
        }

        function renderProduct(product) {
            const container = document.getElementById('detailContainer');
            const state = document.getElementById('state');
            const rawImages = [
                product.main_image,
                ...(Array.isArray(product.additional_images) ? product.additional_images : []),
                product.image
            ].filter(Boolean);

            const images = [];
            const seen = new Set();
            rawImages.forEach(img => {
                const key = String(img).trim();
                if (!key || seen.has(key)) return;
                seen.add(key);
                images.push(key);
            });

            const mainImage = images[0] || 'https://via.placeholder.com/600x400?text=Product';
            const isInStock = isProductInStock(product);

            container.innerHTML = `
                <div class="image-wrap">
                    <img id="mainImage" class="main-image" src="${mainImage}" alt="${product.image_alt || product.name}">
                    <div class="thumbs">
                        ${images.map((img, idx) => `
                            <img src="${img}" data-idx="${idx}" class="${idx === 0 ? 'active' : ''}" alt="${product.name}">
                        `).join('')}
                    </div>
                </div>
                <div class="detail-info">
                    <span class="category">${product.category?.name || 'KhÃ¡c'}</span>
                    <h1>${product.name}</h1>
                    
                    ${!isInStock ? '<div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin: 10px 0; font-weight: 600; text-align: center;">❌ Sản phẩm hiện đang hết hàng</div>' : ''}
                    
                    <div class="price" id="product-price">${formatPrice(product.price)}</div>
                    
                    <!-- Variants Section -->
                    <div id="variants-container" style="margin: 20px 0;"></div>
                    
                    <div class="desc">${product.description || 'Chưa có mô tả chi tiết.'}</div>
                    <div class="actions">
                        <button class="btn btn-primary" id="addToCartBtn" ${!isInStock ? 'disabled' : ''} style="${!isInStock ? 'opacity: 0.5; cursor: not-allowed; pointer-events: none;' : ''}">
                            ${isInStock ? '🛒 Thêm vào giỏ hàng' : '❌ Hết hàng'}
                        </button>
                        <a class="btn btn-outline" id="checkoutBtn" href="/checkout" ${!isInStock ? 'style="opacity: 0.5; pointer-events: none; cursor: not-allowed;"' : ''}>Thanh toán</a>
                    </div>
                </div>
            `;

            container.style.display = 'grid';
            state.style.display = 'none';

            container.querySelectorAll('.thumbs img').forEach(img => {
                img.addEventListener('click', () => {
                    container.querySelectorAll('.thumbs img').forEach(i => i.classList.remove('active'));
                    img.classList.add('active');
                    const main = document.getElementById('mainImage');
                    main.src = img.src;
                });
            });

            const addBtn = document.getElementById('addToCartBtn');
            const checkoutBtn = document.getElementById('checkoutBtn');
            
            if (isInStock && !addBtn.disabled) {
                addBtn.addEventListener('click', () => {
                    if (!addBtn.disabled) {
                        addToCart(product);
                    }
                });
            }
            
            // Hiá»ƒn thá»‹ thÃ´ng bÃ¡o khi click vÃ o nÃºt bá»‹ disable
            if (!isInStock) {
                addBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    alert('❌ Sản phẩm hiện đang hết hàng');
                });
                
                checkoutBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    alert('❌ Sản phẩm hiện đang hết hàng');
                });
            }

            renderTabs(product);
            loadRelatedProducts(product.category_id);
        }

        function renderTabs(product) {
            const tabsContainer = document.getElementById('tabsContainer');
            const detailText = product.detail_description || product.description || '';
            const specs = parseSpecs(product.specs || '');
            const showSpecsTab = specs.length > 0;
            tabsContainer.innerHTML = `
                <div class="tabs">
                    <div class="tab-buttons">
                        <button class="tab-btn active" data-tab="description">Mô tả</button>
                        ${showSpecsTab ? '<button class="tab-btn" data-tab="specs">Thông số kỹ thuật</button>' : ''}
                        <button class="tab-btn" data-tab="reviews">Đánh giá (${mockReviews.length})</button>
                    </div>
                    
                    <div class="tab-content active" id="description">
                        <div class="description-content">
                            ${formatDetailDescription(detailText)}
                        </div>
                    </div>
                    
                    ${showSpecsTab ? `
                    <div class="tab-content" id="specs">
                        <div class="product-specs">
                            ${specs.map(item => `
                                <div class="spec-item">
                                    <div class="spec-label">${item.label}</div>
                                    <div class="spec-value">${item.value || '-'}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    ` : ''}
                    
                    <div class="tab-content" id="reviews">
                        <div id="reviewsList"></div>
                        <div class="review-form">
                            <h3>Viết đánh giá của bạn</h3>
                            <form id="reviewForm">
                                <div class="form-group">
                                    <label>Đánh giá của bạn: <span id="ratingDisplay" style="color: #fbbf24; font-weight: 700;"></span></label>
                                    <div class="rating-input" id="ratingStars">
                                        <label class="star" data-value="1">★</label>
                                        <label class="star" data-value="2">★</label>
                                        <label class="star" data-value="3">★</label>
                                        <label class="star" data-value="4">★</label>
                                        <label class="star" data-value="5">★</label>
                                    </div>
                                    <input type="hidden" name="rating" id="ratingValue" required>
                                </div>
                                <div class="form-group">
                                    <label>Họ tên:</label>
                                    <input type="text" id="reviewerName" required>
                                </div>
                                <div class="form-group">
                                    <label>Nội dung đánh giá:</label>
                                    <textarea id="reviewText" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            
            tabsContainer.style.display = 'block';
            
            // Tab switching
            tabsContainer.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    tabsContainer.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                    tabsContainer.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                    btn.classList.add('active');
                    const tabId = btn.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            renderReviews();
            
            // Setup rating stars
            setupRatingStars();
            
            // Review form
            document.getElementById('reviewForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const rating = document.getElementById('ratingValue').value;
                const name = document.getElementById('reviewerName').value;
                const text = document.getElementById('reviewText').value;
                
                if (!rating) {
                    alert('⭐ Vui lòng chọn số sao đánh giá!');
                    return;
                }
                
                // Add new review to mock array
                mockReviews.unshift({
                    name: name,
                    rating: parseInt(rating),
                    date: new Date().toLocaleDateString('vi-VN'),
                    text: text
                });
                
                renderReviews();
                showNotification('✓ Cảm ơn bạn đã đánh giá!');
                e.target.reset();
                document.getElementById('ratingValue').value = '';
                document.getElementById('ratingDisplay').textContent = '';
                setupRatingStars(); // Reset stars
            });
        }

        function setupRatingStars() {
            let selectedRating = 0;
            const stars = document.querySelectorAll('#ratingStars .star');
            const ratingDisplay = document.getElementById('ratingDisplay');
            const ratingValue = document.getElementById('ratingValue');
            
            stars.forEach((star, index) => {
                // Click to select
                star.addEventListener('click', () => {
                    selectedRating = parseInt(star.getAttribute('data-value'));
                    ratingValue.value = selectedRating;
                    ratingDisplay.textContent = `${selectedRating} sao`;
                    updateStars(selectedRating);
                });
                
                // Hover effect
                star.addEventListener('mouseenter', () => {
                    const hoverValue = parseInt(star.getAttribute('data-value'));
                    updateStars(hoverValue);
                });
            });
            
            // Reset on mouse leave container
            document.getElementById('ratingStars').addEventListener('mouseleave', () => {
                updateStars(selectedRating);
            });
            
            function updateStars(value) {
                stars.forEach((star, index) => {
                    const starValue = parseInt(star.getAttribute('data-value'));
                    if (starValue <= value) {
                        star.style.color = '#fbbf24';
                    } else {
                        star.style.color = '#d1d5db';
                    }
                });
            }
        }

        const mockReviews = [
            {
                name: 'Nguyễn Văn A',
                rating: 5,
                date: '20/01/2026',
                text: 'Sản phẩm rất tốt, chất lượng vượt mong đợi. Giao hàng nhanh, đóng gói cẩn thận. Rất hài lòng!'
            },
            {
                name: 'Trần Thị B',
                rating: 4,
                date: '18/01/2026',
                text: 'Sản phẩm đẹp, đúng như mô tả. Giá cả hợp lý. Sẽ ủng hộ shop tiếp!'
            },
            {
                name: 'Lê Văn C',
                rating: 5,
                date: '15/01/2026',
                text: 'Tuyệt vời! Đã mua lần 2 rồi. Chất lượng ổn định, shop tư vấn nhiệt tình.'
            }
        ];

        function renderReviews() {
            const reviewsList = document.getElementById('reviewsList');
            reviewsList.innerHTML = mockReviews.map(review => `
                <div class="review">
                    <div class="review-header">
                        <div>
                            <div class="reviewer-name">${review.name}</div>
                            <div style="font-size: 0.85rem; color: var(--muted);">${review.date}</div>
                        </div>
                        <div class="review-rating">${'⭐'.repeat(review.rating)}</div>
                    </div>
                    <div class="review-text">${review.text}</div>
                </div>
            `).join('');
        }

        async function loadRelatedProducts(categoryId) {
            try {
                const res = await fetch('/api/products');
                if (!res.ok) return;
                const products = await res.json();
                const related = products
                    .filter(p => p.category_id === categoryId && p.id !== currentProduct.id)
                    .slice(0, 4);
                
                if (related.length > 0) {
                    renderRelatedProducts(related);
                }
            } catch (e) {
                console.error('Error loading related products:', e);
            }
        }

        function renderRelatedProducts(products) {
            const container = document.getElementById('relatedProducts');
            container.innerHTML = `
                <h2>🔥 Sản phẩm liên quan</h2>
                <div class="product-grid">
                    ${products.map(product => `
                        <div class="product-card" onclick="window.location.href='/products/${product.slug}'">
                            <img src="${product.main_image || product.image || 'https://via.placeholder.com/250x200'}" alt="${product.name}">
                            <div class="product-card-body">
                                <h3>${product.name}</h3>
                                <div class="price">${formatPrice(product.price)}</div>
                                <button class="btn btn-primary" onclick="event.stopPropagation(); addToCartById(${product.id}, '${product.name}', ${product.price}, '${product.main_image || product.image}')">
                                    Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
            container.style.display = 'block';
        }

        function addToCartById(id, name, price, image) {
            const product = { id, name, price, image };
            addToCart(product);
        }

        async function loadProduct() {
            try {
                const res = await fetch(`/api/products/slug/${encodeURIComponent(productSlug)}`);
                if (!res.ok) throw new Error('not-found');
                const product = await res.json();
                currentProduct = product;
                renderProduct(product);
                
                // Render variants if available
                if (product.variants && product.variants.length > 0) {
                    renderVariants(product.variants, product.price);
                }
            } catch (e) {
                const state = document.getElementById('state');
                state.textContent = 'Không tìm thấy sản phẩm.';
            }
        }

        // Render variants selector
        function renderVariants(variants, basePrice) {
            const container = document.getElementById('variants-container');
            if (!container || !variants || variants.length === 0) return;

            // Mapping mÃ u text sang mÃ u tháº­t
            const colorMap = {
                'Äá»': '#dc2626',
                'Xanh': '#2563eb',
                'Äen': '#1f2937',
                'Tráº¯ng': '#ffffff',
                'VÃ ng': '#eab308',
                'Xanh lÃ¡': '#16a34a',
                'Há»“ng': '#ec4899',
                'TÃ­m': '#9333ea',
                'Cam': '#ea580c',
                'XÃ¡m': '#6b7280',
                'NÃ¢u': '#92400e',
                'Be': '#d4c5b9'
            };

            function getColorHex(colorName) {
                return colorMap[colorName] || '#6b7280';
            }

            // NhÃ³m variants theo size vÃ  color
            const sizes = [...new Set(variants.map(v => v.size).filter(Boolean))];
            const colors = [...new Set(variants.map(v => v.color).filter(Boolean))];

            // Check stock cho tá»«ng size/color
            function hasStock(size, color) {
                return variants.some(v => {
                    const sizeMatch = !size || v.size === size;
                    const colorMatch = !color || v.color === color;
                    return sizeMatch && colorMatch && v.stock > 0;
                });
            }

            let html = '<div style="display: flex; flex-direction: column; gap: 20px;">';

            // Size selector
            if (sizes.length > 0) {
                html += `
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 10px; color: var(--text);">
                           Kích thước | Phiên Bản
                        </label>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            ${sizes.map(size => {
                                const inStock = hasStock(size, null);
                                return `
                                <button 
                                    class="variant-size-btn" 
                                    data-size="${size}"
                                    ${!inStock ? 'disabled' : ''}
                                    style="
                                        padding: 10px 20px;
                                        border: 2px solid ${inStock ? '#ddd' : '#e5e7eb'};
                                        background: ${inStock ? 'white' : '#f3f4f6'};
                                        border-radius: 8px;
                                        cursor: ${inStock ? 'pointer' : 'not-allowed'};
                                        font-weight: 500;
                                        transition: all 0.3s;
                                        opacity: ${inStock ? '1' : '0.5'};
                                        position: relative;
                                    "
                                    ${inStock ? `onmouseover="this.style.borderColor='var(--primary)'" onmouseout="if(!this.classList.contains('active')) this.style.borderColor='#ddd'"` : ''}
                                >
                                    ${size}
                                    ${!inStock ? '<span style="display: block; font-size: 10px; color: #ef4444; font-weight: 600;">Hết hàng</span>' : ''}
                                </button>
                            `;
                            }).join('')}
                        </div>
                    </div>
                `;
            }

            // Color selector vá»›i mÃ u tháº­t
            if (colors.length > 0) {
                html += `
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 10px; color: var(--text);">
                            Mã màu sắc
                        </label>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            ${colors.map(color => {
                                const inStock = hasStock(null, color);
                                const hexColor = getColorHex(color);
                                const isLight = hexColor === '#ffffff';
                                return `
                                <button 
                                    class="variant-color-btn" 
                                    data-color="${color}"
                                    ${!inStock ? 'disabled' : ''}
                                    style="
                                        padding: 8px 16px;
                                        border: 2px solid ${inStock ? (isLight ? '#ddd' : hexColor) : '#e5e7eb'};
                                        background: ${inStock ? 'white' : '#f3f4f6'};
                                        border-radius: 8px;
                                        cursor: ${inStock ? 'pointer' : 'not-allowed'};
                                        font-weight: 500;
                                        transition: all 0.3s;
                                        opacity: ${inStock ? '1' : '0.5'};
                                        display: flex;
                                        align-items: center;
                                        gap: 8px;
                                    "
                                    ${inStock ? `onmouseover="this.style.borderColor='var(--primary)'" onmouseout="if(!this.classList.contains('active')) this.style.borderColor='${isLight ? '#ddd' : hexColor}'"` : ''}
                                >
                                    <span style="
                                        width: 20px;
                                        height: 20px;
                                        border-radius: 50%;
                                        background: ${hexColor};
                                        border: ${isLight ? '1px solid #ddd' : 'none'};
                                        display: inline-block;
                                    "></span>
                                    <span>${color}</span>
                                    ${!inStock ? '<span style="font-size: 10px; color: #ef4444; font-weight: 600;">Hết hàng</span>' : ''}
                                </button>
                            `;
                            }).join('')}
                        </div>
                    </div>
                `;
            }

            html += '</div>';
            container.innerHTML = html;

            // Setup variant selection handlers
            let selectedSize = null;
            let selectedColor = null;

            // Size button handlers
            document.querySelectorAll('.variant-size-btn:not([disabled])').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.variant-size-btn').forEach(b => {
                        if (!b.disabled) {
                            b.classList.remove('active');
                            b.style.borderColor = '#ddd';
                            b.style.background = 'white';
                        }
                    });
                    this.classList.add('active');
                    this.style.borderColor = 'var(--primary)';
                    this.style.background = 'var(--bg)';
                    selectedSize = this.dataset.size;
                    updateSelectedVariant();
                });
            });

            // Color button handlers
            document.querySelectorAll('.variant-color-btn:not([disabled])').forEach(btn => {
                btn.addEventListener('click', function() {
                    const hexColor = getColorHex(this.dataset.color);
                    const isLight = hexColor === '#ffffff';
                    
                    document.querySelectorAll('.variant-color-btn').forEach(b => {
                        if (!b.disabled) {
                            const bHex = getColorHex(b.dataset.color);
                            const bIsLight = bHex === '#ffffff';
                            b.classList.remove('active');
                            b.style.borderColor = bIsLight ? '#ddd' : bHex;
                            b.style.background = 'white';
                        }
                    });
                    this.classList.add('active');
                    this.style.borderColor = 'var(--primary)';
                    this.style.background = 'var(--bg)';
                    selectedColor = this.dataset.color;
                    updateSelectedVariant();
                });
            });

            function updateSelectedVariant() {
                // Kiá»ƒm tra stock cá»§a sáº£n pháº©m
                const isInStock = isProductInStock(currentProduct);
                
                // Kiá»ƒm tra xem Ä‘Ã£ chá»n Ä‘á»§ size vÃ  color chÆ°a
                const hasSize = sizes.length > 0;
                const hasColor = colors.length > 0;
                const sizeSelected = !hasSize || selectedSize;
                const colorSelected = !hasColor || selectedColor;
                const allSelected = sizeSelected && colorSelected;
                
                // Enable/disable nÃºt thÃªm giá» vÃ  thanh toÃ¡n
                const addBtn = document.getElementById('addToCartBtn');
                const checkoutBtn = document.getElementById('checkoutBtn');
                
                if (addBtn) {
                    // Chá»‰ enable khi: (1) sáº£n pháº©m cÃ²n hÃ ng, (2) Ä‘Ã£ chá»n Ä‘á»§ variants
                    if (isInStock && allSelected) {
                        addBtn.disabled = false;
                        addBtn.style.opacity = '1';
                        addBtn.style.cursor = 'pointer';
                        addBtn.style.pointerEvents = 'auto';
                    } else {
                        addBtn.disabled = true;
                        addBtn.style.opacity = '0.5';
                        addBtn.style.cursor = 'not-allowed';
                        addBtn.style.pointerEvents = 'none';
                    }
                }
                
                if (checkoutBtn) {
                    // Chá»‰ enable khi: (1) sáº£n pháº©m cÃ²n hÃ ng, (2) Ä‘Ã£ chá»n Ä‘á»§ variants
                    if (isInStock && allSelected) {
                        checkoutBtn.style.opacity = '1';
                        checkoutBtn.style.pointerEvents = 'auto';
                        checkoutBtn.style.cursor = 'pointer';
                    } else {
                        checkoutBtn.style.opacity = '0.5';
                        checkoutBtn.style.pointerEvents = 'none';
                        checkoutBtn.style.cursor = 'not-allowed';
                    }
                }
                
                // TÃ¬m variant phÃ¹ há»£p
                const matchedVariant = variants.find(v => {
                    const sizeMatch = !selectedSize || v.size === selectedSize;
                    const colorMatch = !selectedColor || v.color === selectedColor;
                    return sizeMatch && colorMatch;
                });

                if (matchedVariant) {
                    // Cáº­p nháº­t giÃ¡
                    const priceEl = document.getElementById('product-price');
                    if (priceEl) {
                        priceEl.textContent = formatPrice(matchedVariant.price);
                    }
                    
                    // LÆ°u variant Ä‘Ã£ chá»n vÃ o product
                    currentProduct.selectedVariant = matchedVariant;
                } else {
                    // Reset vá» giÃ¡ gá»‘c náº¿u khÃ´ng tÃ¬m tháº¥y
                    const priceEl = document.getElementById('product-price');
                    if (priceEl) {
                        priceEl.textContent = formatPrice(basePrice);
                    }
                    currentProduct.selectedVariant = null;
                }
            }
            
            // Disable nÃºt thÃªm giá» vÃ  thanh toÃ¡n ban Ä‘áº§u náº¿u cÃ³ variants
            if (sizes.length > 0 || colors.length > 0) {
                const addBtn = document.getElementById('addToCartBtn');
                const checkoutBtn = document.getElementById('checkoutBtn');
                
                if (addBtn) {
                    addBtn.disabled = true;
                    addBtn.style.opacity = '0.5';
                    addBtn.style.cursor = 'not-allowed';
                    
                    // ThÃªm event listener Ä‘á»ƒ hiá»ƒn thá»‹ thÃ´ng bÃ¡o
                    addBtn.addEventListener('click', (e) => {
                        if (addBtn.disabled) {
                            e.preventDefault();
                            let missing = [];
                            if (sizes.length > 0 && !selectedSize) missing.push('Size');
                            if (colors.length > 0 && !selectedColor) missing.push('MÃ u sáº¯c');
                            showNotification('âš ï¸ Vui lÃ²ng chá»n: ' + missing.join(', '));
                        }
                    });
                }
                
                if (checkoutBtn) {
                    checkoutBtn.style.opacity = '0.5';
                    checkoutBtn.style.pointerEvents = 'none';
                    
                    // ThÃªm event listener Ä‘á»ƒ hiá»ƒn thá»‹ thÃ´ng bÃ¡o
                    checkoutBtn.addEventListener('click', (e) => {
                        if (checkoutBtn.style.pointerEvents === 'none') {
                            e.preventDefault();
                            let missing = [];
                            if (sizes.length > 0 && !selectedSize) missing.push('Size');
                            if (colors.length > 0 && !selectedColor) missing.push('Màu sắc');
                            showNotification('⭐ Vui lòng chọn: ' + missing.join(', '));
                        }
                    });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadCart();
            loadProduct();
            loadFooterSettings();
            loadWebsiteSettings();

            const chip = document.querySelector('.cart-chip');
            if (chip) {
                chip.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleCart();
                    }
                });
            }

            const overlay = document.getElementById('cartOverlay');
            if (overlay) {
                overlay.addEventListener('click', closeCartModal);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeCartModal();
        });

        // Load footer settings from API
        async function loadFooterSettings() {
            try {
                const response = await fetch('/api/settings/footer');
                if (response.ok) {
                    const settings = await response.json();
                    
                    // Update footer content
                    document.getElementById('footerSiteName').textContent = settings.site_name || 'ShopPro VIP';
                    document.getElementById('footerAbout').textContent = settings.description || settings.footer_about || 'Website bán hàng chuyên nghiệp với đội ngũ tư vấn nhiệt tình và sản phẩm chất lượng cao.';
                    document.getElementById('footerAddress').textContent = settings.address || '123 Đường Nguyễn Văn Linh, Quận 7, TP.HCM';
                    document.getElementById('footerPhone').textContent = settings.phone || '0123 456 789';
                    document.getElementById('footerPhone').href = 'tel:' + (settings.phone || '0123456789').replace(/\s/g, '');
                    document.getElementById('footerEmail').textContent = settings.email || 'contact@shoppro.vn';
                    document.getElementById('footerEmail').href = 'mailto:' + (settings.email || 'contact@shoppro.vn');
                    document.getElementById('footerHours').textContent = settings.operating_hours || settings.working_hours || '8:00 - 22:00 (Thứ 2 - Chủ Nhật)';
                    
                    // Update social links
                    if (settings.facebook || settings.social_facebook) {
                        document.getElementById('footerFacebook').href = settings.facebook || settings.social_facebook;
                    }
                    if (settings.instagram || settings.social_instagram) {
                        document.getElementById('footerInstagram').href = settings.instagram || settings.social_instagram;
                    }
                    if (settings.tiktok || settings.social_tiktok) {
                        document.getElementById('footerTiktok').href = settings.tiktok || settings.social_tiktok;
                    }
                    if (settings.youtube || settings.social_youtube) {
                        document.getElementById('footerYoutube').href = settings.youtube || settings.social_youtube;
                    }
                    
                    // Update copyright
                    const currentYear = new Date().getFullYear();
                    document.getElementById('footerCopyright').innerHTML = settings.copyright || settings.copyright_text || `© ${currentYear} ShopPro VIP | Made with ❤️ by Professional Team`;
                }
            } catch (error) {
                console.error('Error loading footer settings:', error);
                // Keep default values on error
            }
        }
        
        // Load website theme settings
        async function loadWebsiteSettings() {
            try {
                const response = await fetch('/api/settings/website');
                if (response.ok) {
                    const settings = await response.json();
                    
                    // Update CSS variables
                    if (settings.primary_color) {
                        document.documentElement.style.setProperty('--primary', settings.primary_color);
                        document.documentElement.style.setProperty('--primary-2', settings.secondary_color || settings.primary_color);
                    }
                    
                    if (settings.accent_color) {
                        document.documentElement.style.setProperty('--accent', settings.accent_color);
                    }
                    
                    // Update page title
                    if (settings.website_name) {
                        // Update header logo
                        const headerLogo = document.querySelector('.logo');
                        if (headerLogo) {
                            headerLogo.textContent = settings.website_name;
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading website settings:', error);
            }
        }
    </script>
</body>
</html>

