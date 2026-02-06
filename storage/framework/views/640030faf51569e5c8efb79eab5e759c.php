<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mua sắm thời trang online với giá tốt nhất. Hàng ngàn sản phẩm quần áo, giày dép, phụ kiện chính hãng.">
    <title>Cửa Hàng Thời Trang - Mua Sắm Online Giá Tốt</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/ecommerce.css')); ?>">
</head>
<body>
    
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-phone-alt me-2"></i>
                    <a href="tel:0123456789">0123 456 789</a>
                    <i class="fas fa-envelope ms-3 me-2"></i>
                    <a href="mailto:info@shop.com">info@shop.com</a>
                </div>
                <div><a href="#"><i class="fas fa-truck me-1"></i> Miễn phí ship đơn từ 500k</a></div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-shopping-bag me-2"></i>ShopName</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/shop">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="/categories">Danh mục</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Liên hệ</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="/wishlist" class="text-dark"><i class="far fa-heart fa-lg"></i></a>
                    <a href="/cart" class="text-dark cart-icon">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <span class="cart-badge">3</span>
                    </a>
                    <a href="/account" class="text-dark"><i class="far fa-user fa-lg"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="marquee" data-speed-desktop="60" data-speed-mobile="40">Thời Trang Mới - Xu Hướng 2026</h1>
                    <p>Khám phá bộ sưu tập mới nhất với hàng ngàn sản phẩm thời trang cao cấp. Giảm giá lên đến 50%.</p>
                    <button class="btn"><i class="fas fa-shopping-bag me-2"></i>Mua Ngay</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
                        <h3>Giao Hàng Nhanh</h3>
                        <p>Miễn phí ship đơn từ 500k</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-undo-alt"></i></div>
                        <h3>Đổi Trả 7 Ngày</h3>
                        <p>Hoàn tiền 100% nếu lỗi</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                        <h3>Thanh Toán An Toàn</h3>
                        <p>Bảo mật thông tin 100%</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-headset"></i></div>
                        <h3>Hỗ Trợ 24/7</h3>
                        <p>Tư vấn nhiệt tình</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Danh Mục Sản Phẩm</h2>
            <div class="row g-4">
                <div class="col-md-4 col-6">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=500" alt="Thời trang nữ">
                        <div class="category-overlay">
                            <h3 class="category-name">Thời Trang Nữ</h3>
                            <p>1,234 sản phẩm</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1516826957135-700dedea698c?w=500" alt="Thời trang nam">
                        <div class="category-overlay">
                            <h3 class="category-name">Thời Trang Nam</h3>
                            <p>856 sản phẩm</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1514590353344-c6cfe1b49e0f?w=500" alt="Phụ kiện">
                        <div class="category-overlay">
                            <h3 class="category-name">Phụ Kiện</h3>
                            <p>432 sản phẩm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="products">
        <div class="container">
            <h2 class="section-title">Sản Phẩm Bán Chạy</h2>
            <div class="row g-4">
                <?php
                $products = [
                    ['name' => 'Áo Thun Nam Basic Cotton', 'category' => 'Áo thun', 'price' => '245.000đ', 'oldPrice' => '350.000đ', 'badge' => '-30%', 'rating' => 4.5, 'img' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400'],
                    ['name' => 'Váy Maxi Hoa Nhí Vintage', 'category' => 'Váy', 'price' => '450.000đ', 'oldPrice' => '', 'badge' => 'new', 'rating' => 5.0, 'img' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400'],
                    ['name' => 'Giày Thể Thao Nam Cao Cấp', 'category' => 'Giày', 'price' => '675.000đ', 'oldPrice' => '900.000đ', 'badge' => '-25%', 'rating' => 4.0, 'img' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400'],
                    ['name' => 'Túi Xách Nữ Da Cao Cấp', 'category' => 'Túi xách', 'price' => '540.000đ', 'oldPrice' => '900.000đ', 'badge' => '-40%', 'rating' => 4.7, 'img' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400'],
                    ['name' => 'Áo Sơ Mi Nam Công Sở', 'category' => 'Áo sơ mi', 'price' => '320.000đ', 'oldPrice' => '', 'badge' => '', 'rating' => 4.2, 'img' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400'],
                    ['name' => 'Quần Jean Nữ Skinny', 'category' => 'Quần', 'price' => '380.000đ', 'oldPrice' => '', 'badge' => 'new', 'rating' => 5.0, 'img' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=400'],
                ];
                ?>

                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?php echo e($product['img']); ?>" alt="<?php echo e($product['name']); ?>">
                            <?php if($product['badge']): ?>
                                <span class="product-badge <?php echo e($product['badge'] == 'new' ? 'new' : ''); ?>">
                                    <?php echo e($product['badge'] == 'new' ? 'Mới' : $product['badge']); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <div class="product-category"><?php echo e($product['category']); ?></div>
                            <h3 class="product-name"><?php echo e($product['name']); ?></h3>
                            <div class="product-rating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= floor($product['rating'])): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif($i - 0.5 <= $product['rating']): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="text-muted ms-1">(<?php echo e($product['rating']); ?>)</span>
                            </div>
                            <div class="product-price">
                                <span class="price-current"><?php echo e($product['price']); ?></span>
                                <?php if($product['oldPrice']): ?>
                                    <span class="price-old"><?php echo e($product['oldPrice']); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="product-actions">
                                <button class="btn-add-cart"><i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ</button>
                                <button class="btn-wishlist"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="text-center mt-5">
                <a href="/shop" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 50px;">
                    Xem Tất Cả Sản Phẩm <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h3 class="footer-title"><i class="fas fa-shopping-bag me-2"></i>ShopName</h3>
                    <p style="color: rgba(255,255,255,0.8);">Cửa hàng thời trang trực tuyến hàng đầu Việt Nam. Chúng tôi cam kết mang đến những sản phẩm chất lượng với giá tốt nhất.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h3 class="footer-title">Về Chúng Tôi</h3>
                    <ul class="footer-links">
                        <li><a href="/about">Giới thiệu</a></li>
                        <li><a href="/contact">Liên hệ</a></li>
                        <li><a href="/careers">Tuyển dụng</a></li>
                        <li><a href="/news">Tin tức</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h3 class="footer-title">Hỗ Trợ</h3>
                    <ul class="footer-links">
                        <li><a href="/shipping">Chính sách vận chuyển</a></li>
                        <li><a href="/returns">Đổi trả hàng</a></li>
                        <li><a href="/payment">Thanh toán</a></li>
                        <li><a href="/faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h3 class="footer-title">Liên Hệ</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i>123 Đường ABC, Quận 1, TP.HCM</li>
                        <li><i class="fas fa-phone me-2"></i><a href="tel:0123456789">0123 456 789</a></li>
                        <li><i class="fas fa-envelope me-2"></i><a href="mailto:info@shop.com">info@shop.com</a></li>
                        <li><i class="fas fa-clock me-2"></i>8:00 - 22:00 (Hàng ngày)</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 ShopName. All rights reserved. | Designed with <i class="fas fa-heart text-danger"></i> in Vietnam</p>
            </div>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add to cart
        document.querySelectorAll('.btn-add-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-check me-2"></i>Đã thêm';
                this.style.background = 'var(--success)';
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ';
                    this.style.background = 'var(--primary)';
                }, 2000);
            });
        });

        // Wishlist
        document.querySelectorAll('.btn-wishlist').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                this.style.color = icon.classList.contains('fas') ? 'var(--danger)' : '';
                this.style.borderColor = icon.classList.contains('fas') ? 'var(--danger)' : '';
            });
        });

        // Hero marquee (desktop + mobile speeds)
        function initMarquee(el) {
            if (!el || el.dataset.marqueeInit) return;
            const text = el.textContent.trim();
            if (!text) return;

            el.textContent = '';
            const track = document.createElement('div');
            track.className = 'marquee-track';

            const span1 = document.createElement('span');
            span1.className = 'marquee-text';
            span1.textContent = text;

            const span2 = span1.cloneNode(true);
            track.append(span1, span2);
            el.append(track);
            el.dataset.marqueeInit = '1';

            let waAnim = null;
            const applyAnimation = (distance, durationSec) => {
                if (waAnim) {
                    waAnim.cancel();
                    waAnim = null;
                }
                if (track.animate) {
                    waAnim = track.animate(
                        [
                            { transform: 'translateX(0)' },
                            { transform: `translateX(-${distance}px)` }
                        ],
                        {
                            duration: Math.max(6000, durationSec * 1000),
                            iterations: Infinity,
                            easing: 'linear'
                        }
                    );
                }
            };

            const update = () => {
                const isMobile = window.matchMedia('(max-width: 576px)').matches;
                const speed = parseFloat(isMobile ? el.dataset.speedMobile : el.dataset.speedDesktop) || 50;
                const textWidth = span1.getBoundingClientRect().width;
                const containerWidth = el.getBoundingClientRect().width;
                const gap = Math.max(32, Math.round(containerWidth * 0.08));
                const distance = textWidth + gap;
                const duration = Math.max(6, distance / speed);

                el.style.setProperty('--marquee-text-width', `${textWidth}px`);
                el.style.setProperty('--marquee-gap', `${gap}px`);
                el.style.setProperty('--marquee-duration', `${duration}s`);

                if (distance > 0) {
                    applyAnimation(distance, duration);
                }
            };

            const tryUpdate = (tries = 0) => {
                update();
                const w = parseFloat(getComputedStyle(el).getPropertyValue('--marquee-text-width')) || 0;
                if (w === 0 && tries < 6) {
                    requestAnimationFrame(() => tryUpdate(tries + 1));
                }
            };

            requestAnimationFrame(() => tryUpdate(0));
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(() => tryUpdate(0));
            }
            window.addEventListener('load', () => tryUpdate(0), { once: true });
            window.addEventListener('resize', update, { passive: true });
        }

        document.querySelectorAll('.hero h1.marquee').forEach(initMarquee);
    </script>
</body>
</html>
<?php /**PATH D:\dungthu.com\dungthu\demodungthu\resources\views/home.blade.php ENDPATH**/ ?>