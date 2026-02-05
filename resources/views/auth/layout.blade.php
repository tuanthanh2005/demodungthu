<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopPro VIP')</title>
    
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
            --success: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: var(--dark);
            opacity: 0.7;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(120, 81, 169, 0.2);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(120, 81, 169, 0.1);
        }

        .form-input.error {
            border-color: var(--error);
        }

        .error-text {
            display: block;
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-link {
            background: none !important;
            border: none !important;
            color: var(--primary) !important;
            padding: 0.5rem !important;
            font-size: 0.9rem !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-link:hover {
            text-decoration: underline;
            background: rgba(120, 81, 169, 0.1) !important;
            border-radius: 6px;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(120, 81, 169, 0.1);
            background: white;
        }

        .form-input.error {
            border-color: var(--error);
        }

        .error-message {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-message {
            color: var(--success);
            background: rgba(16, 185, 129, 0.1);
            padding: 0.875rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(120, 81, 169, 0.4);
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

        .auth-links {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(120, 81, 169, 0.1);
        }

        .auth-links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-links a:hover {
            color: var(--secondary);
        }

        .divider {
            margin: 2rem 0;
            text-align: center;
            position: relative;
            color: rgba(45, 27, 71, 0.5);
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(120, 81, 169, 0.2);
        }

        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 1rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        .checkbox-group label {
            font-weight: 400;
            margin: 0;
        }

        @media (max-width: 768px) {
            .auth-container {
                margin: 1rem;
                padding: 2rem;
            }
        }

        /* Loading state */
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Animation */
        .auth-container {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        @yield('content')
    </div>
    
    <script>
        // Add form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (!form) return;
            
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
                }
            });
        });

        // Auto hide success messages
        const successMessages = document.querySelectorAll('.success-message');
        successMessages.forEach(message => {
            setTimeout(() => {
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 300);
            }, 5000);
        });
    </script>
    
    <!-- Load website theme settings -->
    <script>
        async function loadWebsiteSettings() {
            try {
                const response = await fetch('/api/settings/website');
                if (response.ok) {
                    const settings = await response.json();
                    
                    // Update CSS variables
                    if (settings.primary_color) {
                        document.documentElement.style.setProperty('--primary', settings.primary_color);
                    }
                    
                    if (settings.accent_color) {
                        document.documentElement.style.setProperty('--accent', settings.accent_color);
                    }
                    
                    // Update page title and logo
                    if (settings.website_name) {
                        const titleElement = document.querySelector('title');
                        if (titleElement && titleElement.textContent.includes('ShopPro VIP')) {
                            titleElement.textContent = titleElement.textContent.replace('ShopPro VIP', settings.website_name);
                        }
                        
                        // Update auth logo
                        const authLogo = document.querySelector('.auth-logo');
                        if (authLogo) {
                            authLogo.textContent = settings.website_name;
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading website settings:', error);
            }
        }
        
        // Load settings on page load
        document.addEventListener('DOMContentLoaded', loadWebsiteSettings);
    </script>
</body>
</html>