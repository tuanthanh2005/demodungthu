// ========== ADMIN DASHBOARD JS ==========

// Sidebar Navigation
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    const navItems = document.querySelectorAll('.nav-item');
    const pageContent = document.getElementById('page-content');
    const themeToggle = document.getElementById('theme-toggle');

    // Sidebar Toggle
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-open');
        });
    }

    // Navigation
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            navItems.forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');

            const page = item.dataset.page;

            // Close mobile menu
            if (window.innerWidth < 768) {
                sidebar.classList.remove('mobile-open');
            }

            // Load page content
            switch (page) {
                case 'products':
                    setTimeout(() => {
                        if (typeof window.loadProductsPage === 'function') {
                            window.loadProductsPage();
                        } else {
                            console.error('loadProductsPage function not found!');
                            pageContent.innerHTML = '<p>Error: Products page not available. Please refresh page.</p>';
                        }
                    }, 100);
                    break;
                case 'categories':
                    setTimeout(() => {
                        if (typeof window.showCategoriesPage === 'function') {
                            window.showCategoriesPage();
                        } else {
                            console.error('showCategoriesPage function not found!');
                            pageContent.innerHTML = '<p>Error: Categories page not available. Please refresh page.</p>';
                        }
                    }, 100);
                    break;
                case 'dashboard':
                    loadDashboard();
                    break;
                case 'orders':
                    loadOrdersPage();
                    break;
                case 'users':
                    loadUsersPage();
                    break;
                case 'analytics':
                    loadAnalyticsPage();
                    break;
                case 'settings':
                    loadSettingsPage();
                    break;
                case 'footer':
                    loadFooterPage();
                    break;
                default:
                    loadDashboard();
            }
        });
    });

    // Theme Toggle
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('admin-dark-mode', document.body.classList.contains('dark-mode'));
        });
    }

    // Load dark mode preference
    if (localStorage.getItem('admin-dark-mode') === 'true') {
        document.body.classList.add('dark-mode');
    }

    // Load default page
    loadDashboard();
});

// Load Dashboard Page
function loadDashboard() {
    const pageContent = document.getElementById('page-content');

    // Ẩn tất cả admin pages
    const pages = document.querySelectorAll('.admin-page');
    pages.forEach(page => page.style.display = 'none');

    pageContent.innerHTML = `
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <h1>Dashboard</h1>
                    <p class="page-subtitle">Chào mừng đến admin panel</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
                <div style="background: var(--color-bg-secondary); padding: 24px; border-radius: 10px; box-shadow: var(--shadow-md);">
                    <div style="color: var(--color-text-secondary); font-size: 13px; text-transform: uppercase; margin-bottom: 8px;">Tổng Sản Phẩm</div>
                    <div style="font-size: 32px; font-weight: 700; color: var(--color-text-primary);" id="totalProducts">0</div>
                </div>

                <div style="background: var(--color-bg-secondary); padding: 24px; border-radius: 10px; box-shadow: var(--shadow-md);">
                    <div style="color: var(--color-text-secondary); font-size: 13px; text-transform: uppercase; margin-bottom: 8px;">Tổng Đơn Hàng</div>
                    <div style="font-size: 32px; font-weight: 700; color: var(--color-text-primary);">0</div>
                </div>

                <div style="background: var(--color-bg-secondary); padding: 24px; border-radius: 10px; box-shadow: var(--shadow-md);">
                    <div style="color: var(--color-text-secondary); font-size: 13px; text-transform: uppercase; margin-bottom: 8px;">Khách Hàng</div>
                    <div style="font-size: 32px; font-weight: 700; color: var(--color-text-primary);">0</div>
                </div>
            </div>
        </div>
    `;

    // Load total products
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            document.getElementById('totalProducts').textContent = data.length;
        });
}

// Load Orders Page
function loadOrdersPage() {
    document.getElementById('page-content').innerHTML = `
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <h1>Quản Lý Đơn Hàng</h1>
                    <p class="page-subtitle">Xem và quản lý các đơn hàng</p>
                </div>
            </div>
            <div style="text-align: center; padding: 40px;">
                <p style="color: var(--color-text-secondary);">Tính năng đơn hàng sẽ được phát triển sau</p>
            </div>
        </div>
    `;
}

// Load Users Page
function loadUsersPage() {
    document.getElementById('page-content').innerHTML = `
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <h1>Quản Lý Khách Hàng</h1>
                    <p class="page-subtitle">Xem danh sách khách hàng</p>
                </div>
            </div>
            <div style="text-align: center; padding: 40px;">
                <p style="color: var(--color-text-secondary);">Tính năng khách hàng sẽ được phát triển sau</p>
            </div>
        </div>
    `;
}

// Load Analytics Page
function loadAnalyticsPage() {
    document.getElementById('page-content').innerHTML = `
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <h1>Thống Kê</h1>
                    <p class="page-subtitle">Phân tích doanh số</p>
                </div>
            </div>
            <div style="text-align: center; padding: 40px;">
                <p style="color: var(--color-text-secondary);">Tính năng thống kê sẽ được phát triển sau</p>
            </div>
        </div>
    `;
}

// Load Settings Page
function loadSettingsPage() {
    document.getElementById('page-content').innerHTML = `
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <h1>Cài Đặt Website</h1>
                    <p class="page-subtitle">Tùy chỉnh giao diện và thông tin website</p>
                </div>
                <button class="btn btn-primary" onclick="saveWebsiteSettings()">
                    💾 Lưu Cài Đặt
                </button>
            </div>
            
            <div class="settings-container">
                <div class="settings-grid">
                    <!-- Website Name Settings -->
                    <div class="settings-card">
                        <h3>🏷️ Thông Tin Website</h3>
                        <div class="form-group">
                            <label for="websiteName">Tên Website</label>
                            <input type="text" id="websiteName" placeholder="ShopPro VIP" value="ShopPro VIP">
                            <small>Hiển thị trên thanh tiêu đề và header</small>
                        </div>
                        <div class="form-group">
                            <label for="websiteTagline">Slogan</label>
                            <input type="text" id="websiteTagline" placeholder="Website bán hàng VIP" value="Website bán hàng VIP">
                            <small>Mô tả ngắn về website</small>
                        </div>
                    </div>

                    <!-- Color Theme Settings -->
                    <div class="settings-card">
                        <h3>🎨 Bảng Màu Website</h3>
                        <div class="color-settings">
                            <!-- Primary Colors -->
                            <div class="color-section">
                                <h4>🔴 Màu Chính</h4>
                                <div class="form-group">
                                    <label for="primaryColor">Màu Chủ Đạo</label>
                                    <div class="color-input-group">
                                        <input type="color" id="primaryColor" value="#7851A9">
                                        <input type="text" id="primaryColorText" value="#7851A9" readonly>
                                    </div>
                                    <small>Nút chính, liên kết, thanh điều hướng, logo</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="secondaryColor">Màu Phụ</label>
                                    <div class="color-input-group">
                                        <input type="color" id="secondaryColor" value="#A583C7">
                                        <input type="text" id="secondaryColorText" value="#A583C7" readonly>
                                    </div>
                                    <small>Hiệu ứng gradient, nút phụ, viền</small>
                                </div>
                            </div>

                            <!-- Background Colors -->
                            <div class="color-section">
                                <h4>🌈 Màu Nền</h4>
                                <div class="form-group">
                                    <label for="backgroundColor">Nền Chính</label>
                                    <div class="color-input-group">
                                        <input type="color" id="backgroundColor" value="#f5f3f8">
                                        <input type="text" id="backgroundColorText" value="#f5f3f8" readonly>
                                    </div>
                                    <small>Nền trang chủ và các trang con</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cardColor">Nền Thẻ</label>
                                    <div class="color-input-group">
                                        <input type="color" id="cardColor" value="#ffffff">
                                        <input type="text" id="cardColorText" value="#ffffff" readonly>
                                    </div>
                                    <small>Nền sản phẩm, thẻ, popup, modal</small>
                                </div>
                            </div>

                            <!-- Text Colors -->
                            <div class="color-section">
                                <h4>📝 Màu Chữ</h4>
                                <div class="form-group">
                                    <label for="textColor">Chữ Chính</label>
                                    <div class="color-input-group">
                                        <input type="color" id="textColor" value="#2d1b47">
                                        <input type="text" id="textColorText" value="#2d1b47" readonly>
                                    </div>
                                    <small>Tiêu đề, nội dung chính</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="mutedColor">Chữ Phụ</label>
                                    <div class="color-input-group">
                                        <input type="color" id="mutedColor" value="#6b7280">
                                        <input type="text" id="mutedColorText" value="#6b7280" readonly>
                                    </div>
                                    <small>Mô tả, ghi chú, thông tin bổ sung</small>
                                </div>
                            </div>

                            <!-- Status Colors -->
                            <div class="color-section">
                                <h4>🚦 Màu Trạng Thái</h4>
                                <div class="form-group">
                                    <label for="successColor">Thành Công</label>
                                    <div class="color-input-group">
                                        <input type="color" id="successColor" value="#10b981">
                                        <input type="text" id="successColorText" value="#10b981" readonly>
                                    </div>
                                    <small>Thông báo thành công, nút xác nhận</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="errorColor">Lỗi</label>
                                    <div class="color-input-group">
                                        <input type="color" id="errorColor" value="#ef4444">
                                        <input type="text" id="errorColorText" value="#ef4444" readonly>
                                    </div>
                                    <small>Thông báo lỗi, cảnh báo nguy hiểm</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="warningColor">Cảnh Báo</label>
                                    <div class="color-input-group">
                                        <input type="color" id="warningColor" value="#f59e0b">
                                        <input type="text" id="warningColorText" value="#f59e0b" readonly>
                                    </div>
                                    <small>Thông báo cảnh báo, chú ý</small>
                                </div>

                                <div class="form-group">
                                    <label for="accentColor">Nhấn Mạnh</label>
                                    <div class="color-input-group">
                                        <input type="color" id="accentColor" value="#F39C12">
                                        <input type="text" id="accentColorText" value="#F39C12" readonly>
                                    </div>
                                    <small>Khuyến mãi, ưu đãi hot, badge</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Live Preview -->
                <div class="settings-preview">
                    <h3>👀 Xem Trước</h3>
                    <div class="preview-container">
                        <div class="preview-header" id="previewHeader">
                            <div class="preview-logo" id="previewLogo">ShopPro VIP</div>
                            <button class="preview-btn" id="previewBtn">Sản phẩm</button>
                        </div>
                        <div class="preview-content">
                            <h2 id="previewTitle">Website bán hàng VIP</h2>
                            <p>Chào mừng đến với website của chúng tôi!</p>
                            <button class="preview-accent" id="previewAccent">Khuyến mãi hot 🔥</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status Messages -->
            <div id="settingsMessages" style="margin-top: 20px;"></div>
        </div>
    `;

    // Load existing settings
    loadWebsiteSettings();

    // Setup color input handlers
    setupColorInputs();

    // Setup live preview
    setupSettingsPreview();
}


// Placeholder for categories page - actual implementation is in admin-categories.blade.php
// This function will be overridden when the blade view loads
let showCategoriesPageLoaded = false;
const originalShowCategoriesPage = typeof showCategoriesPage !== 'undefined' ? showCategoriesPage : null;

// Wait for admin-categories.blade.php to load and define showCategoriesPage
setTimeout(() => {
    if (typeof showCategoriesPage === 'function') {
        showCategoriesPageLoaded = true;
        console.log('Categories page function loaded successfully');
    }
}, 100);

// Load Footer Management Page
function loadFooterPage() {
    document.getElementById('page-content').innerHTML = `
        <div class="admin-page">
            <div class="page-header">
                <div>
                    <h1>Quản Lý Footer</h1>
                    <p class="page-subtitle">Cập nhật thông tin footer website</p>
                </div>
                <button class="btn btn-primary" onclick="saveFooterSettings()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17,21 17,13 7,13 7,21"></polyline>
                        <polyline points="7,3 7,8 15,8"></polyline>
                    </svg>
                    Lưu Thay Đổi
                </button>
            </div>

            <div class="form-container" style="max-width: 800px;">
                <form id="footerSettingsForm">
                    <div class="form-grid">
                        <!-- Thông tin chung -->
                        <div class="form-section">
                            <h3 class="section-title">📄 Thông Tin Chung</h3>
                            
                            <div class="form-group">
                                <label for="siteName">Tên Website</label>
                                <input type="text" id="siteName" name="site_name" placeholder="VD: ShopPro">
                            </div>

                            <div class="form-group">
                                <label for="footerAbout">Mô Tả Website</label>
                                <textarea id="footerAbout" name="footer_about" placeholder="Mô tả ngắn về website của bạn..." rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="copyrightText">Copyright Text</label>
                                <input type="text" id="copyrightText" name="copyright_text" placeholder="© 2026 ShopPro | Made with ❤️">
                            </div>
                        </div>

                        <!-- Thông tin liên hệ -->
                        <div class="form-section">
                            <h3 class="section-title">📞 Thông Tin Liên Hệ</h3>
                            
                            <div class="form-group">
                                <label for="address">Địa Chỉ</label>
                                <input type="text" id="address" name="address" placeholder="123 Đường ABC, Quận XYZ, TP.HCM">
                            </div>

                            <div class="form-group">
                                <label for="phone">Số Điện Thoại</label>
                                <input type="text" id="phone" name="phone" placeholder="0123 456 789">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="contact@shoppro.com">
                            </div>

                            <div class="form-group">
                                <label for="workingHours">Giờ Làm Việc</label>
                                <input type="text" id="workingHours" name="working_hours" placeholder="8:00 - 22:00 (Thứ 2 - Chủ Nhật)">
                            </div>
                        </div>

                        <!-- Mạng xã hội -->
                        <div class="form-section">
                            <h3 class="section-title">🌐 Mạng Xã Hội</h3>
                            
                            <div class="form-group">
                                <label for="socialFacebook">Facebook URL</label>
                                <input type="url" id="socialFacebook" name="social_facebook" placeholder="https://facebook.com/yourpage">
                            </div>

                            <div class="form-group">
                                <label for="socialInstagram">Instagram URL</label>
                                <input type="url" id="socialInstagram" name="social_instagram" placeholder="https://instagram.com/yourpage">
                            </div>

                            <div class="form-group">
                                <label for="socialTiktok">TikTok URL</label>
                                <input type="url" id="socialTiktok" name="social_tiktok" placeholder="https://tiktok.com/@yourpage">
                            </div>

                            <div class="form-group">
                                <label for="socialYoutube">YouTube URL</label>
                                <input type="url" id="socialYoutube" name="social_youtube" placeholder="https://youtube.com/c/yourchannel">
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="form-section">
                        <h3 class="section-title">👁️ Xem Trước Footer</h3>
                        <div id="footerPreview" class="footer-preview">
                            <div class="footer-preview-container">
                                <div class="footer-grid">
                                    <div class="footer-col">
                                        <div class="footer-title" id="previewSiteName">ShopPro</div>
                                        <p id="previewAbout">Website bán hàng chuyên nghiệp</p>
                                    </div>
                                    <div class="footer-col">
                                        <div class="footer-title">Liên hệ</div>
                                        <p><span>Địa chỉ:</span> <span id="previewAddress">123 Đường ABC, TP.HCM</span></p>
                                        <p><span>Hotline:</span> <span id="previewPhone">0123 456 789</span></p>
                                        <p><span>Email:</span> <span id="previewEmail">contact@example.com</span></p>
                                        <p><span>Giờ làm việc:</span> <span id="previewHours">8:00 - 22:00</span></p>
                                    </div>
                                    <div class="footer-col">
                                        <div class="footer-title">Kết nối</div>
                                        <div class="footer-social">
                                            <span id="previewFacebook">📘 Facebook</span>
                                            <span id="previewInstagram">📷 Instagram</span>
                                            <span id="previewTiktok">🎵 TikTok</span>
                                            <span id="previewYoutube">📺 YouTube</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-bottom" id="previewCopyright">© 2026 ShopPro | Made with ❤️</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Status Messages -->
            <div id="footerMessages" style="margin-top: 20px;"></div>
        </div>
    `;

    // Load existing settings
    loadFooterSettingsData();

    // Setup real-time preview
    setupFooterPreview();
}

// Load existing footer settings
async function loadFooterSettingsData() {
    try {
        const response = await fetch('/api/settings/footer');
        if (!response.ok) {
            throw new Error('Failed to load settings');
        }

        const data = await response.json();

        // Populate form fields
        document.getElementById('siteName').value = data.site_name || '';
        document.getElementById('footerAbout').value = data.footer_about || '';
        document.getElementById('copyrightText').value = data.copyright_text || '';
        document.getElementById('address').value = data.address || '';
        document.getElementById('phone').value = data.phone || '';
        document.getElementById('email').value = data.email || '';
        document.getElementById('workingHours').value = data.working_hours || '';
        document.getElementById('socialFacebook').value = data.social_facebook || '';
        document.getElementById('socialInstagram').value = data.social_instagram || '';
        document.getElementById('socialTiktok').value = data.social_tiktok || '';
        document.getElementById('socialYoutube').value = data.social_youtube || '';

        // Update preview
        updateFooterPreview();

    } catch (error) {
        console.error('Error loading footer settings:', error);
        showFooterMessage('Không thể tải cài đặt hiện tại', 'error');
    }
}

// Setup real-time preview
function setupFooterPreview() {
    const inputs = ['siteName', 'footerAbout', 'copyrightText', 'address', 'phone', 'email', 'workingHours', 'socialFacebook', 'socialInstagram', 'socialTiktok', 'socialYoutube'];

    inputs.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updateFooterPreview);
        }
    });
}

// Update footer preview
function updateFooterPreview() {
    const siteName = document.getElementById('siteName').value || 'ShopPro';
    const about = document.getElementById('footerAbout').value || 'Website bán hàng chuyên nghiệp';
    const copyright = document.getElementById('copyrightText').value || '© 2026 ShopPro | Made with ❤️';
    const address = document.getElementById('address').value || '123 Đường ABC, TP.HCM';
    const phone = document.getElementById('phone').value || '0123 456 789';
    const email = document.getElementById('email').value || 'contact@example.com';
    const hours = document.getElementById('workingHours').value || '8:00 - 22:00';

    document.getElementById('previewSiteName').textContent = siteName;
    document.getElementById('previewAbout').textContent = about;
    document.getElementById('previewCopyright').textContent = copyright;
    document.getElementById('previewAddress').textContent = address;
    document.getElementById('previewPhone').textContent = phone;
    document.getElementById('previewEmail').textContent = email;
    document.getElementById('previewHours').textContent = hours;

    // Update social links
    const facebook = document.getElementById('socialFacebook').value;
    const instagram = document.getElementById('socialInstagram').value;
    const tiktok = document.getElementById('socialTiktok').value;
    const youtube = document.getElementById('socialYoutube').value;

    document.getElementById('previewFacebook').style.display = facebook ? 'block' : 'none';
    document.getElementById('previewInstagram').style.display = instagram ? 'block' : 'none';
    document.getElementById('previewTiktok').style.display = tiktok ? 'block' : 'none';
    document.getElementById('previewYoutube').style.display = youtube ? 'block' : 'none';
}

// Save footer settings
async function saveFooterSettings() {
    try {
        const formData = {
            site_name: document.getElementById('siteName').value,
            footer_about: document.getElementById('footerAbout').value,
            copyright_text: document.getElementById('copyrightText').value,
            address: document.getElementById('address').value,
            phone: document.getElementById('phone').value,
            email: document.getElementById('email').value,
            working_hours: document.getElementById('workingHours').value,
            social_facebook: document.getElementById('socialFacebook').value,
            social_instagram: document.getElementById('socialInstagram').value,
            social_tiktok: document.getElementById('socialTiktok').value,
            social_youtube: document.getElementById('socialYoutube').value
        };

        const response = await fetch('/api/settings/footer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            throw new Error('Failed to save settings');
        }

        const result = await response.json();
        showFooterMessage('✅ Cài đặt footer đã được lưu thành công!', 'success');

        // Reload footer on current page
        if (typeof loadFooterSettings === 'function') {
            setTimeout(loadFooterSettings, 1000);
        }

    } catch (error) {
        console.error('Error saving footer settings:', error);
        showFooterMessage('❌ Lỗi khi lưu cài đặt. Vui lòng thử lại!', 'error');
    }
}

// Show footer message
function showFooterMessage(message, type) {
    const messagesDiv = document.getElementById('footerMessages');
    if (!messagesDiv) return;

    const messageEl = document.createElement('div');
    messageEl.className = `alert alert-${type}`;
    messageEl.style.cssText = `
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 12px;
        background: ${type === 'success' ? '#dcfce7' : '#fee2e2'};
        border: 1px solid ${type === 'success' ? '#bbf7d0' : '#fecaca'};
        color: ${type === 'success' ? '#166534' : '#dc2626'};
        font-weight: 500;
    `;
    messageEl.textContent = message;

    messagesDiv.appendChild(messageEl);

    // Auto remove after 5 seconds
    setTimeout(() => {
        messageEl.remove();
    }, 5000);
}

// ========== WEBSITE SETTINGS FUNCTIONS ==========
// Setup color input handlers
function setupColorInputs() {
    const colorInputs = [
        'primaryColor', 'secondaryColor', 'backgroundColor', 'cardColor',
        'textColor', 'mutedColor', 'successColor', 'errorColor', 'warningColor', 'accentColor'
    ];

    colorInputs.forEach(colorId => {
        const colorInput = document.getElementById(colorId);
        const textInput = document.getElementById(colorId + 'Text');

        if (colorInput && textInput) {
            // Update text when color changes
            colorInput.addEventListener('input', function () {
                textInput.value = this.value.toUpperCase();
                updatePreview();
            });

            // Update color when text changes
            textInput.addEventListener('input', function () {
                if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                    colorInput.value = this.value;
                    updatePreview();
                }
            });
        }
    });
}

// Setup live preview
function setupSettingsPreview() {
    const websiteName = document.getElementById('websiteName');
    const websiteTagline = document.getElementById('websiteTagline');

    if (websiteName) {
        websiteName.addEventListener('input', updatePreview);
    }
    if (websiteTagline) {
        websiteTagline.addEventListener('input', updatePreview);
    }

    // Initial preview update
    updatePreview();
}

// Update live preview
function updatePreview() {
    const websiteName = document.getElementById('websiteName')?.value || 'ShopPro VIP';
    const websiteTagline = document.getElementById('websiteTagline')?.value || 'Website bán hàng VIP';
    const primaryColor = document.getElementById('primaryColor')?.value || '#7851A9';
    const secondaryColor = document.getElementById('secondaryColor')?.value || '#A583C7';
    const accentColor = document.getElementById('accentColor')?.value || '#F39C12';
    const backgroundColor = document.getElementById('backgroundColor')?.value || '#f5f3f8';
    const cardColor = document.getElementById('cardColor')?.value || '#ffffff';

    // Update preview elements
    const previewLogo = document.getElementById('previewLogo');
    const previewTitle = document.getElementById('previewTitle');
    const previewBtn = document.getElementById('previewBtn');
    const previewAccent = document.getElementById('previewAccent');
    const previewContainer = document.querySelector('.preview-container');

    if (previewLogo) {
        previewLogo.textContent = websiteName;
        previewLogo.style.color = 'white';
    }

    if (previewTitle) {
        previewTitle.textContent = websiteTagline;
    }

    if (previewBtn) {
        previewBtn.style.background = `linear-gradient(135deg, ${primaryColor}, ${secondaryColor})`;
    }

    if (previewAccent) {
        previewAccent.style.backgroundColor = accentColor;
    }

    if (previewContainer) {
        previewContainer.style.background = cardColor;
        previewContainer.parentElement.style.background = backgroundColor;

        // Update preview header background
        const previewHeader = document.querySelector('.preview-header');
        if (previewHeader) {
            previewHeader.style.background = `linear-gradient(135deg, ${primaryColor}, ${secondaryColor})`;
        }
    }
}

// Load existing website settings
async function loadWebsiteSettings() {
    try {
        const response = await fetch('/api/settings/website');
        if (response.ok) {
            const data = await response.json();

            // Populate form fields with correct defaults
            document.getElementById('websiteName').value = data.website_name || 'ShopPro VIP';
            document.getElementById('websiteTagline').value = data.website_tagline || 'Website bán hàng VIP';

            // Primary colors - ensure correct defaults
            const primaryColor = data.primary_color || '#7851A9';
            const secondaryColor = data.secondary_color || '#A583C7';

            document.getElementById('primaryColor').value = primaryColor;
            document.getElementById('primaryColorText').value = primaryColor.toUpperCase();
            document.getElementById('secondaryColor').value = secondaryColor;
            document.getElementById('secondaryColorText').value = secondaryColor.toUpperCase();

            // Background colors
            const backgroundColor = data.background_color || '#f5f3f8';
            const cardColor = data.card_color || '#ffffff';

            document.getElementById('backgroundColor').value = backgroundColor;
            document.getElementById('backgroundColorText').value = backgroundColor.toUpperCase();
            document.getElementById('cardColor').value = cardColor;
            document.getElementById('cardColorText').value = cardColor.toUpperCase();

            // Text colors
            const textColor = data.text_color || '#2d1b47';
            const mutedColor = data.muted_color || '#6b7280';

            document.getElementById('textColor').value = textColor;
            document.getElementById('textColorText').value = textColor.toUpperCase();
            document.getElementById('mutedColor').value = mutedColor;
            document.getElementById('mutedColorText').value = mutedColor.toUpperCase();

            // Status colors
            const successColor = data.success_color || '#10b981';
            const errorColor = data.error_color || '#ef4444';
            const warningColor = data.warning_color || '#f59e0b';
            const accentColor = data.accent_color || '#F39C12';

            document.getElementById('successColor').value = successColor;
            document.getElementById('successColorText').value = successColor.toUpperCase();
            document.getElementById('errorColor').value = errorColor;
            document.getElementById('errorColorText').value = errorColor.toUpperCase();
            document.getElementById('warningColor').value = warningColor;
            document.getElementById('warningColorText').value = warningColor.toUpperCase();
            document.getElementById('accentColor').value = accentColor;
            document.getElementById('accentColorText').value = accentColor.toUpperCase();

            updatePreview();

            console.log('Loaded website settings:', {
                primary: primaryColor,
                secondary: secondaryColor,
                accent: accentColor
            });
        }
    } catch (error) {
        console.error('Error loading website settings:', error);
        // Load defaults on error
        loadDefaultSettings();
    }
}

// Load default settings
function loadDefaultSettings() {
    document.getElementById('websiteName').value = 'ShopPro VIP';
    document.getElementById('websiteTagline').value = 'Website bán hàng VIP';

    // Set all color inputs to default values
    const colorDefaults = {
        'primaryColor': '#7851A9',
        'secondaryColor': '#A583C7',
        'backgroundColor': '#f5f3f8',
        'cardColor': '#ffffff',
        'textColor': '#2d1b47',
        'mutedColor': '#6b7280',
        'successColor': '#10b981',
        'errorColor': '#ef4444',
        'warningColor': '#f59e0b',
        'accentColor': '#F39C12'
    };

    Object.entries(colorDefaults).forEach(([key, value]) => {
        document.getElementById(key).value = value;
        document.getElementById(key + 'Text').value = value.toUpperCase();
    });

    updatePreview();
    console.log('Loaded default settings');
}

// Save website settings
async function saveWebsiteSettings() {
    const settingsData = {
        website_name: document.getElementById('websiteName').value,
        website_tagline: document.getElementById('websiteTagline').value,
        primary_color: document.getElementById('primaryColor').value,
        secondary_color: document.getElementById('secondaryColor').value,
        background_color: document.getElementById('backgroundColor').value,
        card_color: document.getElementById('cardColor').value,
        text_color: document.getElementById('textColor').value,
        muted_color: document.getElementById('mutedColor').value,
        success_color: document.getElementById('successColor').value,
        error_color: document.getElementById('errorColor').value,
        warning_color: document.getElementById('warningColor').value,
        accent_color: document.getElementById('accentColor').value
    };

    try {
        const response = await fetch('/api/settings/website', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(settingsData)
        });

        if (response.ok) {
            const result = await response.json();
            showSettingsMessage('✅ Cài đặt đã được lưu thành công!', 'success');

            // Apply changes to current page
            document.documentElement.style.setProperty('--color-primary', settingsData.primary_color);
            document.documentElement.style.setProperty('--color-secondary', settingsData.secondary_color);
            document.documentElement.style.setProperty('--color-accent', settingsData.accent_color);

            // Update page title if needed
            if (settingsData.website_name) {
                document.title = `Admin Dashboard - ${settingsData.website_name}`;
            }
        } else {
            throw new Error('Failed to save settings');
        }
    } catch (error) {
        console.error('Error saving settings:', error);
        showSettingsMessage('❌ Có lỗi xảy ra khi lưu cài đặt!', 'error');
    }
}


// Show settings message
function showSettingsMessage(message, type) {
    const messagesContainer = document.getElementById('settingsMessages');
    if (!messagesContainer) return;

    messagesContainer.innerHTML = `
        <div class="settings-message ${type}">
            ${message}
        </div>
    `;

    // Auto hide after 3 seconds
    setTimeout(() => {
        messagesContainer.innerHTML = '';
    }, 3000);
}

