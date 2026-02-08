@extends('layouts.app')

@section('title', 'Cửa Hàng Thời Trang - Mua Sắm Online')
@section('meta_description', 'Mua sắm thời trang online với giá tốt nhất.')

@section('content')
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
                        <img src="https://images.unsplash.com/photo-1521334884684-d80222895322?w=500" alt="Phụ kiện">
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
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-card {{ $product->quantity <= 0 ? 'out-of-stock' : '' }}">
                        <div class="product-image">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}">
                            @if($product->quantity <= 0)
                                <span class="product-badge out-of-stock-badge">Hết hàng</span>
                            @elseif($product->created_at->diffInDays(now()) < 7)
                                <span class="product-badge new">Mới</span>
                            @endif
                            @if($product->quantity <= 0)
                                <div class="out-of-stock-overlay">
                                    <i class="fas fa-ban"></i>
                                    <p>Tạm hết hàng</p>
                                </div>
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-category">{{ $product->category->name ?? 'N/A' }}</div>
                            <h3 class="product-name">{{ $product->name }}</h3>
                            
                            @if($product->sizes && count($product->sizes) > 0)
                                <div class="product-sizes">
                                    <small class="text-muted">Size: </small>
                                    @foreach($product->sizes as $size)
                                        <span class="size-tag">{{ $size }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            @php
                                $colorDots = [];
                                $colorPrices = is_array($product->color_prices) ? $product->color_prices : json_decode($product->color_prices ?? '[]', true);
                                if (!empty($colorPrices)) {
                                    foreach ($colorPrices as $data) {
                                        if (!empty($data['hex'])) $colorDots[] = $data['hex'];
                                    }
                                }
                                if (empty($colorDots) && !empty($product->colors)) {
                                    $colorDots = is_array($product->colors) ? $product->colors : json_decode($product->colors ?? '[]', true);
                                }
                            @endphp
                            @if(!empty($colorDots))
                                <div class="product-colors">
                                    <small class="text-muted">Màu: </small>
                                    @foreach($colorDots as $color)
                                        <span class="color-dot-small" style="background: {{ $color }}" title="{{ $color }}"></span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="product-price">
                                <span class="price-current">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                            </div>
                            
                            <div class="product-stock-info">
                                @if($product->quantity > 0 && $product->quantity <= 5)
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Chỉ còn {{ $product->quantity }} sản phẩm
                                    </small>
                                @elseif($product->quantity > 0)
                                    <small class="text-success">
                                        <i class="fas fa-check-circle"></i> Còn hàng ({{ $product->quantity }})
                                    </small>
                                @else
                                    <small class="text-danger">
                                        <i class="fas fa-times-circle"></i> Hết hàng
                                    </small>
                                @endif
                            </div>
                            
                            <div class="product-actions">
                                <button class="btn-add-cart" 
                                        {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                        data-product-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    {{ $product->quantity <= 0 ? 'Hết hàng' : 'Thêm vào giỏ' }}
                                </button>
                                <button class="btn-wishlist" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="/shop" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 50px;">
                    Xem Tất Cả Sản Phẩm <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
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
@endpush
