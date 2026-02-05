<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sản phẩm</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style-new.css">
    <link rel="stylesheet" href="/css/mobile-optimization.css">
    <style>
        /* Align colors with ShopPro VIP system (home/mobile theme) */
        :root {
            --primary: #7851A9;
            --primary-dark: #6b439a;
            --primary-light: rgba(120, 81, 169, 0.12);
            --secondary: #a583c7;
            --accent: #B085D2;
            --gradient: linear-gradient(135deg, #7851A9 0%, #9B6BC5 50%, #B085D2 100%);
            --gradient-hover: linear-gradient(135deg, #6b439a 0%, #8f5bb7 50%, #a86fcd 100%);
        }

        body {
            background: var(--gray-50);
        }

        .products-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px;
            padding-bottom: calc(var(--mobile-nav-height) + 32px);
        }

        .products-header {
            position: sticky;
            top: 0;
            z-index: 9992;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 14px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--gray-100);
            color: var(--gray-900);
            text-decoration: none;
            font-weight: 700;
        }

        .products-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-right: 6px;
            white-space: nowrap;
        }

        .search-input {
            flex: 1;
            height: 44px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            padding: 0 12px;
            outline: none;
            background: white;
        }

        .cart-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 44px;
            padding: 0 14px;
            border-radius: 999px;
            background: var(--gradient);
            color: #fff;
            border: 0;
            font-weight: 900;
            cursor: pointer;
            white-space: nowrap;
              font-size: 24px;
        }

        .cart-chip span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.22);
            font-size: 0.85rem;
        }

        .filters {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 6px 2px 10px;
            margin-bottom: 12px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .filters::-webkit-scrollbar {
            display: none;
        }

        .filters .filter-btn {
            white-space: nowrap;
            padding: 5px;
        }

        /* Make category pills a bit stronger */
        .filter-btn {
            background: rgba(120, 81, 169, 0.08);
            border: 1px solid rgba(120, 81, 169, 0.10);
            color: var(--gray-800);
        }

        .filter-btn:hover {
            background: rgba(120, 81, 169, 0.12);
        }

        @media (min-width: 769px) {
            .filters {
                justify-content: center;
                flex-wrap: wrap;
                overflow: visible;
                padding: 10px 0 12px;
            }

            .filters .filter-btn {
                font-size: 1rem;
                padding: 12px 18px;
                border-radius: 14px;
            }
        }

        .products-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 6px 2px 14px;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 48px 16px;
            color: var(--gray-600);
        }

        @media (max-width: 768px) {
            .products-page {
                padding: 12px;
            }

            .products-title {
                display: none;
            }

            .cart-chip {
                padding: 0 12px;
            }
        }
    </style>
</head>
<body>
    <div class="products-page">
        <div class="products-header">
            <a class="back-btn" href="/" aria-label="Về trang chủ">←</a>
            <div class="products-title">SẢN PHẨM</div>
            <input id="productsSearch" class="search-input" type="search" placeholder="Tìm sản phẩm..." autocomplete="off" />
            <button id="cartChip" class="cart-chip" type="button" onclick="toggleCart()" aria-label="Giỏ hàng">
                🛒 <span id="cartCount">0</span>
            </button>
        </div>

        <div class="filters" id="productsCategories"></div>
        <div class="products-meta">
            <div id="productsCount">0 sản phẩm</div>
            <div id="productsActiveCategory">Tất cả</div>
        </div>

        <div class="products-grid" id="productsList"></div>
    </div>

    <div class="mobile-toast" id="mobileToast" aria-live="polite">
        <span class="mobile-toast-icon">✓</span>
        <span class="mobile-toast-text" id="mobileToastText">Đã thêm vào giỏ hàng</span>
    </div>

    <!-- Cart Modal (same behavior as home) -->
    <div class="cart-modal-overlay" id="cartOverlay"></div>
    <div class="cart-modal" id="cartModal" aria-hidden="true">
        <div class="cart-modal-header">
            <h3>🛒 Giỏ hàng</h3>
            <button type="button" class="cart-modal-close" onclick="closeCartModal()" aria-label="Đóng">×</button>
        </div>
        <div class="cart-modal-body">
            <div class="cart-modal-items" id="cartItems"></div>
        </div>
        <div class="cart-modal-footer">
            <div class="cart-total">
                <span>Tổng</span>
                <span class="total-amount" id="cartTotalAmount">₫0</span>
            </div>
            <button type="button" class="btn btn-primary" style="width:100%; border-radius: 14px;" onclick="goToCheckout()">Thanh toán</button>
        </div>
    </div>

    <script src="/js/products-page.js?v={{ time() }}"></script>
</body>
</html>
