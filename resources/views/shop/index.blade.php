@extends('layouts.app')

@section('title', 'Cửa hàng')
@section('meta_description', 'Khám phá tất cả sản phẩm thời trang mới nhất.')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Header & Filter -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
                <div class="mb-3 mb-md-0">
                    <h1 class="h2 fw-bold mb-1">Cửa Hàng</h1>
                    <p class="text-muted mb-0">
                        Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} 
                        trong tổng số {{ $products->total() }} sản phẩm
                    </p>
                </div>
                
                <form action="{{ url()->current() }}" method="GET" class="d-flex gap-3 align-items-center">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    
                    <select name="sort" class="form-select border-0 shadow-sm" onchange="this.form.submit()" style="min-width: 200px;">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                    </select>
                </form>
            </div>

            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden sticky-top" style="top: 100px; z-index: 900;">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="card-title mb-0 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Bộ Lọc</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="{{ url('/shop') }}" 
                                   class="list-group-item list-group-item-action py-3 {{ !request('category') ? 'active fw-bold' : '' }}">
                                    <i class="fas fa-th-large me-2"></i> Tất cả sản phẩm
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ url('/shop?category=' . $category->id) }}" 
                                       class="list-group-item list-group-item-action py-3 {{ request('category') == $category->id ? 'active fw-bold' : '' }} d-flex justify-content-between align-items-center">
                                        <span>
                                            @if($category->icon)
                                                <img src="{{ $category->icon }}" alt="" style="width: 20px; height: 20px; object-fit: contain; margin-right: 8px;">
                                            @else
                                                <i class="fas fa-tag me-2 text-muted"></i>
                                            @endif
                                            {{ $category->name }}
                                        </span>
                                        <span class="badge bg-light text-dark rounded-pill">{{ $category->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-lg-9">
                    @if($products->count() > 0)
                        <div class="row g-4">
                            @foreach($products as $product)
                            <div class="col-lg-4 col-md-6 col-6">
                                @include('partials.product-card', ['product' => $product])
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-5 d-flex justify-content-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3 class="h5">Không tìm thấy sản phẩm nào</h3>
                            <p class="text-muted">Thử thay đổi bộ lọc hoặc tìm kiếm từ khóa khác.</p>
                            <a href="/shop" class="btn btn-primary mt-3">Xem tất cả sản phẩm</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .product-card:hover .product-actions-overlay {
            transform: translateY(0) !important;
        }
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Add to cart

    </script>
@endpush
