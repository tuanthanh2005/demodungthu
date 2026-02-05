<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tài khoản</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style-new.css">
    <link rel="stylesheet" href="/css/mobile-optimization.css">
    <style>
        :root {
            --primary: #7851A9;
            --primary-dark: #6b439a;
            --primary-light: rgba(120, 81, 169, 0.12);
            --secondary: #a583c7;
            --accent: #B085D2;
            --gradient: linear-gradient(135deg, #7851A9 0%, #9B6BC5 50%, #B085D2 100%);
            --gradient-hover: linear-gradient(135deg, #6b439a 0%, #8f5bb7 50%, #a86fcd 100%);
        }

        body { background: var(--gray-50); }

        .page {
            max-width: 900px;
            margin: 0 auto;
            padding: 16px;
            padding-bottom: calc(var(--mobile-nav-height) + 32px);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 9992;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 14px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--gray-100);
            color: var(--gray-900);
            text-decoration: none;
            font-weight: 700;
        }

        .title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--gray-900);
        }

        .card {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 18px;
            padding: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        .card + .card { margin-top: 12px; }

        .section-title {
            font-weight: 800;
            color: var(--gray-900);
            margin: 0 0 6px;
        }

        .help {
            margin-top: 6px;
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .row {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .row:last-child { border-bottom: 0; }

        .label {
            color: var(--gray-600);
            font-weight: 700;
            padding-top: 10px;
        }

        .input {
            width: 100%;
            height: 44px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.10);
            padding: 0 12px;
            outline: none;
            background: white;
            color: var(--gray-900);
            font-weight: 600;
        }

        .input:focus {
            border-color: rgba(120, 81, 169, 0.45);
            box-shadow: 0 0 0 4px rgba(120, 81, 169, 0.10);
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 14px;
            flex-wrap: wrap;
        }

        .btn {
            border: 0;
            padding: 12px 16px;
            border-radius: 14px;
            cursor: pointer;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary { background: var(--gradient); color: white; }
        .btn-secondary { background: var(--gray-100); color: var(--gray-900); }
        .btn-danger { background: rgba(239, 68, 68, 0.12); color: #ef4444; }

        .alert {
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 12px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: white;
        }

        .alert.success {
            border-color: rgba(16, 185, 129, 0.25);
            background: rgba(16, 185, 129, 0.08);
            color: #065f46;
            font-weight: 800;
        }

        .alert.error {
            border-color: rgba(239, 68, 68, 0.25);
            background: rgba(239, 68, 68, 0.08);
            color: #7f1d1d;
        }

        .error-list { margin: 0; padding-left: 18px; }

        @media (max-width: 520px) {
            .row { grid-template-columns: 1fr; }
            .label { padding-top: 0; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <a class="back-btn" href="/" aria-label="Về trang chủ">←</a>
            <div class="title">TÀI KHOẢN</div>
        </div>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <div style="font-weight: 900; margin-bottom: 8px;">Vui lòng kiểm tra lại:</div>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="card" method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="section-title">Thông tin tài khoản</div>
            <div class="help">Mục này dùng để đổi thông tin cá nhân.</div>

            <div class="row">
                <div class="label">Tên chủ tài khoản</div>
                <div>
                    <input class="input" name="name" value="{{ old('name', auth()->user()->name) }}" required />
                </div>
            </div>

            <div class="row">
                <div class="label">Email</div>
                <div>
                    <input class="input" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
                </div>
            </div>

            <div class="row">
                <div class="label">Số điện thoại</div>
                <div>
                    <input class="input" name="phone" inputmode="tel" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="Ví dụ: 090..." />
                </div>
            </div>

            <div class="row">
                <div class="label">Đổi mật khẩu</div>
                <div>
                    <div class="help" style="margin-top:0;">Chỉ nhập nếu bạn muốn đổi mật khẩu.</div>
                </div>
            </div>

            <div class="row">
                <div class="label">Mật khẩu hiện tại</div>
                <div>
                    <input class="input" type="password" name="current_password" autocomplete="current-password" />
                </div>
            </div>

            <div class="row">
                <div class="label">Mật khẩu mới</div>
                <div>
                    <input class="input" type="password" name="password" autocomplete="new-password" />
                    <div class="help">Tối thiểu 8 ký tự.</div>
                </div>
            </div>

            <div class="row">
                <div class="label">Xác nhận mật khẩu</div>
                <div>
                    <input class="input" type="password" name="password_confirmation" autocomplete="new-password" />
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <a class="btn btn-secondary" href="/products">Xem sản phẩm</a>
                @if((auth()->user()->role ?? null) === 'admin')
                    <a class="btn btn-secondary" href="/admin">Vào quản trị</a>
                @endif
            </div>
        </form>

        <div class="card">
            <div class="section-title">Đăng xuất</div>
            <div class="help">Thoát khỏi tài khoản hiện tại.</div>
            <form action="/logout" method="POST" style="margin: 12px 0 0;">
                @csrf
                <button type="submit" class="btn btn-danger">Đăng xuất</button>
            </form>
        </div>
    </div>
</body>
</html>
