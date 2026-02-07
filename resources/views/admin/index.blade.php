@extends('layouts.app')

@section('title', 'Admin - Shop')
@section('meta_description', 'Bảng điều khiển quản trị.')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 m-0">Admin đơn giản</h1>
                <a href="/" class="btn btn-outline-secondary">Về trang chủ</a>
            </div>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Clear cache</h5>
                            <p class="card-text text-muted mb-3">
                                Xóa view, cache, config, route. Chỉ hoạt động ở môi trường local.
                            </p>
                            <form method="POST" action="/admin/clear-cache">
                                @csrf
                                <button class="btn btn-primary">Xóa cache ngay</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Thông tin</h5>
                            <ul class="text-muted mb-0">
                                <li>ENV: {{ app()->environment() }}</li>
                                <li>PHP: {{ PHP_VERSION }}</li>
                                <li>Laravel: {{ app()->version() }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
