@extends('auth.layout')

@section('title', 'Quên Mật Khẩu - ShopPro VIP')

@section('content')
<div class="auth-header">
    <div class="auth-logo">ShopPro VIP</div>
    <p class="auth-subtitle">Khôi phục mật khẩu của bạn</p>
</div>

@if(session('success'))
<div class="success-message">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<form action="{{ route('forgot-password') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            class="form-input @error('email') error @enderror" 
            value="{{ old('email') }}"
            placeholder="Nhập email đã đăng ký"
            required
        >
        @error('email')
        <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            {{ $message }}
        </div>
        @enderror
    </div>

    <div style="background: rgba(16, 185, 129, 0.1); padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid rgba(16, 185, 129, 0.2);">
        <p style="color: var(--success); font-size: 0.9rem; margin: 0;">
            <i class="fas fa-info-circle"></i>
            Chúng tôi sẽ gửi hướng dẫn đặt lại mật khẩu về email của bạn.
        </p>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-paper-plane"></i>
        Gửi Email Khôi Phục
    </button>
</form>

<div class="divider">
    <span>hoặc</span>
</div>

<a href="/login" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i>
    Quay lại đăng nhập
</a>

<div class="auth-links">
    <a href="/register">Chưa có tài khoản? Đăng ký ngay</a>
    <span style="margin: 0 1rem; color: rgba(45, 27, 71, 0.3);">•</span>
    <a href="/">Về trang chủ</a>
</div>
@endsection