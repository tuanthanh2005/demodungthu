@extends('auth.layout')

@section('title', 'Đăng Ký - ShopPro VIP')

@section('content')
<div class="auth-header">
    <div class="auth-logo">ShopPro VIP</div>
    <p class="auth-subtitle">Tạo tài khoản mới</p>
</div>

@if(session('success'))
<div class="success-message">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <input type="text" id="name" name="name" class="form-input @error('name') error @enderror" 
               value="{{ old('name') }}" placeholder="Họ và tên" required>
        @error('name')<span class="error-text">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <input type="email" id="email" name="email" class="form-input @error('email') error @enderror" 
               value="{{ old('email') }}" placeholder="Email" required>
        @error('email')<span class="error-text">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <input type="password" id="password" name="password" class="form-input @error('password') error @enderror"
               placeholder="Mật khẩu (8+ ký tự)" required>
        @error('password')<span class="error-text">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
               placeholder="Xác nhận mật khẩu" required>
    </div>

    <div class="auth-buttons">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Đăng ký
        </button>
        <a href="/login" class="btn btn-link">
            <i class="fas fa-sign-in-alt"></i> Đã có tài khoản?
        </a>
        <a href="/" class="btn btn-link">
            <i class="fas fa-home"></i> Về trang chủ
        </a>
    </div>
</form>
@endsection