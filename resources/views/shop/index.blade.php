@extends('layouts.app')

@section('title', 'Sản phẩm')
@section('meta_description', 'Danh sách sản phẩm mới nhất.')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="mb-1">Sản phẩm</h1>
                    <p class="text-muted mb-0">Khám phá bộ sưu tập mới nhất.</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select" style="min-width: 180px;">
                        <option>Mới nhất</option>
                        <option>Giá tăng dần</option>
                        <option>Giá giảm dần</option>
                    </select>
                    <button class="btn btn-outline-secondary">Lọc</button>
                </div>
            </div>

            <div class="row g-4">
                @for ($i = 1; $i <= 8; $i++)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card h-100">
                        <div class="ratio ratio-1x1">
                            <div class="bg-light"></div>
                        </div>
                        <div class="card-body">
                            <div class="text-muted small">Danh mục</div>
                            <h5 class="card-title">Sản phẩm {{ $i }}</h5>
                            <div class="fw-semibold">{{ number_format(199000 + $i * 5000) }}đ</div>
                            <a href="/product/{{ $i }}" class="btn btn-sm btn-outline-primary mt-2">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
@endsection
