@'
@extends('layouts.app')

@section('title', 'Đăng nhập')
@section('meta_description', 'Trang đăng nhập tài khoản.')

@section('content')
    <section class="py-5">
        <div class="container" style="max-width: 520px;">
            <h1 class="mb-3">Đăng nhập</h1>
            <p class="text-muted">Chào mừng bạn quay lại. Vui lòng đăng nhập để tiếp tục.</p>

            <form class="mt-4" action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="you@email.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <a href="{{ url('/forgot-password') }}" class="text-decoration-none">Quên mật khẩu?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            </form>

            <div class="mt-3 text-center">
                <span class="text-muted">Chưa có tài khoản?</span>
                <a href="/register" class="text-decoration-none">Đăng ký</a>
            </div>
        </div>
    </section>
@endsection
