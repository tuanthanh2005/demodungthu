@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit($product->description, 160))

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bg-light py-3 mb-4">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="/shop" class="text-decoration-none">Sản phẩm</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="/shop?category={{ $product->category->id }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </div>
    </nav>

    <section class="mb-5">
        <div class="container">
            <div class="row g-5">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="product-gallery position-sticky" style="top: 100px;">
                        <div class="main-image mb-3 rounded-3 overflow-hidden border">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/600' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-100 object-fit-cover" 
                                 style="aspect-ratio: 1/1;" 
                                 id="mainImage">
                        </div>
                        @if($product->images && count($product->images) > 0)
                            <div class="d-flex gap-2 overflow-auto product-thumbs pb-2">
                                <div class="thumb active border border-primary rounded" 
                                     style="width: 80px; height: 80px; cursor: pointer;"
                                     onclick="changeImage('{{ $product->image }}', this)">
                                    <img src="{{ $product->image }}" class="w-100 h-100 object-fit-cover rounded">
                                </div>
                                @foreach($product->images as $img)
                                    <div class="thumb border rounded" 
                                         style="width: 80px; height: 80px; cursor: pointer;"
                                         onclick="changeImage('{{ $img }}', this)">
                                        <img src="{{ $img }}" class="w-100 h-100 object-fit-cover rounded">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-details">
                        <div class="mb-2">
                            <span class="badge bg-primary me-2">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            @if($product->quantity > 0)
                                <span class="badge bg-success">Còn hàng</span>
                            @else
                                <span class="badge bg-secondary">Hết hàng</span>
                            @endif
                        </div>
                        
                        <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                        
                        <div class="price-box mb-4">
                            @if($product->sale_price && $product->sale_price > 0 && $product->sale_price < $product->regular_price)
                                <span class="h3 fw-bold text-danger me-2">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                <span class="h5 text-muted text-decoration-line-through">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
                                <span class="badge bg-danger ms-2">-{{ round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) }}%</span>
                            @else
                                <span class="h3 fw-bold">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
                            @endif
                        </div>

                        <p class="text-muted mb-4">{{ Str::limit($product->description, 300) }}</p>

                        <!-- Variants Form -->
                        <form action="#" class="mb-4">
                            <!-- Colors -->
                            @php
                                $colorPoints = [];
                                $colorPrices = is_array($product->color_prices) ? $product->color_prices : json_decode($product->color_prices ?? '[]', true);
                                if (!empty($colorPrices)) {
                                    $colorPoints = $colorPrices;
                                }
                            @endphp
                            
                            @if(!empty($colorPoints))
                                <div class="mb-4">
                                    <label class="fw-bold mb-2 d-block">Màu sắc:</label>
                                    <div class="d-flex gap-2">
                                        @foreach($colorPoints as $index => $color)
                                            <input type="radio" class="btn-check" name="color-option" id="color-{{ $index }}" autocomplete="off">
                                            <label class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center p-0" 
                                                   for="color-{{ $index }}" 
                                                   style="width: 35px; height: 35px; border-color: #dee2e6;"
                                                   title="{{ $color['hex'] ?? '' }}">
                                                <span class="rounded-circle" style="width: 25px; height: 25px; background-color: {{ $color['hex'] ?? '#000' }};"></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif(!empty($product->colors))
                                <div class="mb-4">
                                    <label class="fw-bold mb-2 d-block">Màu sắc:</label>
                                    <div class="d-flex gap-2">
                                        @foreach($product->colors as $index => $color)
                                            <input type="radio" class="btn-check" name="color" id="color-{{ $index }}" autocomplete="off">
                                            <label class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center p-0" 
                                                   for="color-{{ $index }}" 
                                                   style="width: 35px; height: 35px; border-color: #dee2e6;"
                                                   title="{{ $color }}">
                                                <span class="rounded-circle" style="width: 25px; height: 25px; background-color: {{ $color }};"></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Sizes -->
                            @if($product->sizes && count($product->sizes) > 0)
                                <div class="mb-4">
                                    <label class="fw-bold mb-2 d-block">Kích thước:</label>
                                    <div class="d-flex gap-2">
                                        @foreach($product->sizes as $index => $size)
                                            <input type="radio" class="btn-check" name="size" id="size-{{ $index }}" autocomplete="off">
                                            <label class="btn btn-outline-secondary" for="size-{{ $index }}">{{ $size }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Quantity & Action -->
                            <div class="d-flex gap-3 align-items-center mb-4">
                                <div class="input-group" style="width: 140px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQty(-1)">-</button>
                                    <input type="number" class="form-control text-center" value="1" min="1" id="qtyInput">
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQty(1)">+</button>
                                </div>
                                <button type="button" class="btn btn-primary btn-lg flex-grow-1" id="addToCartBtn">
                                    <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-lg p-3 rounded-circle" aria-label="Add to wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Policies -->
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex gap-3">
                                    <i class="fas fa-truck text-primary fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Miễn phí vận chuyển</h6>
                                        <p class="small text-muted mb-0">Cho đơn hàng từ 500k</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex gap-3">
                                    <i class="fas fa-undo text-primary fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Đổi trả dễ dàng</h6>
                                        <p class="small text-muted mb-0">Trong vòng 7 ngày</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Tabs -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-bottom">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#description" role="tab">Mô tả sản phẩm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" data-bs-toggle="tab" href="#specs" role="tab">Thông số kỹ thuật</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" data-bs-toggle="tab" href="#reviews" role="tab">Đánh giá</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <!-- Description Tab -->
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="prose">
                                        {!! nl2br(e($product->description)) !!}
                                    </div>
                                </div>
                                
                                <!-- Specs Tab -->
                                <div class="tab-pane fade" id="specs" role="tabpanel">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width: 200px;">Danh mục</th>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Chất liệu</th>
                                                <td>Cotton 100% (Ví dụ)</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Xuất xứ</th>
                                                <td>Việt Nam</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Reviews Tab -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <div class="text-center py-4">
                                        <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                                        <h5>Chưa có đánh giá nào</h5>
                                        <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này</p>
                                        <button class="btn btn-outline-primary mt-2">Viết đánh giá</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumb').forEach(el => {
            el.classList.remove('active', 'border-primary');
            el.classList.add('border');
        });
        element.classList.add('active', 'border-primary');
        element.classList.remove('border');
    }

    function updateQty(change) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value) || 1;
        val += change;
        if(val < 1) val = 1;
        input.value = val;
    }
</script>
<style>
    .product-thumbs::-webkit-scrollbar {
        height: 6px;
    }
    .product-thumbs::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }
    .nav-tabs .nav-link {
        color: #495057;
        padding: 1rem 1.5rem;
    }
    .nav-tabs .nav-link.active {
        color: var(--primary);
        border-bottom: 2px solid var(--primary);
    }
</style>
@endpush
