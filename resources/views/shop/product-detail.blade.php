@extends('layouts.app')

@section('title', 'Chi tiết sản phẩm')
@section('meta_description', 'Thông tin chi tiết sản phẩm.')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="ratio ratio-1x1 bg-light"></div>
                </div>
                <div class="col-lg-6">
                    <h1 class="mb-2">Sản phẩm #{{ $id }}</h1>
                    <div class="h4 text-primary">349.000đ</div>
                    <p class="text-muted">Mô tả ngắn về sản phẩm, chất liệu và kiểu dáng.</p>

                    <div class="mb-3">
                        <label class="form-label">Kích cỡ</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm">S</button>
                            <button class="btn btn-outline-secondary btn-sm">M</button>
                            <button class="btn btn-outline-secondary btn-sm">L</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" style="width: 120px;" value="1" min="1">
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">Thêm vào giỏ</button>
                        <button class="btn btn-outline-danger">Yêu thích</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
