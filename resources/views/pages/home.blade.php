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
            <div class="row g-4 justify-content-center">
                @foreach($categories as $category)
                <div class="col-md-4 col-6">
                    <a href="{{ url('/shop?category=' . $category->id) }}" class="category-card d-block text-decoration-none">
                        @if($category->icon)
                            <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="category-img">
                        @else
                            <div class="category-img-placeholder d-flex align-items-center justify-content-center bg-light" style="height: 300px;">
                                <i class="fas fa-image fa-3x text-secondary"></i>
                            </div>
                        @endif
                        <div class="category-overlay">
                            <h3 class="category-name text-white">{{ $category->name }}</h3>
                            <p class="text-white-50 mb-0">{{ $category->products_count }} sản phẩm</p>
                        </div>
                    </a>
                </div>
                @endforeach
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
                    @include('partials.product-card', ['product' => $product])
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
