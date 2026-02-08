<nav class="navx navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navx-brand" href="/">
            <span class="navx-mark" aria-hidden="true">S</span>
            <span class="navx-word">
                <span class="navx-title">Shop Bán Hàng</span>
                <span class="navx-sub">Thời trang chọn lọc</span>
            </span>
        </a>

        <button class="navx-toggle navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse navx-collapse" id="nav">
            <div class="navx-search">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Tìm kiếm">
            </div>

            <ul class="navx-menu">
                <li><a class="{{ request()->is('/') ? 'navx-link active' : 'navx-link' }}" href="/">Trang chủ</a></li>
                <li><a class="{{ request()->is('shop*') || request()->is('product*') ? 'navx-link active' : 'navx-link' }}" href="/shop">Sản phẩm</a></li>
                <li><a class="{{ request()->is('flashell*') ? 'navx-link active' : 'navx-link' }}" href="/flashell">Giảm giá</a></li>
                <li><a class="{{ request()->is('about*') ? 'navx-link active' : 'navx-link' }}" href="/about">Giới thiệu</a></li>
                <li><a class="{{ request()->is('contact*') ? 'navx-link active' : 'navx-link' }}" href="/contact">Liên hệ</a></li>
            </ul>

            <div class="navx-actions">
                <a href="/wishlist" class="navx-action" aria-label="Yêu thích">
                    <i class="far fa-heart"></i>
                    <span>Yêu thích</span>
                    @if(session('wishlist') && count(session('wishlist')) > 0)
                        <span class="navx-badge navx-badge-wishlist">{{ count(session('wishlist')) }}</span>
                    @else
                        <span class="navx-badge navx-badge-wishlist d-none">0</span>
                    @endif
                </a>
                <a href="/cart" class="navx-action" aria-label="Giỏ hàng">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M3 5h2l2.4 9.5a2 2 0 0 0 2 1.5h7.5a2 2 0 0 0 2-1.6l1.1-5.4H7.1" />
                        <circle cx="10" cy="20" r="1.5" />
                        <circle cx="17" cy="20" r="1.5" />
                    </svg>
                    <span>Giỏ hàng</span>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="navx-badge">{{ count(session('cart')) }}</span>
                    @else
                        <span class="navx-badge d-none">0</span>
                    @endif
                </a>
                @auth
                    <div class="dropdown">
                        <a href="#" class="navx-action dropdown-toggle text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; flex-direction: column; align-items: center;">
                             <i class="far fa-user"></i>
                             <span style="font-size: 0.75rem; margin-top: 4px; max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="far fa-id-card me-2"></i>Hồ sơ cá nhân</a></li>
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Trang quản trị</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="navx-action" aria-label="Tài khoản">
                        <i class="far fa-user"></i>
                        <span>Đăng nhập</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
