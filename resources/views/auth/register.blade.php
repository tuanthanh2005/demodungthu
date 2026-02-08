@extends('layouts.app')

@section('title', 'Đăng ký')
@section('meta_description', 'Trang tạo tài khoản mới.')

@section('content')
    <section class="py-5">
        <div class="container" style="max-width: 560px;">
            <h1 class="mb-3">Đăng ký</h1>
            <p class="text-muted">Tạo tài khoản mới để mua sắm nhanh hơn.</p>

            <form class="mt-4" action="{{ url('/register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nguyễn Văn A" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="you@email.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Tối thiểu 8 ký tự" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Tạo tài khoản</button>
            </form>

            <div class="mt-3 text-center">
                <span class="text-muted">Đã có tài khoản?</span>
                <a href="/login" class="text-decoration-none">Đăng nhập</a>
            </div>
        </div>
    </section>
@endsection
