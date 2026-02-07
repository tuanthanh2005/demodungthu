@extends('layouts.app')

@section('title', 'Danh mục')
@section('meta_description', 'Danh mục sản phẩm.')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-3">Danh mục</h1>
            <div class="row g-4">
                @foreach (['Thời trang nữ', 'Thời trang nam', 'Phụ kiện', 'Giày dép', 'Túi xách', 'Đồng hồ'] as $cat)
                <div class="col-md-4 col-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cat }}</h5>
                            <p class="text-muted mb-3">Khám phá sản phẩm mới nhất.</p>
                            <a href="/shop" class="btn btn-sm btn-outline-primary">Xem sản phẩm</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
