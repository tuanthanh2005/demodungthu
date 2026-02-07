@extends('layouts.app')

@section('title', 'Đăng ký')
@section('meta_description', 'Trang tạo tài khoản mới.')

@section('content')
    <section class="py-5">
        <div class="container" style="max-width: 560px;">
            <h1 class="mb-3">Đăng ký</h1>
            <p class="text-muted">Tạo tài khoản mới để mua sắm nhanh hơn.</p>

            <form class="mt-4">
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" placeholder="Nguyễn Văn A">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="you@email.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Tối thiểu 8 ký tự">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                </div>
                <button class="btn btn-primary w-100">Tạo tài khoản</button>
            </form>

            <div class="mt-3 text-center">
                <span class="text-muted">Đã có tài khoản?</span>
                <a href="/login" class="text-decoration-none">Đăng nhập</a>
            </div>
        </div>
    </section>
@endsection
