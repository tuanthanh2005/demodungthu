@extends('auth.layout')

@section('title', 'Đăng Nhập - ShopPro VIP')

@section('content')
<div class="auth-header">
    <div class="auth-logo">ShopPro VIP</div>
    <p class="auth-subtitle">Đăng nhập vào tài khoản của bạn</p>
</div>

@if(session('success'))
<div class="success-message">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="error-message">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <input type="email" id="email" name="email" class="form-input @error('email') error @enderror" 
               value="{{ old('email') }}" placeholder="Email" required>
        @error('email')<span class="error-text">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <input type="password" id="password" name="password" class="form-input @error('password') error @enderror"
               placeholder="Mật khẩu" required>
        @error('password')<span class="error-text">{{ $message }}</span>@enderror
    </div>

    <div class="checkbox-group">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Ghi nhớ đăng nhập</label>
    </div>

    <div class="auth-buttons">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i> Đăng nhập
        </button>
        <a href="/register" class="btn btn-link">
            <i class="fas fa-user-plus"></i> Tạo tài khoản
        </a>
        <a href="/forgot-password" class="btn btn-link">
            <i class="fas fa-key"></i> Quên mật khẩu?
        </a>
        <a href="/" class="btn btn-link">
            <i class="fas fa-home"></i> Về trang chủ
        </a>
    </div>
</form>
@endsection