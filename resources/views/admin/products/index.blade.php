@extends('admin.layouts.admin')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('topbar-actions')
    <a href="/" class="btn-back"><i class="fas fa-home"></i> Về trang chủ</a>
@endsection

@section('content')
    <!-- Actions Bar -->
    <div class="actions-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm sản phẩm...">
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm sản phẩm mới
        </a>
    </div>

    <!-- Products Table -->
    <div class="table-card">
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Size</th>
                    <th>Màu sắc</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr data-product-id="{{ $product->id }}">
                        <td>#{{ $product->id }}</td>
                        <td>
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/60' }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-thumb">
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="price">{{ number_format($product->price, 0, ',', '.') }} đ</td>
                        <td>
                            <div class="quantity-control">
                                <button class="qty-btn" onclick="updateQuantity({{ $product->id }}, -1)">-</button>
                                <input type="number" 
                                       value="{{ $product->quantity }}" 
                                       id="qty-{{ $product->id }}"
                                       class="qty-input"
                                       min="0"
                                       onchange="setQuantity({{ $product->id }}, this.value)">
                                <button class="qty-btn" onclick="updateQuantity({{ $product->id }}, 1)">+</button>
                            </div>
                        </td>
                        <td>
                            @if($product->sizes && count($product->sizes) > 0)
                                <div class="tags">
                                    @foreach($product->sizes as $size)
                                        <span class="tag">{{ $size }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
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
                                <div class="color-dots">
                                    @foreach($colorDots as $color)
                                        <span class="color-dot" style="background: {{ $color }}" title="{{ $color }}"></span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($product->quantity > 0)
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Còn hàng
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times"></i> Hết hàng
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn-action btn-edit" 
                                   title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <p>Chưa có sản phẩm nào</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    Thêm sản phẩm đầu tiên
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->links() }}
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Update quantity
    function updateQuantity(productId, change) {
        const input = document.getElementById(`qty-${productId}`);
        const currentValue = parseInt(input.value) || 0;
        const newValue = Math.max(0, currentValue + change);
        setQuantity(productId, newValue);
    }

    // Set quantity
    function setQuantity(productId, quantity) {
        quantity = Math.max(0, parseInt(quantity) || 0);
        const input = document.getElementById(`qty-${productId}`);
        input.value = quantity;

        // Send AJAX request
        fetch(`/admin/products/${productId}/quantity`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update stock status badge
                const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                const badge = row.querySelector('.badge');
                if (quantity > 0) {
                    badge.className = 'badge badge-success';
                    badge.innerHTML = '<i class="fas fa-check"></i> Còn hàng';
                } else {
                    badge.className = 'badge badge-danger';
                    badge.innerHTML = '<i class="fas fa-times"></i> Hết hàng';
                }
                
                // Show success message
                showToast('Đã cập nhật số lượng thành công!', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Có lỗi xảy ra khi cập nhật số lượng', 'error');
        });
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.products-table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endpush
