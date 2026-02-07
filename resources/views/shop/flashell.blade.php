@extends('layouts.app')

@section('title', 'Giảm giá')
@section('meta_description', 'Chương trình khuyến mãi và giảm giá.')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="mb-0">Flash Sale</h1>
                <span class="badge bg-danger">Kết thúc trong 04:12:36</span>
            </div>

            <div class="row g-4">
                @for ($i = 1; $i <= 6; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Deal #{{ $i }}</h5>
                                <span class="badge bg-success">-{{ 10 + $i * 5 }}%</span>
                            </div>
                            <p class="text-muted">Sản phẩm ưu đãi trong thời gian giới hạn.</p>
                            <div class="fw-semibold">{{ number_format(199000 + $i * 15000) }}đ</div>
                            <a href="/product/{{ $i }}" class="btn btn-sm btn-primary mt-2">Mua ngay</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
@endsection
