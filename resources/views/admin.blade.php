<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - ShopPro</title>
    <meta name="description" content="Admin panel quản lý website bán hàng">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/image-upload.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h1 class="sidebar-logo">
                Shop<span class="gradient-text">Pro</span>
                <span class="admin-badge">Admin</span>
            </h1>
            <button class="sidebar-toggle" id="sidebar-toggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">
            <a href="#dashboard" class="nav-item active" data-page="dashboard">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="#products" class="nav-item" data-page="products">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                </svg>
                <span>Sản Phẩm</span>
                <span class="badge">124</span>
            </a>
            <a href="#categories" class="nav-item" data-page="categories">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2.414-.646l-5.106-6.564a2 2 0 0 0-1.579-.459H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.506a2 2 0 0 0 1.659-.745l.812-1.054A2 2 0 0 1 15.494 1H17a2 2 0 0 1 2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 1 2 2v3a2 2 0 0 1-.414 1.267l-3.97 5.347A2 2 0 0 0 23 15v2a2 2 0 0 1-1 1.732z"></path>
                </svg>
                <span>Danh Mục</span>
                <span class="badge">8</span>
            </a>
            <a href="#orders" class="nav-item" data-page="orders">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Đơn Hàng</span>
                <span class="badge badge-primary">12</span>
            </a>
            <a href="#users" class="nav-item" data-page="users">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Khách Hàng</span>
                <span class="badge">1.2K</span>
            </a>
            <a href="#analytics" class="nav-item" data-page="analytics">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="20" x2="12" y2="10"></line>
                    <line x1="18" y1="20" x2="18" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="16"></line>
                </svg>
                <span>Thống Kê</span>
            </a>
            <a href="#settings" class="nav-item" data-page="settings">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 1v6m0 6v6m-4-2.92l4.24-4.24L16.49 16M7.76 12l4.24-4.24 4.25 4.24M12 1l3.09 3.09L12 7.18 8.91 4.09 12 1z"></path>
                </svg>
                <span>Cài Đặt</span>
            </a>
            <a href="#footer" class="nav-item" data-page="footer">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 20h20v-2H2v2zm0-3h20v-2H2v2zm0-3h20v-2H2v2zm0-3h20V9H2v2zm0-3h20V6H2v2z"></path>
                </svg>
                <span>Footer</span>
            </a>
        </nav>

        <div class="sidebar-user">
            <div class="user-avatar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
            </div>
            <div class="user-info">
                <div class="user-name">Admin User</div>
                <div class="user-role">Super Admin</div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <button class="mobile-menu-btn" id="mobile-menu-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <div class="topbar-search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" placeholder="Tìm kiếm...">
            </div>

            <div class="topbar-actions">
                <button class="theme-toggle" id="theme-toggle" title="Toggle Dark Mode">
                    <svg class="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    <svg class="moon-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>

                <a href="/" class="btn btn-outline" title="Về Trang Chủ">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9,22 9,12 15,12 15,22"></polyline>
                    </svg>
                    Trang Chủ
                </a>
                
                <button class="notification-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-dot"></span>
                </button>

                <button class="user-menu-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content" id="page-content">
            <!-- Dashboard page will be loaded here by JS -->
        </div>
    </main>

    <script src="{{ asset('js/product-admin.js') }}"></script>
    <script src="{{ asset('js/inline-categories.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <!-- Load website settings -->
    <script>
        // Load website theme settings for admin
        async function loadAdminWebsiteSettings() {
            try {
                const response = await fetch('/api/settings/website');
                if (response.ok) {
                    const settings = await response.json();
                    
                    // Update CSS variables
                    if (settings.primary_color) {
                        document.documentElement.style.setProperty('--color-primary', settings.primary_color);
                    }
                    if (settings.secondary_color) {
                        document.documentElement.style.setProperty('--color-secondary', settings.secondary_color);
                    }
                    if (settings.accent_color) {
                        document.documentElement.style.setProperty('--color-accent', settings.accent_color);
                    }
                    
                    // Update page title
                    if (settings.website_name) {
                        document.title = `Admin Dashboard - ${settings.website_name}`;
                    }
                }
            } catch (error) {
                console.error('Error loading website settings:', error);
            }
        }
        
        // Load settings on page load
        document.addEventListener('DOMContentLoaded', loadAdminWebsiteSettings);
    </script>
</body>
</html>
