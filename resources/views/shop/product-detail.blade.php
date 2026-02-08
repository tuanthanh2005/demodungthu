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
                        
                        <div class="price-box mb-4" id="priceBox" 
                             data-base-price="{{ $product->sale_price > 0 ? $product->sale_price : $product->regular_price }}"
                             data-regular-price="{{ $product->regular_price }}"
                             data-sale-price="{{ $product->sale_price ?? 0 }}"
                             data-size-prices='@json($product->size_prices ?? [])'
                             data-color-prices='@json($product->color_prices ?? [])'>
                            @if($product->sale_price && $product->sale_price > 0 && $product->sale_price < $product->regular_price)
                                <span class="h3 fw-bold text-danger me-2" id="currentPrice">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                                <span class="h5 text-muted text-decoration-line-through" id="originalPrice">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
                                <span class="badge bg-danger ms-2" id="discountBadge">-{{ round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) }}%</span>
                            @else
                                <span class="h3 fw-bold" id="currentPrice">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
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
                            @php
                                $sizePrices = is_array($product->size_prices) ? $product->size_prices : json_decode($product->size_prices ?? '[]', true);
                            @endphp
                            @if($product->sizes && count($product->sizes) > 0)
                                <div class="mb-4">
                                    <label class="fw-bold mb-2 d-block">Kích thước:</label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach($product->sizes as $index => $size)
                                            @php
                                                $sizePrice = null;
                                                if (!empty($sizePrices)) {
                                                    foreach ($sizePrices as $sp) {
                                                        if (isset($sp['size']) && $sp['size'] === $size && isset($sp['price'])) {
                                                            $sizePrice = $sp['price'];
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <input type="radio" class="btn-check" name="size" id="size-{{ $index }}" autocomplete="off">
                                            <label class="btn btn-outline-secondary" for="size-{{ $index }}">
                                                {{ $size }}
                                                @if($sizePrice)
                                                    <small class="d-block text-muted" style="font-size: 0.75rem;">+{{ number_format($sizePrice - ($product->sale_price > 0 ? $product->sale_price : $product->regular_price), 0, ',', '.') }}đ</small>
                                                @endif
                                            </label>
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
    <section class="bg-light py-5 mt-5">
        <div class="container-fluid px-0">
            <div class="card border-0 shadow-sm rounded-0">
                <div class="card-header bg-white border-bottom pt-4">
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
                <div class="card-body p-4 p-md-5">
                    <div class="container"> <!-- Inner container for readable text width -->
                        <div class="tab-content">
                            <!-- Description Tab -->
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <div class="prose mx-auto" style="max-width: 1000px;">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                            
                            <!-- Specs Tab -->
                            <div class="tab-pane fade" id="specs" role="tabpanel">
                                <div class="mx-auto" style="max-width: 1000px;">
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

    // Update price based on selected variant
    function updatePrice() {
        const priceBox = document.getElementById('priceBox');
        if (!priceBox) return;

        const sizePrices = JSON.parse(priceBox.dataset.sizePrices || '[]');
        const colorPrices = JSON.parse(priceBox.dataset.colorPrices || '[]');
        let basePrice = parseFloat(priceBox.dataset.basePrice);
        const regularPrice = parseFloat(priceBox.dataset.regularPrice);
        
        // Get selected size
        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (selectedSize && sizePrices.length > 0) {
            const sizeValue = selectedSize.nextElementSibling.textContent.trim();
            const sizeData = sizePrices.find(s => s.size === sizeValue);
            if (sizeData && sizeData.price) {
                basePrice = parseFloat(sizeData.price);
            }
        }
        
        // Get selected color (can override size price)
        const selectedColor = document.querySelector('input[name^="color"]:checked');
        if (selectedColor && colorPrices.length > 0) {
            const colorHex = selectedColor.nextElementSibling.getAttribute('title');
            const colorData = colorPrices.find(c => c.hex === colorHex || c.name === colorHex);
            if (colorData && colorData.price && colorData.price > 0) {
                basePrice = parseFloat(colorData.price);
            }
        }
        
        // Update price display
        const currentPriceEl = document.getElementById('currentPrice');
        if (currentPriceEl) {
            currentPriceEl.textContent = new Intl.NumberFormat('vi-VN').format(basePrice) + 'đ';
        }
    }

    // Add event listeners to size and color options
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name="size"], input[name^="color"]').forEach(input => {
            input.addEventListener('change', updatePrice);
        });
    });

    // Add to Cart Logic
    document.getElementById('addToCartBtn').addEventListener('click', function() {
        const productId = {{ $product->id }};
        const quantity = document.getElementById('qtyInput').value;
        
        let size = null;
        let color = null;
        
        // Get selected size
        const sizeInput = document.querySelector('input[name="size"]:checked');
        if(document.querySelectorAll('input[name="size"]').length > 0) {
             if(!sizeInput) {
                showToast('Vui lòng chọn kích thước!', 'warning');
                return;
            }
            size = sizeInput.nextElementSibling.textContent;
        }

        // Get selected color
        const colorInput = document.querySelector('input[name^="color"]:checked');
         if(document.querySelectorAll('input[name^="color"]').length > 0) {
            if(!colorInput) {
                showToast('Vui lòng chọn màu sắc!', 'warning');
                return;
            }
            // Try to get color name or hex from title or style
            color = colorInput.nextElementSibling.getAttribute('title') || 'Standard'; 
        }

        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Đang xử lý...';
        btn.disabled = true;

        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id: productId,
                quantity: quantity,
                size: size,
                color: color
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            btn.innerHTML = '<i class="fas fa-check me-2"></i> Đã thêm vào giỏ!';
            btn.classList.replace('btn-primary', 'btn-success');
            
            // Update cart count in header with animation
            if(data.cart_count !== undefined) {
                updateCartBadge(data.cart_count);
            }
            showToast(data.success || 'Đã thêm sản phẩm vào giỏ hàng!', 'success');

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.replace('btn-success', 'btn-primary');
                btn.disabled = false;
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            const msg = error.error || error.message || 'Có lỗi xảy ra, vui lòng thử lại.';
            showToast(msg, 'danger');
        });
    });

    // Add to Wishlist Logic
    document.querySelector('.btn-outline-danger.rounded-circle').addEventListener('click', function() {
        const btn = this;
        const productId = {{ $product->id }};
        const icon = btn.querySelector('i');

        fetch('{{ route('wishlist.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-danger');
                
                // Update wishlist badge
                if (data.count !== undefined) {
                    updateWishlistBadge(data.count);
                }
                
                showToast(data.success || 'Đã thêm vào danh sách yêu thích!', 'success');
            } else if(data.info) {
                showToast(data.info, 'info');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Có lỗi xảy ra, vui lòng thử lại.', 'danger');
        });
    });
</script>
<style>
    .product-thumbs::-webkit-scrollbar {
        height: 6px;
    }
    .product-thumbs::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }
    
    /* Tabs Styling */
    .card-header-tabs {
        margin-bottom: -1px; /* Align with border-bottom */
        border-bottom: none;
        gap: 10px;
        justify-content: center; /* Center the tabs */
    }
    
    .nav-tabs .nav-link {
        color: #64748b;
        padding: 1rem 2rem;
        font-family: 'Inter', sans-serif; /* Force sans-serif */
        font-weight: 600;
        border: none;
        border-bottom: 3px solid transparent; /* Prepare for active border */
        background: transparent;
        transition: all 0.2s ease;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    
    .nav-tabs .nav-link:hover {
        color: var(--primary);
        background: rgba(var(--primary-rgb), 0.05); /* Subtle background on hover if supported, else transparent */
        border-color: transparent;
    }
    
    .nav-tabs .nav-link.active {
        color: var(--primary);
        background: transparent;
        border-bottom-color: var(--primary);
    }
    
    /* Content Styling */
    .prose {
        font-family: 'Inter', sans-serif;
        color: #334155;
        line-height: 1.8; /* Increased line height for readability */
        font-size: 1rem;
        text-align: justify; /* Justify text as requested */
    }
    
    .prose p {
        margin-bottom: 1.5rem;
    }
</style>
@endpush
