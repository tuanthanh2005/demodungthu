<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh Toán - ShopPro VIP</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #7851A9;
            --secondary: #a583c7;
            --dark: #2d1b47;
            --light: #ffffff;
            --bg-light: #f5f3f8;
            --success: #4CAF50;
            --error: #f44336;
            --warning: #ff9800;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .back-btn {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .back-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--bg-light);
        }

        .footer {
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #2d1b47, #4a3066);
            border-top: 3px solid #7851A9;
            text-align: center;
            color: white;
            margin-top: 60px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .form-label .required {
            color: var(--error);
        }

        .form-input {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(120, 81, 169, 0.1);
        }

        .form-input.error {
            border-color: var(--error);
        }

        .error-message {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid var(--bg-light);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .item-price {
            color: var(--primary);
            font-weight: 700;
        }

        .item-quantity {
            color: #666;
            font-size: 0.875rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--bg-light);
        }

        .summary-row.total {
            border-top: 2px solid var(--dark);
            border-bottom: none;
            margin-top: 1rem;
            padding-top: 1rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.125rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(120, 81, 169, 0.3);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
        }

        .empty-cart-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-cart-text {
            color: #666;
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .loading.show {
            display: block;
        }

        .spinner {
            border: 4px solid var(--bg-light);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .success-message {
            background: var(--success);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 1rem;
            display: none;
        }

        .success-message.show {
            display: block;
        }

        /* QR Payment Modal */
        .qr-modal {
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
        }

        .qr-modal.show {
            display: flex;
        }

        .qr-modal-content {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            max-width: 900px;
            width: 100%;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .qr-modal-header {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--bg-light);
        }

        .qr-modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .qr-modal-subtitle {
            color: #666;
            font-size: 0.875rem;
        }

        .qr-modal-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        .qr-code-container {
            text-align: center;
            padding: 1.5rem;
            background: var(--bg-light);
            border-radius: 15px;
        }

        .qr-code-image {
            max-width: 280px;
            width: 100%;
            height: auto;
            border-radius: 10px;
            background: white;
            padding: 1rem;
        }

        .qr-info {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
        }

        .qr-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            align-items: center;
            gap: 1rem;
        }

        .qr-info-row:last-child {
            margin-bottom: 0;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 1.15rem;
            font-weight: 700;
        }

        .qr-info-label {
            opacity: 0.9;
            white-space: nowrap;
        }

        .qr-info-value {
            font-weight: 600;
            text-align: right;
        }

        .qr-instructions {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .qr-instructions-title {
            font-weight: 700;
            color: #856404;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qr-instructions ol {
            margin-left: 1.5rem;
            color: #856404;
            font-size: 0.9rem;
        }

        .qr-instructions li {
            margin-bottom: 0.35rem;
        }

        .qr-modal-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .qr-btn {
            flex: 1;
            padding: 0.875rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .qr-btn-confirm {
            background: var(--success);
            color: white;
        }

        .qr-btn-confirm:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .qr-btn-cancel {
            background: #e0e0e0;
            color: var(--dark);
        }

        .qr-btn-cancel:hover {
            background: #d0d0d0;
        }

        .qr-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #e0e0e0;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .qr-close:hover {
            background: #d0d0d0;
            transform: rotate(90deg);
        }

        @media (max-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 1rem;
            }

            .card {
                padding: 1.5rem;
            }

            .qr-modal-content {
                padding: 1.5rem;
                max-width: 95%;
            }

            .qr-modal-body {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .qr-code-image {
                max-width: 250px;
            }

            .qr-modal-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
           <a href="/" class="logo text-decoration-none">⚡ SHOPPRO VIP</a>
            <a href="/" class="back-btn">← Quay lại mua sắm</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div id="successMessage" class="success-message"></div>

        <div id="checkoutContent">
            <div class="checkout-grid">
                <!-- Form thông tin -->
                <div class="card">
                    <h2 class="card-title">Thông Tin Giao Hàng</h2>
                    <form id="checkoutForm">
                        <div class="form-group">
                            <label class="form-label">
                                Họ và tên <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                id="customerName"
                                class="form-input" 
                                placeholder="Nhập họ và tên"
                                required
                            >
                            <div class="error-message" id="nameError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Email <span class="required">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="customer_email" 
                                id="customerEmail"
                                class="form-input" 
                                placeholder="example@email.com"
                                required
                            >
                            <div class="error-message" id="emailError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Số điện thoại <span class="required">*</span>
                            </label>
                            <input 
                                type="tel" 
                                name="customer_phone" 
                                id="customerPhone"
                                class="form-input" 
                                placeholder="0912345678"
                                required
                            >
                            <div class="error-message" id="phoneError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Địa chỉ giao hàng <span class="required">*</span>
                            </label>
                            <textarea 
                                name="customer_address" 
                                id="customerAddress"
                                class="form-input" 
                                rows="3"
                                placeholder="Nhập địa chỉ chi tiết"
                                required
                            ></textarea>
                            <div class="error-message" id="addressError"></div>
                        </div>
                    </form>
                </div>

                <!-- Giỏ hàng & tổng kết -->
                <div>
                    <div class="card">
                        <h2 class="card-title">Đơn Hàng Của Bạn</h2>
                        
                        <div id="cartItems">
                            <!-- Cart items will be rendered here -->
                        </div>

                        <div id="emptyCart" class="empty-cart" style="display: none;">
                            <div class="empty-cart-icon">🛒</div>
                            <div class="empty-cart-text">Giỏ hàng của bạn đang trống</div>
                            <a href="/" class="back-btn">Tiếp tục mua sắm</a>
                            <button onclick="clearCart()" class="back-btn" style="margin-top: 1rem; background: #ff4444;">🗑️ Xóa giỏ hàng</button>
                        </div>

                        <div id="cartSummary" style="display: none;">
                            <div class="summary-row">
                                <span>Tạm tính:</span>
                                <span id="subtotal">₫0</span>
                            </div>
                            <div class="summary-row">
                                <span>Phí vận chuyển:</span>
                                <span id="shipping">Miễn phí</span>
                            </div>
                            <div class="summary-row total">
                                <span>Tổng cộng:</span>
                                <span id="total">₫0</span>
                            </div>

                            <button type="button" class="submit-btn" id="submitOrder">
                                Đặt Hàng Ngay
                            </button>
                        </div>

                        <div id="loading" class="loading">
                            <div class="spinner"></div>
                            <p style="margin-top: 1rem;">Đang xử lý đơn hàng...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Payment Modal -->
    <div id="qrModal" class="qr-modal">
        <div class="qr-modal-content">
            <button class="qr-close" onclick="closeQRModal()">×</button>
            
            <div class="qr-modal-header">
                <div class="qr-modal-title">💳 Thanh Toán QR Code</div>
                <div class="qr-modal-subtitle">Quét mã QR để thanh toán đơn hàng</div>
            </div>

            <div class="qr-modal-body">
                <!-- Left: QR Code -->
                <div class="qr-code-container">
                    <img id="qrCodeImage" src="" alt="QR Code" class="qr-code-image">
                </div>

                <!-- Right: Info & Instructions -->
                <div>
                    <div class="qr-info">
                        <div class="qr-info-row">
                            <span class="qr-info-label">Ngân hàng:</span>
                            <span class="qr-info-value">MB Bank</span>
                        </div>
                        <div class="qr-info-row">
                            <span class="qr-info-label">Số tài khoản:</span>
                            <span class="qr-info-value">0783704196</span>
                        </div>
                        <div class="qr-info-row">
                            <span class="qr-info-label">Nội dung:</span>
                            <span class="qr-info-value" id="qrContent"></span>
                        </div>
                        <div class="qr-info-row">
                            <span class="qr-info-label">Số tiền:</span>
                            <span class="qr-info-value" id="qrAmount"></span>
                        </div>
                    </div>

                    <div class="qr-instructions">
                        <div class="qr-instructions-title">
                            <span>ℹ️</span>
                            <span>Hướng dẫn thanh toán:</span>
                        </div>
                        <ol>
                            <li>Mở app ngân hàng của bạn</li>
                            <li>Chọn quét mã QR</li>
                            <li>Quét mã QR bên trái</li>
                            <li>Kiểm tra thông tin và xác nhận</li>
                            <li>Sau khi thanh toán, nhấn "Đã Thanh Toán"</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="qr-modal-buttons">
                <button class="qr-btn qr-btn-confirm" onclick="confirmPayment()">
                    ✓ Đã Thanh Toán
                </button>
                <button class="qr-btn qr-btn-cancel" onclick="closeQRModal()">
                    Hủy
                </button>
            </div>
        </div>
    </div>

    <!-- Dynamic Footer -->
    <footer class="dynamic-footer" id="dynamicFooter">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="/" class="logo text-decoration-none">⚡ SHOPPRO VIP</a>
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
        }
    </style>


    <script>
        // ========== CHECKOUT PAGE SCRIPT ==========
        let cart = [];
        let isSubmitting = false;

        // Load cart from localStorage
        function loadCart() {
            try {
                // Try loading from 'cart' key first (used by main site)
                const savedCart = localStorage.getItem('cart');
                if (savedCart) {
                    const parsed = JSON.parse(savedCart);
                    cart = Array.isArray(parsed) ? parsed.map(item => ({
                        id: item.id,
                        name: item.name,
                        price: item.price,
                        image: item.image || item.main_image,
                        quantity: item.quantity || 1
                    })) : [];
                    console.log('✅ Cart loaded from localStorage:', cart.length, 'items');
                    console.log('Cart data:', cart);
                } else {
                    // Fallback to 'shoppingCart' key
                    const altCart = localStorage.getItem('shoppingCart');
                    if (altCart) {
                        cart = JSON.parse(altCart);
                        console.log('✅ Cart loaded from shoppingCart key:', cart.length, 'items');
                    } else {
                        cart = [];
                        console.log('⚠️ No cart found in localStorage');
                    }
                }
                renderCart();
            } catch (error) {
                console.error('❌ Error loading cart:', error);
                cart = [];
                renderCart();
            }
        }

        // Clear cart
        function clearCart() {
            if (confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) {
                localStorage.removeItem('cart');
                localStorage.removeItem('shoppingCart');
                cart = [];
                renderCart();
                alert('✅ Đã xóa giỏ hàng! Vui lòng quay về trang chủ để thêm sản phẩm mới.');
            }
        }

        // Render cart items
        function renderCart() {
            const cartItemsDiv = document.getElementById('cartItems');
            const emptyCartDiv = document.getElementById('emptyCart');
            const cartSummary = document.getElementById('cartSummary');

            if (!cart || cart.length === 0) {
                cartItemsDiv.innerHTML = '';
                emptyCartDiv.style.display = 'block';
                cartSummary.style.display = 'none';
                return;
            }

            emptyCartDiv.style.display = 'none';
            cartSummary.style.display = 'block';

            // Render items
            cartItemsDiv.innerHTML = cart.map(item => {
                const quantity = item.quantity || 1;
                const price = parseFloat(item.price) || 0;
                const itemTotal = price * quantity;
                const imageUrl = item.main_image || item.image || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80';

                return `
                    <div class="cart-item">
                        <img src="${imageUrl}" alt="${item.name}" class="item-image" onerror="this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=400&fit=crop&q=80'">
                        <div class="item-info">
                            <div class="item-name">${item.name}</div>
                            <div class="item-quantity">Số lượng: ${quantity}</div>
                            <div class="item-price">₫${formatNumber(itemTotal)}</div>
                        </div>
                    </div>
                `;
            }).join('');

            // Calculate totals
            const subtotal = cart.reduce((sum, item) => {
                const price = parseFloat(item.price) || 0;
                const quantity = parseInt(item.quantity) || 1;
                return sum + (price * quantity);
            }, 0);

            document.getElementById('subtotal').textContent = `₫${formatNumber(subtotal)}`;
            document.getElementById('total').textContent = `₫${formatNumber(subtotal)}`;
        }

        // Format number
        function formatNumber(num) {
            return new Intl.NumberFormat('vi-VN').format(num);
        }

        // Validate form
        function validateForm() {
            let isValid = true;

            // Reset errors
            document.querySelectorAll('.form-input').forEach(input => {
                input.classList.remove('error');
            });
            document.querySelectorAll('.error-message').forEach(msg => {
                msg.classList.remove('show');
            });

            // Name validation
            const name = document.getElementById('customerName').value.trim();
            if (!name) {
                showError('customerName', 'nameError', 'Vui lòng nhập họ tên');
                isValid = false;
            } else if (name.length < 3) {
                showError('customerName', 'nameError', 'Họ tên phải có ít nhất 3 ký tự');
                isValid = false;
            }

            // Email validation
            const email = document.getElementById('customerEmail').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email) {
                showError('customerEmail', 'emailError', 'Vui lòng nhập email');
                isValid = false;
            } else if (!emailRegex.test(email)) {
                showError('customerEmail', 'emailError', 'Email không hợp lệ');
                isValid = false;
            }

            // Phone validation
            const phone = document.getElementById('customerPhone').value.trim();
            const phoneRegex = /^[0-9]{10,11}$/;
            if (!phone) {
                showError('customerPhone', 'phoneError', 'Vui lòng nhập số điện thoại');
                isValid = false;
            } else if (!phoneRegex.test(phone)) {
                showError('customerPhone', 'phoneError', 'Số điện thoại không hợp lệ (10-11 số)');
                isValid = false;
            }

            // Address validation
            const address = document.getElementById('customerAddress').value.trim();
            if (!address) {
                showError('customerAddress', 'addressError', 'Vui lòng nhập địa chỉ');
                isValid = false;
            } else if (address.length < 10) {
                showError('customerAddress', 'addressError', 'Địa chỉ phải có ít nhất 10 ký tự');
                isValid = false;
            }

            return isValid;
        }

        // Show error
        function showError(inputId, errorId, message) {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);
            input.classList.add('error');
            error.textContent = message;
            error.classList.add('show');
        }

        // ========== TELEGRAM NOTIFICATION ==========
        
        // Send notification to Telegram
        async function sendTelegramNotification(orderId, orderData) {
            try {
                const botToken = '8187679739:AAEbsH_miAXOOepBwsB9p7oraCqQdD4jIXI';
                const chatId = '8199725778';
                
                // Format items list
                const itemsList = orderData.items.map((item, index) => {
                    const product = cart.find(p => p.id === item.product_id);
                    const productName = product ? product.name : `Sản phẩm #${item.product_id}`;
                    return `${index + 1}. ${productName}\n   Số lượng: ${item.quantity} x ₫${formatNumber(item.price)} = ₫${formatNumber(item.quantity * item.price)}`;
                }).join('\n\n');
                
                // Create message
                const message = `
🎉 *ĐƠN HÀNG MỚI - ShopPro VIP*

📦 *Mã đơn hàng:* #${orderId}
💰 *Tổng tiền:* ₫${formatNumber(orderData.total)}

👤 *Thông tin khách hàng:*
• Họ tên: ${orderData.customer_name}
• Email: ${orderData.customer_email}
• SĐT: ${orderData.customer_phone}
• Địa chỉ: ${orderData.customer_address}

🛒 *Sản phẩm:*
${itemsList}

💳 *Phương thức:* ${orderData.payment_method === 'bank_transfer' ? 'Chuyển khoản QR' : orderData.payment_method}
🔖 *Mã giao dịch:* ${orderData.payment_reference || 'N/A'}

⏰ *Thời gian:* ${new Date().toLocaleString('vi-VN')}
                `.trim();

                // Send to Telegram
                const telegramUrl = `https://api.telegram.org/bot${botToken}/sendMessage`;
                
                const telegramResponse = await fetch(telegramUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        chat_id: chatId,
                        text: message,
                        parse_mode: 'Markdown'
                    })
                });

                const telegramResult = await telegramResponse.json();
                
                if (telegramResult.ok) {
                    console.log('✅ Telegram notification sent successfully!');
                } else {
                    console.error('❌ Telegram notification failed:', telegramResult);
                }
                
            } catch (error) {
                console.error('❌ Error sending Telegram notification:', error);
                // Don't block the order process if Telegram fails
            }
        }

        // ========== QR PAYMENT FUNCTIONS ==========
        
        // Generate VietQR URL
        function generateVietQRUrl(amount, content) {
            const bankId = 'MB'; // MB Bank
            const accountNo = '0783704196';
            const template = 'compact2'; // hoặc 'print', 'compact'
            const accountName = 'SHOPPRO VIP';
            
            // VietQR API URL
            const baseUrl = 'https://img.vietqr.io/image';
            const qrUrl = `${baseUrl}/${bankId}-${accountNo}-${template}.png?amount=${amount}&addInfo=${encodeURIComponent(content)}&accountName=${encodeURIComponent(accountName)}`;
            
            return qrUrl;
        }

        // Show QR Modal
        async function showQRModal() {
            try {
                // Validate cart
                if (!cart || cart.length === 0) {
                    alert('Giỏ hàng trống!');
                    return;
                }

                // Validate form
                if (!validateForm()) {
                    alert('Vui lòng kiểm tra lại thông tin!');
                    return;
                }

                // Validate products exist in database
                console.log('🔍 Validating products...');
                const productIds = cart.map(item => parseInt(item.id));
                console.log('Product IDs in cart:', productIds);
                
                const validationResponse = await fetch('/api/products');
                const allProducts = await validationResponse.json();
                const validProductIds = allProducts.map(p => p.id);
                
                console.log('Valid product IDs in DB:', validProductIds);
                
                const invalidItems = cart.filter(item => !validProductIds.includes(parseInt(item.id)));
                
                if (invalidItems.length > 0) {
                    console.error('❌ Invalid products found:', invalidItems);
                    alert('Giỏ hàng có sản phẩm không hợp lệ. Vui lòng xóa giỏ hàng và thêm sản phẩm lại!');
                    return;
                }

                // Calculate total
                const total = cart.reduce((sum, item) => {
                    const price = parseFloat(item.price) || 0;
                    const quantity = parseInt(item.quantity) || 1;
                    return sum + (price * quantity);
                }, 0);

                // Generate order ID (timestamp)
                const orderId = 'DH' + Date.now();
                
                // Payment content
                const content = `${orderId} ${document.getElementById('customerName').value.trim()}`;

                // Generate QR URL
                const qrUrl = generateVietQRUrl(total, content);

                // Update modal content
                document.getElementById('qrCodeImage').src = qrUrl;
                document.getElementById('qrContent').textContent = content;
                document.getElementById('qrAmount').textContent = `₫${formatNumber(total)}`;

                // Store order data for later submission
                // Debug cart data
                console.log('🛒 Cart data before creating order:', cart);
                
                const orderItems = cart.map(item => {
                    const orderItem = {
                        product_id: parseInt(item.id),
                        quantity: parseInt(item.quantity) || 1,
                        price: parseFloat(item.price) || 0
                    };
                    console.log('📦 Order item:', orderItem);
                    return orderItem;
                });
                
                console.log('📋 All order items:', orderItems);
                
                window.pendingOrderData = {
                    customer_name: document.getElementById('customerName').value.trim(),
                    customer_email: document.getElementById('customerEmail').value.trim(),
                    customer_phone: document.getElementById('customerPhone').value.trim(),
                    customer_address: document.getElementById('customerAddress').value.trim(),
                    items: orderItems,
                    total: total,
                    payment_method: 'bank_transfer',
                    payment_reference: orderId
                };

                // Show modal
                document.getElementById('qrModal').classList.add('show');

                console.log('QR Modal shown with order:', orderId, 'amount:', total);

            } catch (error) {
                console.error('Error showing QR modal:', error);
                alert('Có lỗi khi tạo mã QR: ' + error.message);
            }
        }

        // Close QR Modal
        function closeQRModal() {
            document.getElementById('qrModal').classList.remove('show');
            
            // Re-enable submit button
            const submitBtn = document.getElementById('submitOrder');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Đặt Hàng Ngay';
            }
            
            isSubmitting = false;
        }

        // Confirm Payment (after user scanned and paid)
        async function confirmPayment() {
            try {
                if (!window.pendingOrderData) {
                    alert('Không tìm thấy thông tin đơn hàng!');
                    return;
                }

                // Close QR modal
                closeQRModal();

                // Show loading
                document.getElementById('loading').classList.add('show');

                console.log('Confirming payment and submitting order:', window.pendingOrderData);

                // Submit order to API
                const response = await fetch('/api/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(window.pendingOrderData)
                }).catch(error => {
                    console.error('Fetch error:', error);
                    throw new Error('Không thể kết nối đến server. Vui lòng kiểm tra kết nối mạng.');
                });

                if (!response) {
                    throw new Error('Không nhận được phản hồi từ server');
                }

                console.log('Response status:', response.status);
                console.log('Response headers:', [...response.headers.entries()]);

                let result;
                try {
                    result = await response.json();
                } catch (jsonError) {
                    console.error('JSON parse error:', jsonError);
                    const text = await response.text();
                    console.error('Response text:', text);
                    throw new Error('Server trả về dữ liệu không hợp lệ');
                }

                // Hide loading
                document.getElementById('loading').classList.remove('show');

                if (response.ok && result.success) {
                    // Success!
                    console.log('Order created successfully:', result);

                    // Send Telegram notification
                    sendTelegramNotification(result.order_id, window.pendingOrderData);

                    // Clear cart from both possible keys
                    localStorage.removeItem('cart');
                    localStorage.removeItem('shoppingCart');
                    cart = [];

                    // Clear pending order
                    delete window.pendingOrderData;

                    // Show success message
                    const successMsg = document.getElementById('successMessage');
                    successMsg.textContent = `✅ ${result.message} Mã đơn hàng: #${result.order_id}. Cảm ơn bạn đã thanh toán!`;
                    successMsg.classList.add('show');

                    // Hide checkout content
                    document.getElementById('checkoutContent').style.display = 'none';

                    // Redirect after 4 seconds
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 4000);

                } else {
                    // Error
                    console.error('Order creation failed:', result);
                    
                    let errorMessage = result.message || 'Có lỗi xảy ra khi đặt hàng!';
                    
                    if (result.errors) {
                        errorMessage += '\n\n' + Object.values(result.errors).flat().join('\n');
                    }
                    
                    alert('❌ ' + errorMessage);
                }

            } catch (error) {
                console.error('Error confirming payment:', error);
                
                document.getElementById('loading').classList.remove('show');
                
                alert('❌ Có lỗi xảy ra: ' + error.message);
            }
        }

        // Update submit order to show QR modal instead
        async function submitOrder() {
            showQRModal();
        }
        // OLD submit function (kept for reference, not used)
        async function submitOrderDirect() {
            try {
                // Prevent double submission
                if (isSubmitting) {
                    console.log('Already submitting...');
                    return;
                }

                // Validate cart
                if (!cart || cart.length === 0) {
                    alert('Giỏ hàng trống! Vui lòng thêm sản phẩm trước khi đặt hàng.');
                    return;
                }

                // Validate form
                if (!validateForm()) {
                    alert('Vui lòng kiểm tra lại thông tin!');
                    return;
                }

                isSubmitting = true;
                const submitBtn = document.getElementById('submitOrder');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Đang xử lý...';

                // Show loading
                document.getElementById('loading').classList.add('show');

                // Prepare order data
                const orderData = {
                    customer_name: document.getElementById('customerName').value.trim(),
                    customer_email: document.getElementById('customerEmail').value.trim(),
                    customer_phone: document.getElementById('customerPhone').value.trim(),
                    customer_address: document.getElementById('customerAddress').value.trim(),
                    items: cart.map(item => ({
                        product_id: item.id,
                        quantity: parseInt(item.quantity) || 1,
                        price: parseFloat(item.price) || 0
                    })),
                    total: cart.reduce((sum, item) => {
                        const price = parseFloat(item.price) || 0;
                        const quantity = parseInt(item.quantity) || 1;
                        return sum + (price * quantity);
                    }, 0)
                };

                console.log('Submitting order:', orderData);

                // Submit to API
                const response = await fetch('/api/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                });

                const result = await response.json();

                // Hide loading
                document.getElementById('loading').classList.remove('show');

                if (response.ok && result.success) {
                    // Success!
                    console.log('Order created successfully:', result);

                    // Clear cart
                    localStorage.removeItem('shoppingCart');
                    cart = [];

                    // Show success message
                    const successMsg = document.getElementById('successMessage');
                    successMsg.textContent = `✅ ${result.message} Mã đơn hàng: #${result.order_id}`;
                    successMsg.classList.add('show');

                    // Hide checkout content
                    document.getElementById('checkoutContent').style.display = 'none';

                    // Redirect after 3 seconds
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 3000);

                } else {
                    // Error
                    console.error('Order creation failed:', result);
                    
                    let errorMessage = result.message || 'Có lỗi xảy ra khi đặt hàng!';
                    
                    if (result.errors) {
                        errorMessage += '\n\n' + Object.values(result.errors).flat().join('\n');
                    }
                    
                    alert('❌ ' + errorMessage);
                    
                    isSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Đặt Hàng Ngay';
                }

            } catch (error) {
                console.error('Error submitting order:', error);
                
                document.getElementById('loading').classList.remove('show');
                
                alert('❌ Có lỗi xảy ra: ' + error.message);
                
                isSubmitting = false;
                const submitBtn = document.getElementById('submitOrder');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Đặt Hàng Ngay';
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
            loadFooterSettings();
            loadWebsiteSettings();

            // Submit button
            const submitBtn = document.getElementById('submitOrder');
            if (submitBtn) {
                submitBtn.addEventListener('click', submitOrder);
            }

            // Real-time validation
            ['customerName', 'customerEmail', 'customerPhone', 'customerAddress'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('blur', validateForm);
                    element.addEventListener('input', function() {
                        this.classList.remove('error');
                        const errorId = id.replace('customer', '').replace('Name', 'name').replace('Email', 'email').replace('Phone', 'phone').replace('Address', 'address') + 'Error';
                        document.getElementById(errorId).classList.remove('show');
                    });
                }
            });

            // Close modal when clicking outside
            const qrModal = document.getElementById('qrModal');
            if (qrModal) {
                qrModal.addEventListener('click', function(e) {
                    if (e.target === qrModal) {
                        closeQRModal();
                    }
                });
            }
        });

        // Expose functions to global scope for onclick handlers
        window.showQRModal = showQRModal;
        window.closeQRModal = closeQRModal;
        window.confirmPayment = confirmPayment;

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
                    document.getElementById('footerCopyright').innerHTML = settings.copyright_text || settings.copyright || `© ${currentYear} ShopPro VIP | Made with ❤️ by Professional Team`;
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
                        document.title = `Thanh toán - ${settings.website_name}`;
                        
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
