<div class="product-card {{ $product->quantity <= 0 ? 'out-of-stock' : '' }}">
    <a href="{{ url('/product/' . $product->id) }}" class="product-image d-block text-decoration-none">
        <img src="{{ $product->image ?? 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}">
        @if($product->quantity <= 0)
            <span class="product-badge out-of-stock-badge">Hết hàng</span>
        @elseif($product->created_at->diffInDays(now()) < 7)
            <span class="product-badge new">Mới</span>
        @endif
        @if($product->quantity <= 0)
            <div class="out-of-stock-overlay">
                <i class="fas fa-ban"></i>
                <p>Tạm hết hàng</p>
            </div>
        @endif
    </a>
    <div class="product-info">
        <div class="product-category">{{ $product->category->name ?? 'N/A' }}</div>
        <h3 class="product-name">
            <a href="{{ url('/product/' . $product->id) }}" class="text-decoration-none text-reset">
                {{ $product->name }}
            </a>
        </h3>
        
        @if($product->sizes && count($product->sizes) > 0)
            <div class="product-sizes">
                <small class="text-muted">Size: </small>
                @foreach($product->sizes as $size)
                    <span class="size-tag">{{ $size }}</span>
                @endforeach
            </div>
        @endif
        
        @php
            $colorDots = [];
            $colorPrices = is_array($product->color_prices) ? $product->color_prices : json_decode($product->color_prices ?? '[]', true);
            if (!empty($colorPrices)) {
                foreach ($colorPrices as $data) {
                    if (!empty($data['hex'])) $colorDots[] = $data['hex'];
                }
            }
            if (empty($colorDots) && !empty($product->colors)) {
                $colorDots = is_array($product->colors) ? $product->colors : json_decode($product->colors ?? '[]', true);
            }
        @endphp
        @if(!empty($colorDots))
            <div class="product-colors">
                <small class="text-muted">Màu: </small>
                @foreach($colorDots as $color)
                    <span class="color-dot-small" style="background: {{ $color }}" title="{{ $color }}"></span>
                @endforeach
            </div>
        @endif
        
        <div class="product-price">
            @if($product->sale_price && $product->sale_price > 0 && $product->sale_price < $product->regular_price)
                <span class="price-current">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                <span class="price-old">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
            @else
                <span class="price-current">{{ number_format($product->regular_price, 0, ',', '.') }}đ</span>
            @endif
        </div>
        
        <div class="product-stock-info">
            @if($product->quantity > 0 && $product->quantity <= 5)
                <small class="text-warning">
                    <i class="fas fa-exclamation-triangle"></i> Chỉ còn {{ $product->quantity }} sản phẩm
                </small>
            @elseif($product->quantity > 0)
                <small class="text-success">
                    <i class="fas fa-check-circle"></i> Còn hàng ({{ $product->quantity }})
                </small>
            @else
                <small class="text-danger">
                    <i class="fas fa-times-circle"></i> Hết hàng
                </small>
            @endif
        </div>
        
        <div class="product-actions">
            <!-- Note: Classes adapted to ensure they work with querySelectors in all pages -->
            <button class="btn-add-cart" 
                    {{ $product->quantity <= 0 ? 'disabled' : '' }}
                    data-product-id="{{ $product->id }}">
                <i class="fas fa-shopping-cart me-2"></i>
                {{ $product->quantity <= 0 ? 'Hết hàng' : 'Thêm vào giỏ' }}
            </button>
            <button class="btn-wishlist" 
                    {{ $product->quantity <= 0 ? 'disabled' : '' }}
                    data-product-id="{{ $product->id }}">
                <i class="far fa-heart"></i>
            </button>
        </div>
    </div>
</div>
