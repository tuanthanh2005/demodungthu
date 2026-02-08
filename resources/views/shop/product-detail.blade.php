@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', 'Thông tin chi tiết sản phẩm.')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="ratio ratio-1x1 bg-light"></div>
                </div>
                <div class="col-lg-6">
                    <h1 class="mb-2">{{ $product->name }}</h1>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        @if($product->sale_price && $product->sale_price > 0 && $product->sale_price < $product->regular_price)
                            <span class="price-current">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                            <span class="price-old">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
                        @else
                            <span class="price-current">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
                        @endif
                    </div>
                    <p class="text-muted">{{ $product->description }}</p>

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
