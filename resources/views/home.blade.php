<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🔥 ShopPro VIP - Siêu Thị Online Đẳng Cấp</title>
    <meta name="description" content="Website bán hàng online VIP PRO với hiệu ứng bóc lửa, giao diện đỉnh cao">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/mobile-optimization.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #7851A9;
            --secondary: #7851A9;
            --accent: #ffffff;
            --dark: #2d1b47;
            --light: #ffffff;
            --gold: #7851A9;
            --royal-blue: #7851A9;
            --pink: #ffffff;
            --text-dark: #2d1b47;
            --bg-light: #f5f3f8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Scroll reveal (smooth from bottom) */
        .reveal {
            opacity: 1;
            transform: none;
        }

        .js .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 600ms cubic-bezier(0.2, 0.8, 0.2, 1), transform 600ms cubic-bezier(0.2, 0.8, 0.2, 1);
            transition-delay: var(--reveal-delay, 0ms);
            will-change: opacity, transform;
        }

        .js .reveal.is-visible {
            opacity: 1;
            transform: none;
        }

        @media (prefers-reduced-motion: reduce) {
            .js .reveal {
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }

        /* Notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            z-index: 10001;
            animation: slideInRight 0.5s ease-out;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            user-select: none;
            transition: transform 0.2s ease;
        }

        .notification:hover {
            transform: scale(1.02);
        }

        .notification.success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .notification.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        /* Animated Background */

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            25% { background-position: 50% 100%; }
            50% { background-position: 100% 50%; }
            75% { background-position: 50% 0%; }
            100% { background-position: 0% 50%; }
        }

        /* Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #7851A9;
            border-radius: 50%;
            animation: float 20s linear infinite;
            box-shadow: none;
            pointer-events: none;
            will-change: transform, opacity;
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 0.8; }
            50% { opacity: 1; }
            90% { opacity: 0.8; }
            100% { transform: translateY(-120vh) translateX(50px); opacity: 0; }
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(120, 81, 169, 0.3);
            padding: 1rem 0;
            box-shadow: none;
        }

        .nav {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #7851A9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: none;
            animation: glow 2s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% { filter: none; }
            50% { filter: none; }
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            position: relative;
            transition: all 0.3s;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #7851A9);
            transition: width 0.3s;
        }

        .nav-links a:hover::before {
            width: 100%;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .user-menu {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .user-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(120, 81, 169, 0.4);
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 15px;
            padding: 0.5rem 0;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown a, .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--dark);
            text-decoration: none;
            transition: background 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .user-dropdown a:hover, .logout-btn:hover {
            background: rgba(120, 81, 169, 0.05);
        }

        .dropdown-divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.1);
            margin: 0.5rem 0;
        }

        .logout-btn {
            color: var(--error);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.05);
        }

        .btn-secondary {
            background: rgba(120, 81, 169, 0.1);
            color: var(--primary);
            border: 2px solid rgba(120, 81, 169, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(120, 81, 169, 0.15);
            border-color: var(--primary);
        }

        .btn {
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #7851A9);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(120, 81, 169, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(120, 81, 169, 0.3);
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 30px;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            transform-origin: center;
            will-change: transform;
            transition: all 0.1s ease;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            max-width: 900px;
            padding: 2rem;
        }

        .hero-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #7c48bc);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(2px 3px 6px rgba(255, 255, 255, 0.15));
            text-shadow: 5px 5px 5px rgba(255, 255, 255, 0.19);
            animation: gradientText 5s ease infinite;
        }

        @keyframes gradientText {
            0% { background-position: 0% 50%; }
            25% { background-position: 50% 100%; }
            50% { background-position: 100% 50%; }
            75% { background-position: 50% 0%; }
            100% { background-position: 0% 50%; }
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: rgba(45, 52, 54, 0.85);
            font-weight: 500;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 1.2rem 3rem;
            font-size: 1.1rem;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #7851A9);
            color: #ffffff;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(120, 81, 169, 0.3);
        }

        .btn-hero-primary:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 8px 20px rgba(120, 81, 169, 0.4);
        }

        .btn-hero-secondary {
            background: white;
            color: #7851A9;
            border: 2px solid #7851A9;
            font-weight: 800;
            box-shadow: 0 2px 8px rgba(120, 81, 169, 0.15);
        }

        .btn-hero-secondary:hover {
            background: linear-gradient(135deg, #ac68ff, #b66dff);
            color: white;
            border-color: #7851A9;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 50px rgba(120, 81, 169, 0.5);
        }

        /* Floating 3D Cards */
        .floating-cards {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .floating-card {
            position: absolute;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(120, 81, 169, 0.2), rgba(181, 163, 208, 0.2));
            border: 2px solid rgba(120, 81, 169, 0.3);
            border-radius: 15px;
            animation: floatCard 8s ease-in-out infinite;
            backdrop-filter: blur(10px);
            box-shadow: none;
            will-change: transform, opacity;
        }

        @keyframes floatCard {
            0%, 100% { 
                transform: translateY(0) rotate(0deg) scale(1); 
                opacity: 0.7;
            }
            25% { 
                transform: translateY(-30px) rotate(5deg) scale(1.05); 
                opacity: 0.9;
            }
            50% { 
                transform: translateY(-60px) rotate(-5deg) scale(1.1); 
                opacity: 1;
            }
            75% { 
                transform: translateY(-30px) rotate(3deg) scale(1.05); 
                opacity: 0.9;
            }
        }

        /* Products Section */
        .products {
            padding: 5rem 2rem;
            position: relative;
            z-index: 10;
        }

        .section-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 3rem;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, #7c48bc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(2px 3px 6px rgba(255, 255, 255, 0.25));
            text-shadow: 2px 3px 8px rgba(255, 255, 255, 0.4);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .product-card {
            background: white;
            border: 2px solid rgba(120, 81, 169, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .product-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(120, 81, 169, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s;
            pointer-events: none;
        }

        .product-card:hover::before {
            left: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #7851A9;
            box-shadow: 0 8px 16px rgba(120, 81, 169, 0.15);
        }

        .product-image {
            width: 100% !important;
            height: 250px !important;
            border-radius: 15px !important;
            margin-bottom: 1rem !important;
            display: block !important;
            border: 2px solid #eee !important;
            background: #f9f9f9 !important;
            overflow: hidden !important;
        }

        .product-image-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }

        .product-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .product-price {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #7851A9, #a583c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .btn-add-cart {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #7851A9, #a583c7);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-add-cart:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(120, 81, 169, 0.3);
        }

        /* Categories */
        .categories {
            position: relative;
            z-index: 10;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .category-card {
            background: white;
            border: 2px solid rgba(120, 81, 169, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
.d-desktop-only {
    display: none;
}

@media (min-width: 992px) {
    .d-desktop-only {
        display: block;
    }
}

        .category-card:hover {
            transform: translateY(-10px);
            background: linear-gradient(135deg, rgba(120, 81, 169, 0.1), rgba(181, 163, 208, 0.1));
            border-color: #7851A9;
            box-shadow: 0 8px 16px rgba(120, 81, 169, 0.15);
        }

        .category-card.active {
            background: linear-gradient(135deg, #7851A9, #a583c7);
            color: white;
            border-color: #7851A9;
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(120, 81, 169, 0.4);
        }

        .category-card.active .category-name {
            color: white;
            font-weight: 800;
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .category-name {
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* Features */
        /* Mặc định: ẩn (mobile) */
        .features {
            padding: 5rem 2rem;
            position: relative;
            z-index: 10;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            border: 2px solid rgba(65, 105, 225, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: #4169E1;
            box-shadow: 0 20px 60px rgba(65, 105, 225, 0.3);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* Footer */
        .footer {
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #2d1b47, #4a3066);
            border-top: 3px solid #7851A9;
            text-align: center;
            color: white;
        }

        /* ========== RESPONSIVE VIP PRO ========== */
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
        }

        .mobile-menu-toggle span {
            width: 28px;
            height: 3px;
            background: var(--text-dark);
            border-radius: 2px;
            transition: all 0.3s;
        }

        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Mobile Navigation Overlay */
        .mobile-nav-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .mobile-nav-overlay.active {
            opacity: 1;
        }

        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 350px;
            height: 100%;
            background: white;
            z-index: 1000;
            padding: 2rem;
            box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
            transition: right 0.3s;
            overflow-y: auto;
        }

        .mobile-nav.active {
            right: 0;
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .mobile-nav-close {
            background: rgba(255, 215, 0, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .mobile-nav-close:active {
            transform: scale(0.95);
            background: rgba(255, 215, 0, 0.4);
        }

        .mobile-nav-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-nav-links a {
            display: block;
            padding: 1rem;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .mobile-nav-links a:active {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 105, 180, 0.2));
            transform: scale(0.98);
        }

        /* Tablet (768px - 1024px) */
        @media (max-width: 1024px) {
            .nav-links {
                gap: 1.5rem;
            }

            .nav-links a {
                font-size: 0.9rem;
            }

            .hero-title {
                font-size: 4rem;
            }

            .hero-subtitle {
                font-size: 1.3rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .categories-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }

            .chatbox-container {
                width: 350px;
                height: 500px;
                right: 20px;
                bottom: 90px;
            }
        }

        /* Mobile (max-width: 768px) */
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }

            /* Product image sizing on mobile */
            .product-image {
                height: 140px !important;
                border-radius: 12px !important;
                margin-bottom: 8px !important;
            }

            .mobile-nav-overlay,
            .mobile-nav {
                display: block;
            }

            .nav-links {
                display: none;
            }

            .nav-buttons {
                gap: 0.5rem;
            }

            .btn-primary {
                padding: 0.6rem 1.5rem;
                font-size: 0.85rem;
            }

            .cart-icon {
                font-size: 1.2rem;
            }


            .hero-title {
                font-size: 2.8rem;
                line-height: 1.2;
            }

            .hero-subtitle {
                font-size: 1.1rem;
                margin-bottom: 1.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn-hero {
                width: 100%;
                padding: 1rem 2rem;
            }

            .floating-cards {
                opacity: 0.5;
            }

            .section-title {
                font-size: 2.2rem;
                margin-bottom: 2rem;
            }

            .products,
            .categories,
            .features {
                padding: 3rem 1rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 0 1rem;
            }

            .product-card {
                max-width: 100%;
            }

            .categories-grid {
                display: flex;
                overflow-x: auto;
                gap: 10px;
                padding: 0 12px 12px;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
            }

            .categories-grid::-webkit-scrollbar {
                display: none;
            }

            .category-card {
                min-width: 110px;
                max-width: 110px;
                flex-shrink: 0;
                scroll-snap-align: start;
                padding: 12px 10px;
                border-radius: 16px;
            }

            .category-icon {
                font-size: 2rem;
            }

            .category-name {
                font-size: 0.8rem;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                padding: 0 12px;
            }

            .feature-card {
                padding: 14px;
                border-radius: 16px;
            }

            .feature-icon {
                font-size: 1.8rem;
                margin-bottom: 8px;
            }

            .feature-title {
                font-size: 0.95rem;
                margin-bottom: 4px;
            }

            .feature-card p {
                font-size: 0.75rem;
                margin: 0;
            }

            .chatbox-container {
                width: calc(100% - 30px);
                height: 70vh;
                max-height: 550px;
                right: 15px;
                bottom: 80px;
                border-radius: 15px;
            }

            .chatbox-toggle {
                width: 55px;
                height: 55px;
                bottom: calc(var(--mobile-nav-height) + 20px);
                right: 15px;
            }

            .chatbox-badge {
                width: 22px;
                height: 22px;
                font-size: 0.7rem;
            }

            .footer {
                padding: 2rem 1rem;
            }
        }

        /* Small Mobile (max-width: 480px) */
        @media (max-width: 480px) {
            .logo {
                font-size: 0.8rem !important;
            }

            .product-image {
                height: 130px !important;
            }

            .nav {
                padding: 0 1rem;
            }

            .btn-primary {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .hero-title {
                font-size: 1.6rem !important;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .btn-hero {
                padding: 0.9rem 1.5rem;
                font-size: 0.95rem;
            }

            .section-title {
                font-size: 1.55rem;
            }

            .products-grid {
                padding: 0 !important;
            }

            .product-card {
                padding: 1rem;
            }

            .product-title {
                font-size: 1.1rem;
            }

            .product-price {
                font-size: 1.3rem;
            }

            .categories-grid {
                display: flex;
                overflow-x: auto;
                gap: 8px;
                padding: 0 10px 10px;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
            }

            .categories-grid::-webkit-scrollbar {
                display: none;
            }

            .category-card {
                min-width: 90px !important;
                max-width: 107px !important;
                padding: 10px 0px !important;
            }

            .category-name {
                font-size: 0.75rem;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
                padding: 0 10px;
            }

            .feature-card {
                padding: 12px;
                border-radius: 14px;
            }

            .feature-icon {
                font-size: 1.6rem;
                margin-bottom: 6px;
            }

            .feature-title {
                font-size: 0.9rem;
            }

            .feature-card p {
                font-size: 0.72rem;
            }

            .chatbox-container {
                width: calc(100% - 20px);
                right: 10px;
                bottom: 70px;
                height: 65vh;
            }

            .chatbox-header {
                padding: 1rem;
            }

            .chatbox-title {
                font-size: 0.95rem;
            }

            .chatbox-input-wrapper {
                padding: 0.8rem 1rem;
            }

            .chatbox-toggle {
                width: 50px;
                height: 50px;
                bottom: calc(var(--mobile-nav-height) + 16px);
                right: 10px;
            }
        }

        /* Large Screens (min-width: 1440px) */
        @media (min-width: 1440px) {
            .nav,
            .hero-content,
            .products-grid,
            .categories-grid,
            .features-grid {
                max-width: 1600px;
                margin: 0 auto;
            }

            .hero-title {
                font-size: 6rem;
            }

            .section-title {
                font-size: 3.5rem;
            }
        }

        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn,
            .btn-hero,
            .btn-add-cart,
            .category-card,
            .feature-card,
            .product-card {
                -webkit-tap-highlight-color: transparent;
            }

            .btn:active,
            .btn-hero:active,
            .btn-add-cart:active {
                transform: scale(0.97);
            }

            .product-card:active {
                transform: scale(0.98);
            }
        }

        /* Landscape Mobile */
        @media (max-width: 900px) and (orientation: landscape) {
            .hero {
                min-height: 100vh;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .chatbox-container {
                height: 85vh;
            }
        }

        /* Animation Performance for Mobile */
        @media (prefers-reduced-motion: reduce) {
            /* Không disable animations, chỉ giảm intensity */
            .particle {
                animation-duration: 30s !important;
            }
            
            .floating-card {
                animation-duration: 12s !important;
            }
        }

        /* ========== PRODUCT MANAGEMENT MODAL ========== */
        .product-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: var(--primary);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: #ccc;
            padding: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .modal-close:hover {
            color: var(--primary);
        }

        .modal-content form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(120, 81, 169, 0.1);
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 2rem;
            border-top: 2px solid #f0f0f0;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .modal-btn-save {
            background: linear-gradient(135deg, #7851A9, #a583c7);
            color: white;
        }

        .modal-btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(120, 81, 169, 0.4);
        }

        .modal-btn-cancel {
            background: #f0f0f0;
            color: var(--text-dark);
        }

        .modal-btn-cancel:hover {
            background: #e0e0e0;
        }

        /* Admin Add Button */
        .btn-add-product {
            background: linear-gradient(135deg, #7851A9, #a583c7);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(120, 81, 169, 0.4);
        }

        .btn-edit-small,
        .btn-delete-small {
            padding: 0.5rem;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-edit-small {
            background: #e3f2fd;
            color: #1976d2;
        }

        .btn-edit-small:hover {
            background: #1976d2;
            color: white;
        }

        .btn-delete-small {
            background: #ffebee;
            color: #d32f2f;
        }

        .btn-delete-small:hover {
            background: #d32f2f;
            color: 
            white;
        }
        .logo {
    text-decoration: none;
}

    </style>
</head>
<body>
    <!-- Notifications -->
    @if(session('success'))
    <div class="notification success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="notification error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    <div class="animated-bg"></div>
    <div class="particles" id="particles"></div>

    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <a href="/" class="logo text-decoration-none">⚡ SHOPPRO VIP</a>
            <ul class="nav-links">
                <li><a href="#home">TRANG CHỦ</a></li>
                <li><a href="/products">SẢN PHẨM</a></li>
                <li><a href="#categories">DANH MỤC</a></li>
                <li><a href="#features">ƯU ĐÃI</a></li>
                <li><a href="#contact">LIÊN HỆ</a></li>
            </ul>
            <div class="nav-buttons">
                <div class="cart-icon" onclick="toggleCart()">
                    🛒
                    <span class="cart-count" id="cartCount">0</span>
                </div>
                @auth
                    <div class="user-menu">
                        <button class="btn btn-primary user-btn" id="userMenuBtn">
                            <i class="fas fa-user"></i>
                            {{ Auth::user()->name }}
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            <a href="/profile"><i class="fas fa-user"></i> Tài khoản</a>
                            <a href="/orders"><i class="fas fa-shopping-bag"></i> Đơn hàng</a>
                            @if(Auth::user()->role === 'admin')
                                <a href="/admin"><i class="fas fa-cog"></i> Quản trị</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form action="/logout" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        ĐĂNG NHẬP
                    </a>
                    <a href="/register" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i>
                        ĐĂNG KÝ
                    </a>
                @endauth
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-header">
            <div class="logo">⚡ SHOPPRO</div>
            <button class="mobile-nav-close" id="mobileNavClose">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="#home" class="mobile-nav-link">🏠 TRANG CHỦ</a></li>
            <li><a href="#products" class="mobile-nav-link">🛍️ SẢN PHẨM</a></li>
            <li><a href="#categories" class="mobile-nav-link">📂 DANH MỤC</a></li>
            <li><a href="#features" class="mobile-nav-link">🎁 ƯU ĐÃI</a></li>
            <li><a href="#contact" class="mobile-nav-link">📞 LIÊN HỆ</a></li>
        </ul>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="floating-cards">
            <div class="floating-card" style="top: 10%; left: 10%; animation-delay: 0s;"></div>
            <div class="floating-card" style="top: 20%; right: 10%; animation-delay: 2s;"></div>
            <div class="floating-card" style="bottom: 30%; left: 15%; animation-delay: 4s;"></div>
            <div class="floating-card" style="bottom: 20%; right: 20%; animation-delay: 6s;"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title">✨ Website bán hàng ✨</h1>
            <p class="hero-subtitle">✨ Trải nghiệm mua sắm đỉnh cao với công nghệ tương lai ✨</p>
            <div class="hero-buttons">
                <button class="btn-hero btn-hero-primary" onclick="scrollToSection('products')">
                    🚀 MUA NGAY
                </button>
                <button class="btn-hero btn-hero-secondary" onclick="scrollToSection('categories')">
                    💎 KHÁM PHÁ
                </button>
            </div>
        </div>
    </section>
    <!-- Categories Section -->
    <section class="categories" id="categories">
        <div style="text-align: center; margin-bottom: 2rem; position: relative;">
            <h2 class="section-title"> DANH MỤC ĐỈNH CAO </h2>
            <button class="btn-add-product" onclick="window.location.href='/admin#categories'" style="display: none; position: absolute; top: 0; right: 0;" id="adminCategoryBtn">
                ➕ Quản Lý Danh Mục
            </button>
        </div>
        <div class="categories-grid" id="categoriesGrid">
            <!-- Categories will be generated by JavaScript -->
        </div>
    </section>

  
    <!-- Products Section -->
    <section class="products" id="products">
        <div style="text-align: center; margin-bottom: 2rem; position: relative;">
            <h2 class="section-title"> SẢN PHẨM HOT NHẤT </h2>
            <button class="btn-add-product" onclick="showAddProductModal()" style="display: none; position: absolute; top: 0; right: 0;" id="adminAddBtn">
                ➕ Thêm Sản Phẩm
            </button>
        </div>
        <div class="products-grid" id="productsGrid" data-products-container="hot">
            <!-- Products will be generated by JavaScript -->
        </div>
    </section>



    <!-- ========== MOBILE COMPONENTS ========== -->
    <!-- Mobile Bottom Navigation Bar -->
    <nav class="mobile-bottom-nav" id="mobileBottomNav">
        <div class="mobile-bottom-nav-inner">
            <a href="#home" class="mobile-nav-item active" data-section="home">
                <div class="mobile-nav-icon">🏠</div>
                <span class="mobile-nav-label">Trang chủ</span>
            </a>
            <a href="#categories" class="mobile-nav-item" data-section="categories">
                <div class="mobile-nav-icon">📂</div>
                <span class="mobile-nav-label">Danh mục</span>
            </a>
            <div class="mobile-nav-fab">
                <button type="button" class="mobile-nav-fab-btn" onclick="toggleCart()" id="mobileCartFab" aria-label="Mở giỏ hàng">
                    🛒
                    <span class="mobile-nav-badge" id="mobileCartBadge" style="display: none;">0</span>
                </button>
            </div>
            <a href="/products" class="mobile-nav-item">
                <div class="mobile-nav-icon">🎁</div>
                <span class="mobile-nav-label">Sản phẩm</span>
            </a>
            @auth
            <a href="/profile" class="mobile-nav-item">
                <div class="mobile-nav-icon">👤</div>
                <span class="mobile-nav-label">Tài khoản</span>
            </a>
            @else
            <a href="/login" class="mobile-nav-item">
                <div class="mobile-nav-icon">🔐</div>
                <span class="mobile-nav-label">Đăng nhập</span>
            </a>
            @endauth
        </div>
    </nav>

    <!-- Mobile Toast Notification -->
    <div class="mobile-toast" id="mobileToast">
        <span class="mobile-toast-icon">✓</span>
        <span class="mobile-toast-text" id="mobileToastText">Thêm vào giỏ hàng thành công!</span>
    </div>

    <!-- Chatbox VIP -->
    <div class="chatbox-container" id="chatboxContainer">
        <div class="chatbox-header">
            <div class="chatbox-avatar">🤖</div>
            <div class="chatbox-info">
                <div class="chatbox-title">AI Trợ Lý VIP</div>
                <div class="chatbox-status">⚡ Đang online</div>
            </div>
            <button class="chatbox-minimize" onclick="toggleChatbox()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>
        </div>
        <div class="chatbox-messages" id="chatboxMessages">
            <div class="chat-message ai-message">
                <div class="message-avatar">🤖</div>
                <div class="message-bubble">
                    Xin chào! 👋 Tôi là AI trợ lý của ShopPro. Tôi có thể giúp gì cho bạn?
                </div>
            </div>
        </div>
        <div class="chatbox-input-wrapper">
            <input type="text" class="chatbox-input" id="chatboxInput" placeholder="Nhập tin nhắn..." />
            <button class="chatbox-send" id="chatboxSend">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </div>
    </div>

    <!-- Chatbox Toggle Button -->
    <button class="chatbox-toggle" onclick="toggleChatbox()" id="chatboxToggle">
        💬
    </button>

    <!-- Product Management Modal -->
    <div id="addProductModal" class="product-modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Thêm Sản Phẩm Mới</h2>
                <button class="modal-close" onclick="closeProductModal()">✕</button>
            </div>
            <form id="productForm" onsubmit="saveProduct(event)">
                <div class="form-group">
                    <label>Tên Sản Phẩm *</label>
                    <input type="text" id="productName" required placeholder="Nhập tên sản phẩm">
                </div>

                <div class="form-group">
                    <label>Danh Mục *</label>
                    <select id="productCategory" required>
                        <option value="">-- Chọn danh mục --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Giá (đồng) *</label>
                    <input type="number" id="productPrice" required placeholder="0" step="0.01">
                </div>

                <div class="form-group">
                    <label>Mô Tả *</label>
                    <textarea id="productDescription" required placeholder="Nhập mô tả sản phẩm" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Mô Tả Chi Tiết</label>
                    <textarea id="productDetailDescription" placeholder="Nhập mô tả chi tiết... (có thể xuống dòng)" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Thông Số Kỹ Thuật</label>
                    <textarea id="productSpecs" placeholder="Mỗi dòng 1 thông số. VD:&#10;Thương hiệu: Apple&#10;Xuất xứ: Việt Nam" rows="4"></textarea>
                    <div style="display: flex; gap: 8px; margin-top: 8px;">
                        <select id="productSpecsTemplate" style="flex: 1; padding: 10px; border: 2px solid #ddd; border-radius: 8px;">
                            <option value="auto">Tự chọn theo danh mục</option>
                            <option value="electronics">Điện tử</option>
                            <option value="fashion">Thời trang</option>
                            <option value="home">Gia dụng</option>
                            <option value="books">Sách</option>
                            <option value="custom">Tự do (không mẫu)</option>
                        </select>
                        <button type="button" class="modal-btn modal-btn-cancel" onclick="applySpecsTemplate()">Áp dụng mẫu</button>
                    </div>
                    <small style="color: #666; display: block; margin-top: 6px;">Chọn mẫu để gợi ý thông số theo danh mục, bạn có thể sửa tự do.</small>
                </div>

                <div class="form-group">
                    <label>Ảnh (URL)</label>
                    <input type="text" id="productImage" placeholder="https://example.com/image.jpg">
                </div>

                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeProductModal()">Hủy</button>
                    <button type="submit" class="modal-btn modal-btn-save">Lưu Sản Phẩm</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Chatbox Toggle Button -->
    <button class="chatbox-toggle" id="chatboxToggle" onclick="toggleChatbox()">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span class="chatbox-badge">1</span>
    </button>

    <!-- Cart Modal -->
    <div id="cartModal" class="cart-modal">
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h2 class="cart-modal-title">🛒 Giỏ Hàng Của Bạn</h2>
                <button class="cart-modal-close" onclick="closeCartModal()">×</button>
            </div>

            <div class="cart-modal-body" id="cartModalBody">
                <!-- Cart items will be rendered here -->
            </div>

            <div class="cart-modal-footer" id="cartModalFooter">
                <div class="cart-summary-row">
                    <span>Tạm tính:</span>
                    <span id="cartSubtotal">₫0</span>
                </div>
                <div class="cart-summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div class="cart-summary-row total">
                    <span>Tổng cộng:</span>
                    <span id="cartTotal">₫0</span>
                </div>
                <div class="cart-actions">
                    <button class="cart-btn cart-btn-checkout" onclick="goToCheckout()">
                        Thanh Toán
                    </button>
                    <button class="cart-btn cart-btn-clear" onclick="confirmClearCart()">
                        Xóa Tất Cả
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Chatbox Styles */
        .chatbox-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 380px;
            height: 550px;
            background: white;
            border: 2px solid #7851A9;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(120, 81, 169, 0.2);
            display: flex;
            flex-direction: column;
            z-index: 9999;
            transform: translateY(calc(100% + 100px));
            transition: transform 0.3s ease;
        }

        .chatbox-container.active {
            transform: translateY(0);
        }

        .chatbox-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #7851A9, #a583c7);
            border-radius: 17px 17px 0 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #ffffff;
        }

        .chatbox-avatar {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .chatbox-info {
            flex: 1;
        }

        .chatbox-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
        }

        .chatbox-status {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .chatbox-minimize {
            background: rgba(45, 52, 54, 0.2);
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--text-dark);
        }

        .chatbox-minimize:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .chatbox-messages {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .chatbox-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chatbox-messages::-webkit-scrollbar-track {
            background: rgba(255, 215, 0, 0.05);
        }

        .chatbox-messages::-webkit-scrollbar-thumb {
            background: #FFD700;
            border-radius: 3px;
        }

        .chat-message {
            display: flex;
            gap: 0.8rem;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateY(30px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        .user-message {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #FFD700, #FF1493);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-message .message-avatar {
            background: linear-gradient(135deg, #4169E1, #6495ED);
        }

        .message-bubble {
            background: rgba(248, 249, 255, 0.8);
            border: 1px solid rgba(255, 215, 0, 0.2);
            padding: 1rem 1.2rem;
            border-radius: 15px;
            max-width: 70%;
            word-wrap: break-word;
            line-height: 1.5;
            color: var(--text-dark);
        }

        .user-message .message-bubble {
            background: linear-gradient(135deg, #7851A9, #a583c7);
            color: #ffffff;
            border: none;
            font-weight: 500;
        }

        .typing-indicator {
            display: flex;
            gap: 0.3rem;
            padding: 0.5rem;
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            background: #7851A9;
            border-radius: 50%;
            animation: bounce 1.4s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }

        .chatbox-input-wrapper {
            padding: 1rem 1.5rem;
            background: rgba(248, 249, 255, 0.8);
            display: flex;
            gap: 0.8rem;
            border-radius: 0 0 17px 17px;
            border-top: 1px solid rgba(255, 215, 0, 0.2);
        }

        .chatbox-input {
            flex: 1;
            background: white;
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 25px;
            padding: 0.8rem 1.2rem;
            color: var(--text-dark);
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s;
        }

        .chatbox-input:focus {
            border-color: #7851A9;
            box-shadow: none;
        }

        .chatbox-input::placeholder {
            color: rgba(45, 52, 54, 0.5);
        }

        .chatbox-send {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #7851A9, #a583c7);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: #ffffff;
        }

        .chatbox-send:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 2px 8px rgba(120, 81, 169, 0.3);
        }

        .chatbox-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #7851A9, #a583c7);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 40px rgba(120, 81, 169, 0.5);
            z-index: 9998;
            transition: all 0.3s;
            animation: pulse 2s infinite;
            color: #ffffff;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 4px 12px rgba(120, 81, 169, 0.3); }
            50% { box-shadow: 0 6px 16px rgba(120, 81, 169, 0.4); }
        }

        .chatbox-toggle:hover {
            transform: scale(1.1);
        }

        .chatbox-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #7851A9;
            color: #ffffff;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            border: 3px solid white;
            box-shadow: 0 1px 4px rgba(120, 81, 169, 0.2);
        }

        @media (max-width: 768px) {
            .chatbox-container {
                width: 90%;
                right: 5%;
                height: 70vh;
            }
            
            .chatbox-toggle {
                bottom: calc(var(--mobile-nav-height) + 20px);
                right: 16px;
                width: 55px;
                height: 55px;
            }
        }

        /* ========== CART MODAL STYLES ========== */
        .cart-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            backdrop-filter: blur(5px);
        }

        .cart-modal.active,
        .cart-modal.show {
            display: flex !important;
        }

        .cart-modal-content {
            background: white;
            border-radius: 20px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px) scale(0.9);
                opacity: 0;
            }
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .cart-modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 2px solid var(--bg-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cart-modal-close {
            background: #e0e0e0;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            color: var(--dark);
        }

        .cart-modal-close:hover {
            background: #d0d0d0;
            transform: rotate(90deg);
        }

        .cart-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 2rem;
        }

        .cart-empty {
            text-align: center;
            padding: 3rem 2rem;
        }

        .cart-empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .cart-empty-text {
            color: #666;
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        .cart-item {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid var(--bg-light);
            align-items: flex-start;
            transition: all 0.3s;
        }

        .cart-item:hover {
            background: var(--bg-light);
            border-radius: 10px;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }

        .cart-item-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.125rem;
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-end;
        }

        .cart-item-total {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.125rem;
            min-width: 100px;
            text-align: right;
        }

        .cart-item-controls {
            display: flex;
            flex-direction: row;
            gap: 0.5rem;
            align-items: center;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--bg-light);
            border-radius: 25px;
            padding: 0.25rem;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            border: none;
            background: white;
            border-radius: 50%;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            color: var(--primary);
            padding: 0;
        }

        .quantity-btn i {
            font-size: 0.75rem;
        }

        .quantity-btn:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .quantity-btn:active {
            transform: scale(0.95);
        }

        .quantity-display {
            min-width: 35px;
            text-align: center;
            font-weight: 600;
            color: var(--dark);
            font-size: 1rem;
        }

        .cart-item-remove {
            background: #ff4444;
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 28px;
            width: auto;
            min-width: 28px;
        }

        .cart-item-remove i {
            font-size: 0.75rem;
        }

        .cart-item-remove:hover {
            background: #cc0000;
            transform: translateY(-2px);
        }

        .cart-modal-footer {
            padding: 1.5rem 2rem;
            border-top: 2px solid var(--bg-light);
            background: var(--bg-light);
            border-radius: 20px;
        }

        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .cart-summary-row.total {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-top: 0.5rem;
            padding-top: 0.75rem;
            border-top: 2px solid #ddd;
        }

        .cart-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .cart-btn {
            flex: 1;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .cart-btn-checkout {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .cart-btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(120, 81, 169, 0.3);
        }

        .cart-btn-clear {
            background: #e0e0e0;
            color: var(--dark);
        }

        .cart-btn-clear:hover {
            background: #ff4444;
            color: white;
        }

        /* Empty cart state */
        .cart-empty {
            text-align: center;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .cart-empty .empty-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .cart-empty p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .cart-modal-content {
                max-width: 95%;
                max-height: 95vh;
            }

            .cart-modal-header,
            .cart-modal-body,
            .cart-modal-footer {
                padding: 1rem 1.5rem;
            }

            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item-image {
                width: 100%;
                height: auto;
                max-height: 200px;
            }

            .cart-item-details {
                width: 100%;
            }

            .cart-item-actions {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .quantity-controls {
                order: 1;
            }

            .cart-item-total {
                order: 2;
                text-align: right;
            }

            .cart-item-remove {
                order: 3;
            }

            .cart-actions {
                flex-direction: column;
            }
        }
    </style>

    <script>
        document.documentElement.classList.add('js');

        // Scroll reveal (from bottom, smooth)
        (function initScrollReveal() {
            let revealObserver = null;
            const observed = new WeakSet();

            function ensureObserver() {
                if (revealObserver || !('IntersectionObserver' in window)) return;
                revealObserver = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    });
                }, { threshold: 0.12, rootMargin: '0px 0px -10% 0px' });
            }

            function applyDefaultRevealTargets() {
                const selector = [
                    '.hero-content',
                    '.hero-title',
                    '.hero-subtitle',
                    '.hero-buttons',
                    '.section-title',
                    '.category-card',
                    '.product-card',
                    '.feature-card'
                ].join(',');

                document.querySelectorAll(selector).forEach((el) => {
                    if (!el.classList.contains('reveal')) el.classList.add('reveal');
                });
            }

            window.refreshScrollReveal = function refreshScrollReveal() {
                applyDefaultRevealTargets();

                if (!('IntersectionObserver' in window)) {
                    document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-visible'));
                    return;
                }

                ensureObserver();
                document.querySelectorAll('.reveal').forEach((el) => {
                    if (el.classList.contains('is-visible')) return;
                    if (observed.has(el)) return;
                    observed.add(el);
                    revealObserver.observe(el);
                });
            };

            document.addEventListener('DOMContentLoaded', () => {
                window.refreshScrollReveal?.();
            });
        })();

        // ============ MOBILE MENU ============
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileNav = document.getElementById('mobileNav');
        const mobileNavOverlay = document.getElementById('mobileNavOverlay');
        const mobileNavClose = document.getElementById('mobileNavClose');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

        function openMobileMenu() {
            mobileNav.classList.add('active');
            mobileNavOverlay.classList.add('active');
            mobileMenuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileNav.classList.remove('active');
            mobileNavOverlay.classList.remove('active');
            mobileMenuToggle.classList.remove('active');
            document.body.style.overflow = '';
        }

        mobileMenuToggle?.addEventListener('click', openMobileMenu);
        mobileNavClose?.addEventListener('click', closeMobileMenu);
        mobileNavOverlay?.addEventListener('click', closeMobileMenu);

        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                closeMobileMenu();
            });
        });

        // ============ USER DROPDOWN MENU ============
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });
        }

        // ============ CHATBOX AI FUNCTIONALITY ============
        let chatboxActive = false;
        const chatboxContainer = document.getElementById('chatboxContainer');
        const chatboxMessages = document.getElementById('chatboxMessages');
        const chatboxInput = document.getElementById('chatboxInput');
        const chatboxSend = document.getElementById('chatboxSend');
        const chatboxToggle = document.getElementById('chatboxToggle');

        function toggleChatbox() {
            chatboxActive = !chatboxActive;
            if (chatboxActive) {
                chatboxContainer.classList.add('active');
                chatboxToggle.style.transform = 'scale(0)';
                chatboxInput.focus();
            } else {
                chatboxContainer.classList.remove('active');
                chatboxToggle.style.transform = 'scale(1)';
            }
        }

        function sendMessage() {
            const message = chatboxInput.value.trim();
            if (!message) return;

            // Add user message
            addMessage(message, 'user');
            chatboxInput.value = '';

            // Show typing indicator
            const typingDiv = document.createElement('div');
            typingDiv.className = 'chat-message ai-message';
            typingDiv.innerHTML = `
                <div class="message-avatar">🤖</div>
                <div class="message-bubble typing-indicator">
                    <span></span><span></span><span></span>
                </div>
            `;
            chatboxMessages.appendChild(typingDiv);
            scrollToBottom();

            // Call API
            fetch('/api/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ message })
            })
            .then(response => response.json())
            .then(data => {
                typingDiv.remove();
                if (data.success && data.message) {
                    addMessage(data.message, 'ai');
                } else {
                    addMessage('Xin lỗi, tôi đang gặp sự cố. Vui lòng thử lại sau! 😊', 'ai');
                }
            })
            .catch(error => {
                console.error('Chat error:', error);
                typingDiv.remove();
                addMessage('Không thể kết nối đến AI. Vui lòng kiểm tra kết nối! 🔌', 'ai');
            });
        }

        function addMessage(text, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${type}-message`;
            
            const avatar = type === 'ai' ? '🤖' : '👤';
            
            messageDiv.innerHTML = `
                <div class="message-avatar">${avatar}</div>
                <div class="message-bubble">${text}</div>
            `;
            
            chatboxMessages.appendChild(messageDiv);
            scrollToBottom();
        }

        function scrollToBottom() {
            chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
        }

        // Event listeners
        chatboxSend.addEventListener('click', sendMessage);
        chatboxInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });

        // ============ ORIGINAL SCRIPTS ============
        // Create particles
        function createParticles() {
            const particles = document.getElementById('particles');
            if (!particles) return;
            
            // Clear existing particles first
            particles.innerHTML = '';
            
            const particleCount = window.innerWidth > 768 ? 50 : 20;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = (Math.random() * 100) + '%';
                particle.style.animationDelay = (Math.random() * 20) + 's';
                particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
                particle.style.opacity = (Math.random() * 0.5 + 0.3);
                particles.appendChild(particle);
            }
        }

        // Product data
        const products = [
            {
                id: 1,
                name: 'iPhone 15 Pro Max VIP',
                price: '29.990.000',
                image: 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=500',
                category: 'electronics'
            },
            {
                id: 2,
                name: 'MacBook Pro M3 Max',
                price: '89.990.000',
                image: 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500',
                category: 'electronics'
            },
            {
                id: 3,
                name: 'Nike Air Force 1 Limited',
                price: '2.990.000',
                image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',
                category: 'fashion'
            },
            {
                id: 4,
                name: 'Áo Khoác Hoodie Premium',
                price: '1.290.000',
                image: 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=500',
                category: 'fashion'
            },
            {
                id: 5,
                name: 'Nồi Chiên Không Dầu 5L',
                price: '1.790.000',
                image: 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500',
                category: 'home'
            },
            {
                id: 6,
                name: 'Máy Hút Bụi Robot',
                price: '8.990.000',
                image: 'https://images.unsplash.com/photo-1558317374-067fb5f30001?w=500',
                category: 'home'
            },
            {
                id: 7,
                name: 'Serum Dưỡng Da Luxury',
                price: '890.000',
                image: 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=500',
                category: 'beauty'
            },
            {
                id: 8,
                name: 'Bộ Mỹ Phẩm Cao Cấp',
                price: '2.490.000',
                image: 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500',
                category: 'beauty'
            }
        ];

        // ========== CART MANAGEMENT SYSTEM ==========
        let cart = [];

        // Load cart from localStorage when page loads
        function loadCart() {
            try {
                const savedCart = localStorage.getItem('cart');
                if (savedCart) {
                    cart = JSON.parse(savedCart);
                    console.log('Loaded cart from localStorage:', cart.length, 'items');
                    updateCartCount();
                } else {
                    cart = [];
                }
            } catch (error) {
                console.error('Error loading cart:', error);
                cart = [];
            }
        }

        // Save cart to localStorage
        function saveCart() {
            try {
                localStorage.setItem('cart', JSON.stringify(cart));
                console.log('Cart saved to localStorage:', cart.length, 'items');
            } catch (error) {
                console.error('Error saving cart:', error);
                showNotification('❌ Không thể lưu giỏ hàng!');
            }
        }

        // Add to cart with validation
        function addToCart(productId) {
            try {
                // Validate productId
                if (!productId) {
                    console.error('Invalid productId');
                    return;
                }

                const normalizedId = parseInt(productId, 10);
                if (Number.isNaN(normalizedId)) {
                    console.error('Invalid productId (not a number):', productId);
                    return;
                }

                console.log('addToCart called with productId:', normalizedId);
                console.log('allProducts available:', typeof allProducts !== 'undefined' ? allProducts.length : 'NOT DEFINED');
                console.log('products available:', typeof products !== 'undefined' ? products.length : 'NOT DEFINED');

                // Try to find from API data first, then fallback to hardcoded
                const product = (typeof allProducts !== 'undefined' && allProducts.find(p => Number(p.id) === normalizedId)) || 
                               products.find(p => Number(p.id) === normalizedId);
                
                if (!product) {
                    console.error('Product not found:', normalizedId);
                    showNotification('❌ Không tìm thấy sản phẩm!');
                    return;
                }

                console.log('Product found:', product.name);

                // Check if product already in cart
                const existingItemIndex = cart.findIndex(item => Number(item.id) === normalizedId);
                
                if (existingItemIndex > -1) {
                    // Increase quantity if already in cart
                    if (!cart[existingItemIndex].quantity) {
                        cart[existingItemIndex].quantity = 1;
                    }
                    cart[existingItemIndex].quantity += 1;
                    showNotification(`✅ Đã tăng số lượng ${product.name} lên ${cart[existingItemIndex].quantity}!`);
                } else {
                    // Add new item to cart
                    const cartItem = {
                        ...product,
                        quantity: 1,
                        addedAt: new Date().toISOString()
                    };
                    cart.push(cartItem);
                    showNotification(`✅ Đã thêm ${product.name} vào giỏ hàng!`);
                }

                console.log('Cart after adding:', cart);
                
                // Save and update
                saveCart();
                console.log('🔴 About to call updateCartCount()');
                console.log('🔴 Current cart:', cart);
                updateCartCount();
                console.log('🔴 After updateCartCount()');

            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('❌ Có lỗi khi thêm vào giỏ hàng!');
            }
        }

        // Update cart count
        function updateCartCount() {
            try {
                // Get the cart count element with multiple fallback methods
                let cartCountElement = document.getElementById('cartCount');
                
                if (!cartCountElement) {
                    console.warn('cartCount element not found via getElementById');
                    // Try alternative selector
                    cartCountElement = document.querySelector('.cart-count');
                    if (!cartCountElement) {
                        console.error('cartCount element not found via any method');
                        return;
                    }
                }
                
                // Calculate total quantity
                const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
                
                // Update the text content
                cartCountElement.textContent = totalItems;
                console.log('✅ Cart count updated to:', totalItems, 'Element:', cartCountElement);
                
                // Trigger animation - remove animation first then re-apply
                cartCountElement.style.animation = 'none';
                // Force browser to recalculate
                void cartCountElement.offsetWidth;
                // Apply animation
                cartCountElement.style.animation = 'pulseCart 0.5s ease';
                
            } catch (error) {
                console.error('❌ Error updating cart count:', error);
            }
        }

        // Remove from cart
        function removeFromCart(productId) {
            try {
                const index = cart.findIndex(item => item.id === productId);
                if (index > -1) {
                    const removedItem = cart.splice(index, 1)[0];
                    saveCart();
                    updateCartCount();
                    showNotification(`🗑️ Đã xóa ${removedItem.name} khỏi giỏ hàng!`);
                    return true;
                }
                return false;
            } catch (error) {
                console.error('Error removing from cart:', error);
                return false;
            }
        }

        // Clear entire cart
        function clearCart() {
            try {
                if (cart.length === 0) {
                    showNotification('⚠️ Giỏ hàng đã trống!');
                    return;
                }
                
                if (confirm(`Bạn có chắc muốn xóa tất cả ${cart.length} sản phẩm khỏi giỏ hàng?`)) {
                    cart = [];
                    saveCart();
                    updateCartCount();
                    showNotification('🗑️ Đã xóa toàn bộ giỏ hàng!');
                }
            } catch (error) {
                console.error('Error clearing cart:', error);
            }
        }

        // Update quantity
        function updateQuantity(productId, newQuantity) {
            try {
                const index = cart.findIndex(item => item.id === productId);
                if (index > -1) {
                    if (newQuantity <= 0) {
                        removeFromCart(productId);
                    } else {
                        cart[index].quantity = parseInt(newQuantity);
                        saveCart();
                        updateCartCount();
                    }
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
            }
        }

        // Get cart total
        function getCartTotal() {
            try {
                return cart.reduce((total, item) => {
                    const price = parseFloat(item.price) || 0;
                    const quantity = parseInt(item.quantity) || 1;
                    return total + (price * quantity);
                }, 0);
            } catch (error) {
                console.error('Error calculating cart total:', error);
                return 0;
            }
        }

        // Show notification
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: linear-gradient(135deg, #FFD700, #FFA500);
                color: var(--text-dark);
                padding: 1rem 2rem;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(255, 215, 0, 0.6);
                z-index: 10000;
                animation: slideIn 0.5s ease;
                font-weight: 600;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.5s ease';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

        // Scroll to section
        function scrollToSection(id) {
            document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
        }

        // ========== CART MODAL FUNCTIONS ==========
        
        // Open cart modal
        function openCartModal() {
            try {
                const modal = document.getElementById('cartModal');
                if (!modal) {
                    console.error('Cart modal not found');
                    return;
                }
                
                modal.style.display = 'flex';
                renderCartModal();
                
                // Add body scroll lock
                document.body.style.overflow = 'hidden';
            } catch (error) {
                console.error('Error opening cart modal:', error);
            }
        }

        // Close cart modal
        function closeCartModal() {
            try {
                const modal = document.getElementById('cartModal');
                if (modal) {
                    modal.style.display = 'none';
                    
                    // Remove body scroll lock
                    document.body.style.overflow = '';
                }
            } catch (error) {
                console.error('Error closing cart modal:', error);
            }
        }

        // Render cart modal content
        function renderCartModal() {
            try {
                const cartModalBody = document.getElementById('cartModalBody');
                const cartModalFooter = document.getElementById('cartModalFooter');
                const subtotalElement = document.getElementById('cartSubtotal');
                const totalElement = document.getElementById('cartTotal');
                
                if (!cartModalBody) {
                    console.error('Cart modal body not found');
                    return;
                }

                // Clear existing items
                cartModalBody.innerHTML = '';

                if (cart.length === 0) {
                    cartModalBody.innerHTML = `
                        <div class="cart-empty">
                            <div class="empty-icon">🛒</div>
                            <p>Giỏ hàng của bạn đang trống</p>
                            <button onclick="closeCartModal()" class="cart-btn cart-btn-checkout">
                                Tiếp tục mua sắm
                            </button>
                        </div>
                    `;
                    if (cartModalFooter) cartModalFooter.style.display = 'none';
                    if (subtotalElement) subtotalElement.textContent = '₫0';
                    if (totalElement) totalElement.textContent = '₫0';
                    return;
                }

                // Show footer when cart has items
                if (cartModalFooter) cartModalFooter.style.display = 'block';

                // Render each cart item
                cart.forEach(item => {
                    const quantity = item.quantity || 1;
                    const price = parseFloat(item.price) || 0;
                    const itemTotal = price * quantity;
                    
                    const cartItemDiv = document.createElement('div');
                    cartItemDiv.className = 'cart-item';
                    
                    // Get product image with proper fallback (main_image from DB, then image, then images, then placeholder)
                    const productImage = item.main_image || item.image || item.images || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80';
                    
                    cartItemDiv.innerHTML = `
                        <img src="${productImage}" alt="${item.name}" class="cart-item-image" onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80'">
                        <div class="cart-item-details">
                            <h4 class="cart-item-name">${item.name}</h4>
                            <p class="cart-item-price">₫${new Intl.NumberFormat('vi-VN').format(price)}</p>
                        </div>
                        <div class="cart-item-actions">
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="decreaseQuantity(${item.id})" title="Giảm số lượng">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="quantity-display">${quantity}</span>
                                <button class="quantity-btn" onclick="increaseQuantity(${item.id})" title="Tăng số lượng">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="cart-item-total">₫${new Intl.NumberFormat('vi-VN').format(itemTotal)}</div>
                            <button class="cart-item-remove" onclick="removeFromCartModal(${item.id})" title="Xóa sản phẩm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    `;
                    cartModalBody.appendChild(cartItemDiv);
                });

                // Update totals
                const total = getCartTotal();
                if (subtotalElement) {
                    subtotalElement.textContent = `₫${new Intl.NumberFormat('vi-VN').format(total)}`;
                }
                if (totalElement) {
                    totalElement.textContent = `₫${new Intl.NumberFormat('vi-VN').format(total)}`;
                }

            } catch (error) {
                console.error('Error rendering cart modal:', error);
            }
        }

        // Increase quantity
        function increaseQuantity(productId) {
            try {
                const index = cart.findIndex(item => item.id === productId);
                if (index > -1) {
                    cart[index].quantity = (cart[index].quantity || 1) + 1;
                    saveCart();
                    updateCartCount();
                    renderCartModal();
                }
            } catch (error) {
                console.error('Error increasing quantity:', error);
            }
        }

        // Decrease quantity
        function decreaseQuantity(productId) {
            try {
                const index = cart.findIndex(item => item.id === productId);
                if (index > -1) {
                    const currentQuantity = cart[index].quantity || 1;
                    if (currentQuantity > 1) {
                        cart[index].quantity = currentQuantity - 1;
                        saveCart();
                        updateCartCount();
                        renderCartModal();
                    } else {
                        // If quantity is 1, ask to remove
                        removeFromCartModal(productId);
                    }
                }
            } catch (error) {
                console.error('Error decreasing quantity:', error);
            }
        }

        // Remove from cart (modal version with re-render)
        function removeFromCartModal(productId) {
            try {
                const index = cart.findIndex(item => item.id === productId);
                if (index > -1) {
                    const removedItem = cart[index];
                    
                    // Confirm removal
                    if (confirm(`Bạn có chắc muốn xóa "${removedItem.name}" khỏi giỏ hàng?`)) {
                        cart.splice(index, 1);
                        saveCart();
                        updateCartCount();
                        renderCartModal();
                        showNotification(`🗑️ Đã xóa ${removedItem.name} khỏi giỏ hàng!`);
                    }
                }
            } catch (error) {
                console.error('Error removing from cart modal:', error);
            }
        }

        // Confirm and clear all cart
        function confirmClearCart() {
            try {
                if (cart.length === 0) {
                    showNotification('⚠️ Giỏ hàng đã trống!');
                    return;
                }
                
                if (confirm(`Bạn có chắc muốn xóa tất cả ${cart.length} sản phẩm khỏi giỏ hàng?`)) {
                    cart = [];
                    saveCart();
                    updateCartCount();
                    renderCartModal();
                    showNotification('🗑️ Đã xóa toàn bộ giỏ hàng!');
                }
            } catch (error) {
                console.error('Error clearing cart:', error);
            }
        }

        // Go to checkout
        function goToCheckout() {
            try {
                if (cart.length === 0) {
                    showNotification('⚠️ Giỏ hàng trống! Vui lòng thêm sản phẩm.');
                    return;
                }
                
                // Save cart one more time before checkout
                saveCart();
                
                // Redirect to checkout page
                window.location.href = '/checkout';
            } catch (error) {
                console.error('Error going to checkout:', error);
                showNotification('❌ Có lỗi khi chuyển đến trang thanh toán!');
            }
        }

        // Toggle cart - Now opens modal instead of alert
        function toggleCart() {
            openCartModal();
        }

        // Close modal when clicking outside (on the overlay/background)
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('cartModal');
            const modalContent = document.querySelector('.cart-modal-content');
            
            if (modal && event.target === modal && modalContent && !modalContent.contains(event.target)) {
                closeCartModal();
            }
        }, true);

        // Expose cart functions to global scope
        window.addToCart = addToCart;
        window.removeFromCart = removeFromCart;
        window.removeFromCartModal = removeFromCartModal;
        window.clearCart = clearCart;
        window.confirmClearCart = confirmClearCart;
        window.updateQuantity = updateQuantity;
        window.increaseQuantity = increaseQuantity;
        window.decreaseQuantity = decreaseQuantity;
        window.toggleCart = toggleCart;
        window.openCartModal = openCartModal;
        window.closeCartModal = closeCartModal;
        window.renderCartModal = renderCartModal;
        window.goToCheckout = goToCheckout;
        window.getCartTotal = getCartTotal;
        window.updateCartCount = updateCartCount;
        
        // Test function to check cart count element
        window.testCartCount = function() {
            console.log('🧪 Testing cart count element...');
            const elem = document.getElementById('cartCount');
            console.log('Element found:', !!elem);
            if (elem) {
                console.log('Element:', elem);
                console.log('Current text:', elem.textContent);
                elem.textContent = '999';
                console.log('Text updated to: 999');
            } else {
                console.log('Element NOT found!');
            }
        };

        // Add animations CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulseCart {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.3); }
            }
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(400px); opacity: 0; }
            }
            @keyframes shimmer {
                0% { background-position: -1000px 0; }
                100% { background-position: 1000px 0; }
            }
        `;
        document.head.appendChild(style);

        // Initialize
        window.addEventListener('DOMContentLoaded', () => {
            // Load cart from localStorage FIRST
            loadCart();
            
            // Start animations
            setTimeout(() => createParticles(), 100);
            setTimeout(() => renderProducts(), 200);

            // Add touch support for mobile
            if ('ontouchstart' in window) {
                document.body.classList.add('touch-device');
            }
            
            // Restart animations periodically for particles
            setInterval(() => {
                const particles = document.querySelectorAll('.particle');
                particles.forEach(p => {
                    const currentDelay = parseFloat(p.style.animationDelay) || 0;
                    p.style.animationDelay = currentDelay + 's';
                });
            }, 30000);

            // Prevent double-tap zoom on buttons
            let lastTouchEnd = 0;
            document.addEventListener('touchend', (e) => {
                const now = Date.now();
                if (now - lastTouchEnd <= 300) {
                    e.preventDefault();
                }
                lastTouchEnd = now;
            }, { passive: false });
            
            // Ensure animations still work on mobile
            document.body.style.setProperty('--enable-animations', '1');
        });

        // Smooth scroll for all links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add parallax effect on scroll
        const enableParallax = window.innerWidth > 768;
        
        if (enableParallax) {
            let ticking = false;
            
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        const scrolled = window.pageYOffset;
                        const parallaxElements = document.querySelectorAll('.floating-card');
                        parallaxElements.forEach((el, index) => {
                            const speed = 0.3 + (index * 0.1);
                            el.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.05}deg)`;
                        });
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        }

        // Responsive image loading
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Handle orientation change
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                window.scrollTo(0, 0);
            }, 100);
        });

        // Detect and handle viewport resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                // Close mobile menu on resize to desktop
                if (window.innerWidth > 768) {
                    closeMobileMenu();
                }
            }, 250);
        });
    </script>
    
    <script src="{{ asset('js/product-management.js') }}?v={{ time() }}" onerror="console.error('Failed to load product-management.js')"></script>
    <script>
        // Error handling và debugging
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error, 'at', e.filename + ':' + e.lineno);
        });
        
        // Update admin button when API data loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const adminBtn = document.getElementById('adminAddBtn');
                const adminCategoryBtn = document.getElementById('adminCategoryBtn');
                // Check if isAdmin exists before using it
                if (adminBtn && window.isAdmin) {
                    adminBtn.style.display = 'block';
                }
                if (adminCategoryBtn && window.isAdmin) {
                    adminCategoryBtn.style.display = 'block';
                }
            }, 1000);
        });

        // Save cart before page unload
        window.addEventListener('beforeunload', function() {
            try {
                saveCart();
                console.log('Cart saved before page unload');
            } catch (error) {
                console.error('Error saving cart on unload:', error);
            }
        });

        // Save cart periodically (every 30 seconds)
        setInterval(function() {
            try {
                if (cart && cart.length > 0) {
                    saveCart();
                    console.log('Periodic cart save:', cart.length, 'items');
                }
            } catch (error) {
                console.error('Error in periodic cart save:', error);
            }
        }, 30000);
    </script>
  <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="section-title">💫 ƯU ĐÃI KHỦNG 💫</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <div class="feature-title">Giao Siêu Tốc</div>
                <p>Giao hàng trong 24h</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <div class="feature-title">Giá Shock</div>
                <p>Giảm giá tới 50%</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <div class="feature-title">Bảo Mật</div>
                <p>An toàn tuyệt đối</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎁</div>
                <div class="feature-title">Quà Khủng</div>
                <p>Tặng quà mỗi đơn</p>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="dynamic-footer" id="dynamicFooter">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-title" id="footerSiteName">ShopPro VIP</div>
                    <p id="footerAbout">Website bán hàng chuyên nghiệp với đội ngũ tư vấn nhiệt tình và sản phẩm chất lượng cao.</p>
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
                <div class="footer-copyright" id="footerCopyright">© 2026 ShopPro VIP | Made with ❤️ by Professional Team</div>
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

            /* Center & evenly align footer content on mobile */
            .footer-col {
                text-align: center;
            }

            .footer-info p {
                justify-content: center;
                text-align: left;
                margin-left: auto;
                margin-right: auto;
                max-width: 340px;
            }

            .footer-social {
                align-items: center;
            }

            .footer-social a {
                width: 100%;
                max-width: 340px;
                justify-content: center;
            }
        }
    </style>

    <script>
        // Load footer settings from API
        async function loadFooterSettings() {
            try {
                const response = await fetch('/api/settings/footer');
                if (!response.ok) return;
                
                const data = await response.json();
                
                // Update footer content
                document.getElementById('footerSiteName').textContent = data.site_name || 'ShopPro VIP';
                document.getElementById('footerAbout').textContent = data.description || data.footer_about || 'Website bán hàng chuyên nghiệp';
                document.getElementById('footerAddress').textContent = data.address || '123 Đường Nguyễn Văn Linh, Quận 7, TP.HCM';
                document.getElementById('footerHours').textContent = data.operating_hours || data.working_hours || '8:00 - 22:00';
                
                // Update phone
                const phoneEl = document.getElementById('footerPhone');
                if (phoneEl) {
                    phoneEl.textContent = data.phone || '0123 456 789';
                    phoneEl.href = 'tel:' + (data.phone || '0123456789').replace(/\s/g, '');
                }
                
                // Update email  
                const emailEl = document.getElementById('footerEmail');
                if (emailEl) {
                    emailEl.textContent = data.email || 'contact@shoppro.vn';
                    emailEl.href = 'mailto:' + (data.email || 'contact@shoppro.vn');
                }
                
                // Update social links
                if (data.facebook || data.social_facebook) {
                    document.getElementById('footerFacebook').href = data.facebook || data.social_facebook;
                }
                if (data.instagram || data.social_instagram) {
                    document.getElementById('footerInstagram').href = data.instagram || data.social_instagram;
                }
                if (data.tiktok || data.social_tiktok) {
                    document.getElementById('footerTiktok').href = data.tiktok || data.social_tiktok;
                }
                if (data.youtube || data.social_youtube) {
                    document.getElementById('footerYoutube').href = data.youtube || data.social_youtube;
                }
                
                // Update copyright
                const currentYear = new Date().getFullYear();
                document.getElementById('footerCopyright').innerHTML = data.copyright_text || data.copyright || `© ${currentYear} ShopPro VIP | Made with ❤️ by Professional Team`;
                
            } catch (error) {
                console.error('Failed to load footer settings:', error);
            }
        }
        
        // Load footer when page loads
        document.addEventListener('DOMContentLoaded', loadFooterSettings);
        
        // Load website theme settings
        async function loadWebsiteSettings() {
            try {
                console.log('Loading website settings...');
                const response = await fetch('/api/settings/website');
                if (response.ok) {
                    const settings = await response.json();
                    console.log('Website settings loaded:', settings);
                    
                    // Update CSS variables - Primary colors
                    if (settings.primary_color) {
                        console.log('Setting primary color to:', settings.primary_color);
                        document.documentElement.style.setProperty('--primary', settings.primary_color);
                        document.documentElement.style.setProperty('--secondary', settings.primary_color);
                        document.documentElement.style.setProperty('--royal-blue', settings.primary_color);
                        document.documentElement.style.setProperty('--gold', settings.primary_color);
                    }
                    
                    if (settings.secondary_color) {
                        console.log('Setting secondary color to:', settings.secondary_color);
                        document.documentElement.style.setProperty('--secondary', settings.secondary_color);
                    }
                    
                    // Background colors
                    if (settings.background_color) {
                        console.log('Setting background color to:', settings.background_color);
                        document.documentElement.style.setProperty('--bg-light', settings.background_color);
                    }
                    
                    if (settings.card_color) {
                        console.log('Setting card color to:', settings.card_color);
                        document.documentElement.style.setProperty('--light', settings.card_color);
                        document.documentElement.style.setProperty('--accent', settings.card_color);
                        document.documentElement.style.setProperty('--pink', settings.card_color);
                    }
                    
                    // Text colors
                    if (settings.text_color) {
                        console.log('Setting text color to:', settings.text_color);
                        document.documentElement.style.setProperty('--text-dark', settings.text_color);
                        document.documentElement.style.setProperty('--dark', settings.text_color);
                    }
                    
                    // Special accent color for highlights
                    if (settings.accent_color) {
                        console.log('Setting accent color to:', settings.accent_color);
                        document.documentElement.style.setProperty('--accent-special', settings.accent_color);
                    }
                    
                    // Update page title
                    if (settings.website_name) {
                        document.title = `🔥 ${settings.website_name} - Siêu Thị Online Đẳng Cấp`;
                        
                        // Update header logo
                        const headerLogo = document.querySelector('.nav-logo');
                        if (headerLogo) {
                            headerLogo.textContent = settings.website_name;
                        }
                    }
                    
                    // Update tagline if exists
                    if (settings.website_tagline) {
                        const heroTitle = document.querySelector('.hero-title');
                        if (heroTitle) {
                            heroTitle.innerHTML = `✨ ${settings.website_tagline} ✨`;
                        }
                    }
                    
                    console.log('Website settings applied successfully');
                } else {
                    console.error('Failed to fetch website settings, status:', response.status);
                }
            } catch (error) {
                console.error('Error loading website settings:', error);
            }
        }
        
        // Load website settings on page load
        document.addEventListener('DOMContentLoaded', loadWebsiteSettings);
        
        // Auto-hide session notifications
        document.addEventListener('DOMContentLoaded', function() {
            const sessionNotifications = document.querySelectorAll('.notification.success, .notification.error');
            sessionNotifications.forEach(function(notification) {
                // Add click to hide functionality
                notification.style.cursor = 'pointer';
                notification.addEventListener('click', function() {
                    this.style.animation = 'slideOutRight 0.5s ease-out';
                    setTimeout(() => this.remove(), 500);
                });
                
                // Auto-hide after 5 seconds
                setTimeout(function() {
                    if (notification && notification.parentNode) {
                        notification.style.animation = 'slideOutRight 0.5s ease-out';
                        setTimeout(() => {
                            if (notification.parentNode) {
                                notification.remove();
                            }
                        }, 500);
                    }
                }, 5000);
            });
        });

        // ============ MOBILE OPTIMIZATION SCRIPTS ============
        
        // Mobile Toast Notification
        function showMobileToast(message, type = 'success') {
            const toast = document.getElementById('mobileToast');
            const toastText = document.getElementById('mobileToastText');
            const toastIcon = toast.querySelector('.mobile-toast-icon');
            
            if (!toast) return;
            
            // Set message and style
            toastText.textContent = message;
            toast.className = 'mobile-toast ' + type;
            
            // Set icon based on type
            if (type === 'success') {
                toastIcon.textContent = '✓';
            } else if (type === 'error') {
                toastIcon.textContent = '✕';
            } else {
                toastIcon.textContent = 'ℹ';
            }
            
            // Show toast
            toast.classList.add('show');
            
            // Hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Update Mobile Cart Badge
        function updateMobileCartBadge() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            
            const mobileBadge = document.getElementById('mobileCartBadge');
            const headerBadge = document.getElementById('cartCount');
            
            if (mobileBadge) {
                if (totalItems > 0) {
                    mobileBadge.style.display = 'flex';
                    mobileBadge.textContent = totalItems > 99 ? '99+' : totalItems;
                } else {
                    mobileBadge.style.display = 'none';
                }
            }
            
            if (headerBadge) {
                headerBadge.textContent = totalItems;
            }
        }

        // Mobile Bottom Navigation - Active State on Scroll
        function initMobileBottomNav() {
            const navItems = document.querySelectorAll('.mobile-nav-item[data-section]');
            const sections = document.querySelectorAll('section[id]');
            
            if (navItems.length === 0) return;

            // Handle click events
                navItems.forEach(item => {
                    item.addEventListener('click', function(e) {
                        const href = this.getAttribute('href') || '';

                        // Only handle in-page section scroll for hash links
                        if (!href.startsWith('#')) return;

                        const sectionId = this.getAttribute('data-section') || href.slice(1);
                        const targetSection = sectionId ? document.getElementById(sectionId) : null;

                        // Fallback to normal anchor behavior if the target doesn't exist
                        if (!targetSection) return;

                    e.preventDefault();
                    
                    if (targetSection) {
                        const headerHeight = 60;
                        const searchHeight = window.innerWidth <= 768 ? 70 : 0;
                        const offset = headerHeight + searchHeight;
                        
                        window.scrollTo({
                            top: targetSection.offsetTop - offset,
                            behavior: 'smooth'
                        });
                    }
                    
                    // Update active state
                    navItems.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Update active state on scroll
            window.addEventListener('scroll', function() {
                let currentSection = '';
                const scrollPosition = window.scrollY + 150;
                
                sections.forEach(section => {
                    if (section.offsetTop <= scrollPosition) {
                        currentSection = section.getAttribute('id');
                    }
                });

                navItems.forEach(item => {
                    item.classList.remove('active');
                    const itemSection = item.getAttribute('data-section');
                    if (itemSection === currentSection) {
                        item.classList.add('active');
                    }
                });
            });
        }

        // Mobile Search Functionality
        function initMobileSearch() {
            const searchInput = document.getElementById('mobileSearchInput');
            const searchClear = document.getElementById('mobileSearchClear');
            
            if (!searchInput) return;

            // Clear button functionality
            if (searchClear) {
                searchClear.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.focus();
                    filterProducts('');
                });
            }

            // Search on input
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filterProducts(this.value.trim().toLowerCase());
                }, 300);
            });

            // Search on enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    filterProducts(this.value.trim().toLowerCase());
                }
            });
        }

        // Filter products by search term
        function filterProducts(term) {
            const productCards = document.querySelectorAll('.product-card');
            let visibleCount = 0;
            
            productCards.forEach(card => {
                const title = card.querySelector('.product-title')?.textContent.toLowerCase() || '';
                const price = card.querySelector('.product-price')?.textContent.toLowerCase() || '';
                
                if (term === '' || title.includes(term) || price.includes(term)) {
                    card.style.display = '';
                    card.style.animation = 'fadeIn 0.3s ease';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show message if no results
            if (visibleCount === 0 && term !== '') {
                showMobileToast('Không tìm thấy sản phẩm phù hợp', 'error');
            }
        }

        // Mobile Category Chips
        function initMobileCategoryChips() {
            const chips = document.querySelectorAll('.mobile-category-chip');
            
            chips.forEach(chip => {
                chip.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update active state
                    chips.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filter by category (mobile chips)
                    const category = this.getAttribute('data-category');
                    filterByCategoryKey(category);
                    
                    // Scroll to products section
                    const productsSection = document.getElementById('products');
                    if (productsSection) {
                        setTimeout(() => {
                            window.scrollTo({
                                top: productsSection.offsetTop - 150,
                                behavior: 'smooth'
                            });
                        }, 100);
                    }
                });
            });
        }

        // Filter products by category
        function filterByCategoryKey(category) {
            // This would connect to your existing category filtering logic
            // For now, trigger click on corresponding category card if exists
            const categoryCards = document.querySelectorAll('.category-card');
            
            if (category === 'all') {
                // Show all products
                document.querySelectorAll('.product-card').forEach(card => {
                    card.style.display = '';
                });
                return;
            }

            // Try to find matching category
            categoryCards.forEach(card => {
                const cardName = card.querySelector('.category-name')?.textContent.toLowerCase() || '';
                if (cardName.includes(category)) {
                    card.click();
                }
            });
        }

        // Override addToCart to show mobile toast
        const originalAddToCart = window.addToCart;
        window.addToCart = function(productId) {
            if (typeof originalAddToCart === 'function') {
                originalAddToCart(productId);
            }
            
            // Update mobile cart badge
            updateMobileCartBadge();
            
            // Show mobile toast on mobile devices
            if (window.innerWidth <= 768) {
                showMobileToast('Đã thêm vào giỏ hàng! 🛒', 'success');
            }
        };

        // Hide header on scroll down, show on scroll up (mobile only)
        function initMobileHeaderBehavior() {
            if (window.innerWidth > 768) return;
            
            let lastScroll = 0;
            const header = document.querySelector('.header');
            
            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;
                
                if (currentScroll <= 0) {
                    header.style.transform = 'translateY(0)';
                    return;
                }
                
                if (currentScroll > lastScroll && currentScroll > 100) {
                    // Scrolling down
                    header.style.transform = 'translateY(-100%)';
                    header.style.transition = 'transform 0.3s ease';
                } else {
                    // Scrolling up
                    header.style.transform = 'translateY(0)';
                }
                
                lastScroll = currentScroll;
            });
        }

        // Initialize all mobile features
        document.addEventListener('DOMContentLoaded', function() {
            initMobileBottomNav();
            initMobileSearch();
            initMobileCategoryChips();
            initMobileHeaderBehavior();
            updateMobileCartBadge();
            
            // Update cart badge when storage changes
            window.addEventListener('storage', updateMobileCartBadge);
            
            // Also update after any cart operation
            const originalUpdateCart = window.updateCartDisplay;
            if (typeof originalUpdateCart === 'function') {
                window.updateCartDisplay = function() {
                    originalUpdateCart();
                    updateMobileCartBadge();
                };
            }
        });
    </script>

</body>
</html>
