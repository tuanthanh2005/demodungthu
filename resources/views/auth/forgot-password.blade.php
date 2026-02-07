@extends('layouts.app')

@section('title', 'Quên mật khẩu')
@section('meta_description', 'Khôi phục mật khẩu tài khoản.')

@section('content')
    <section class="py-5">
        <div class="container" style="max-width: 520px;">
            <h1 class="mb-3">Quên mật khẩu</h1>
            <p class="text-muted">Nhập email để nhận hướng dẫn đặt lại mật khẩu.</p>

            <form class="mt-4">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="you@email.com">
                </div>
                <button class="btn btn-primary w-100">Gửi liên kết</button>
            </form>
        </div>
    </section>
@endsection
