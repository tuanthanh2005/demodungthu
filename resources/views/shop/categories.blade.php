@extends('layouts.app')

@section('title', 'Danh mục')
@section('meta_description', 'Danh mục sản phẩm.')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-3">Danh mục</h1>
            <div class="row g-4">
                @foreach ($categories as $category)
                <div class="col-md-4 col-6">
                    <div class="card h-100 category-card-link">
                        <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                            @if($category->icon)
                                <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="mb-3 category-icon" style="height: 60px; width: 60px; object-fit: contain;">
                            @else
                                <div class="category-placeholder mb-3">
                                    <i class="fas fa-shapes fa-3x text-muted"></i>
                                </div>
                            @endif
                            <h5 class="card-title fw-bold mb-1">{{ $category->name }}</h5>
                            <p class="text-muted small mb-3">{{ $category->products_count }} sản phẩm</p>
                            <a href="{{ url('/shop?category=' . $category->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Xem ngay <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
