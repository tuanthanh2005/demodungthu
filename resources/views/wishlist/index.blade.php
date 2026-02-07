@extends('layouts.app')

@section('title', 'Yêu thích')
@section('meta_description', 'Danh sách sản phẩm yêu thích.')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">Yêu thích</h1>
            <div class="row g-4">
                @for ($i = 1; $i <= 6; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm {{ $i }}</h5>
                            <p class="text-muted">Sản phẩm được bạn quan tâm.</p>
                            <div class="fw-semibold">{{ number_format(199000 + $i * 7000) }}đ</div>
                            <div class="d-flex gap-2 mt-2">
                                <a href="/product/{{ $i }}" class="btn btn-sm btn-outline-primary">Xem</a>
                                <button class="btn btn-sm btn-primary">Thêm vào giỏ</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
@endsection
