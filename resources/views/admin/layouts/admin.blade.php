<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Quản trị</title>
    <link rel="stylesheet" href="/css/admin-dashboard.css">
    <link rel="stylesheet" href="/css/admin-products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <h2>🛒 Bộ công cụ quản trị</h2>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="/admin" class="{{ request()->is('admin') && !request()->is('admin/*') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Quản lý sản phẩm
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Đơn hàng
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->is('admin/customers*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Khách hàng
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Danh mục
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->is('admin/stats*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Thống kê
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Cài đặt
                </a>
            </li>
        </ul>
        
        <div style="padding: 20px; border-top: 1px solid #e0e0e0; margin-top: auto;">
            <h3 style="font-size: 14px; color: #5f6368; margin-bottom: 12px;">Công cụ hệ thống</h3>
            <ul class="sidebar-menu" style="padding: 0;">
                <li>
                    <form method="POST" action="/admin/clear-cache" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; width: 100%; text-align: left; padding: 12px 20px; color: #5f6368; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 12px; transition: all 0.3s ease;">
                            <i class="fas fa-broom" style="width: 20px; text-align: center;"></i> Xóa cache
                        </button>
                    </form>
                </li>
                <li>
                    <a href="/" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Xem trang web
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="topbar-title">
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="topbar-user">
                @yield('topbar-actions')
                <i class="fas fa-bell" style="font-size: 20px; color: #5f6368; cursor: pointer; margin-left: 16px;"></i>
                <div class="user-avatar">A</div>
                <span style="font-size: 14px; color: #202124;">Admin ▼</span>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Có lỗi xảy ra:</strong>
                    <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });

        // Confirm delete actions
        document.querySelectorAll('form[method="POST"]').forEach(form => {
            if (form.querySelector('input[name="_method"][value="DELETE"]')) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Bạn có chắc chắn muốn xóa?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
