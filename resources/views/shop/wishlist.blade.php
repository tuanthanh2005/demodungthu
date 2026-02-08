@extends('layouts.app')

@section('title', 'Danh Sách Yêu Thích')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h1 class="h3 mb-0 fw-bold text-dark font-playfair">
            <i class="far fa-heart text-danger me-2"></i>Danh Sách Yêu Thích
        </h1>
        <span class="text-muted small">{{ $products->count() }} sản phẩm</span>
    </div>

    @if(isset($products) && $products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-6 wishlist-item" data-id="{{ $product->id }}">
                @include('partials.product-card', ['product' => $product])
                
                <!-- Remove Button Overlay -->
                <button class="btn btn-light rounded-circle shadow-sm position-absolute remove-wishlist d-flex align-items-center justify-content-center" 
                        title="Xóa khỏi yêu thích" 
                        style="width: 32px; height: 32px; z-index: 10; opacity: 0.95; top: 8px; right: 8px;">
                    <i class="fas fa-times text-danger"></i>
                </button>
            </div>
            @endforeach
        </div>

        <div class="mt-5 text-center">
            <a href="{{ url('/shop') }}" class="btn btn-link text-decoration-none text-muted"> <i class="fas fa-angle-left me-1"></i> Tiếp tục mua sắm</a>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 120px; height: 120px;">
                    <i class="far fa-heart fa-4x text-muted opacity-25"></i>
                </div>
            </div>
            <h3 class="h5 fw-bold text-dark">Danh sách yêu thích trống</h3>
            <p class="text-muted mb-4">Bạn chưa lưu sản phẩm nào vào danh sách yêu thích.</p>
            <a href="{{ url('/shop') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                Khám phá sản phẩm ngay
            </a>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .font-playfair {
        font-family: 'Playfair Display', serif;
    }
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition-transform {
        transition: transform 0.3s ease;
    }
    .product-card:hover .transition-transform {
        transform: scale(1.05);
    }
    .stretched-link-z {
        position: relative; 
        z-index: 1;
    }
    .wishlist-item {
        position: relative;
    }
    .wishlist-item .remove-wishlist {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 10;
    }
</style>
@endsection

@push('scripts')
<script>
    // Remove from Wishlist
    document.querySelectorAll('.remove-wishlist').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent triggering product card click
            
            if(!confirm('Xóa sản phẩm này khỏi yêu thích?')) return;
            
            const col = this.closest('.wishlist-item');
            const id = col.dataset.id;
            
            // Add loading state opacity
            col.style.opacity = '0.5';
            
            fetch('{{ route('wishlist.remove') }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                col.remove();
                
                // Update wishlist badge
                if (data.count !== undefined) {
                    updateWishlistBadge(data.count);
                }
                
                // Show toast notification
                showToast('Đã xóa khỏi danh sách yêu thích!', 'success');
                
                if(document.querySelectorAll('.wishlist-item').length === 0) {
                    location.reload();
                }
            })
            .catch(err => {
                console.error(err);
                col.style.opacity = '1';
                showToast('Có lỗi xảy ra!', 'danger');
            });
        });
    });
</script>
@endpush
