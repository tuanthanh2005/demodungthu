@extends('layouts.app')

@section('title', 'Thanh toán')
@section('meta_description', 'Thông tin thanh toán đơn hàng.')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">Thanh toán</h1>
            
            @if(empty($cartItems))
                <div class="alert alert-warning text-center">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Giỏ hàng của bạn đang trống. 
                    <a href="{{ url('/shop') }}" class="alert-link">Tiếp tục mua sắm</a>
                </div>
            @else
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3 fw-bold">Thông tin giao hàng</h5>
                                <form id="checkoutForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input class="form-control" name="name" placeholder="Họ và tên" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                            <input class="form-control" name="phone" placeholder="Số điện thoại" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input class="form-control" type="email" name="email" placeholder="Email" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                            <input class="form-control" name="address" placeholder="Địa chỉ" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                            <input class="form-control" name="city" placeholder="Tỉnh/Thành phố" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                            <input class="form-control" name="district" placeholder="Quận/Huyện" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Ghi chú</label>
                                            <textarea class="form-control" name="note" rows="3" placeholder="Ghi chú (tùy chọn)"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3 fw-bold">Chi tiết đơn hàng</h5>
                                
                                <!-- Cart Items -->
                                <div class="order-items mb-3">
                                    @foreach($cartItems as $item)
                                        <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                                 class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 text-truncate" style="max-width: 180px;">{{ $item['name'] }}</h6>
                                                <small class="text-muted d-block">
                                                    @if($item['size'] !== 'Standard')Size: {{ $item['size'] }}@endif
                                                    @if($item['color'] !== 'Standard') | Màu: {{ $item['color'] }}@endif
                                                </small>
                                                <small class="text-muted">x {{ $item['quantity'] }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold text-primary">{{ number_format($item['subtotal'], 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Order Summary -->
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tạm tính</span>
                                    <strong>{{ number_format($subtotal, 0, ',', '.') }}đ</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Phí vận chuyển</span>
                                    @if($shippingFee > 0)
                                        <strong>{{ number_format($shippingFee, 0, ',', '.') }}đ</strong>
                                    @else
                                        <strong class="text-success">Miễn phí</strong>
                                    @endif
                                </div>
                                @if($shippingFee > 0)
                                    <div class="alert alert-info py-2 small mb-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Miễn phí vận chuyển cho đơn hàng từ 500.000đ
                                    </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-bold fs-5">Tổng cộng</span>
                                    <strong class="text-primary fs-4">{{ number_format($total, 0, ',', '.') }}đ</strong>
                                </div>
                                <button type="button" class="btn btn-primary w-100 py-3 rounded-pill fw-bold" 
                                        id="placeOrderBtn" onclick="placeOrder()">
                                    <i class="fas fa-lock me-2"></i>Đặt hàng
                                </button>
                                
                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        Thông tin của bạn được bảo mật tuyệt đối
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ url('/cart') }}" class="btn btn-outline-secondary w-100 rounded-pill">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
function placeOrder() {
    const form = document.getElementById('checkoutForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
    
    // Here you would send the order to the server
    // For now just show success
    setTimeout(() => {
        alert('Đặt hàng thành công! Cảm ơn bạn đã mua sắm.');
        window.location.href = '/';
    }, 1500);
}
</script>
@endpush

