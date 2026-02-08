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
                                            <input class="form-control" name="name" placeholder="Họ và tên" value="{{ $user->name ?? '' }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                            <input class="form-control" name="phone" placeholder="Số điện thoại" value="{{ $user->phone ?? '' }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input class="form-control" type="email" name="email" placeholder="Email" value="{{ $user->email ?? '' }}" required>
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
                        
                        <!-- Payment Methods -->
                        <div class="card border-0 shadow-sm rounded-3 mt-4">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3 fw-bold">Phương thức thanh toán</h5>
                                <div class="payment-methods">
                                    <div class="form-check mb-3 p-3 border rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                                        <label class="form-check-label w-100" for="payment_cod">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fw-bold">
                                                    <i class="fas fa-money-bill-wave text-success me-2"></i>
                                                    Thanh toán khi nhận hàng (COD)
                                                </span>
                                            </div>
                                            <small class="text-muted d-block mt-1">Thanh toán toàn bộ số tiền khi nhận hàng.</small>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check p-3 border rounded">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_deposit" value="deposit">
                                        <label class="form-check-label w-100" for="payment_deposit">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="fw-bold">
                                                    <i class="fas fa-qrcode text-primary me-2"></i>
                                                    Đặt cọc 30% (Chuyển khoản)
                                                </span>
                                                <span class="badge bg-primary">Khuyên dùng</span>
                                            </div>
                                            <small class="text-muted d-block mt-1">Đặt cọc trước 30% để đảm bảo đơn hàng. Hoàn tiền nếu có lỗi.</small>
                                            
                                            <!-- Setup for Deposit Info (Hidden by default) -->
                                            <div id="depositInfo" class="mt-3 pt-3 border-top d-none">
                                                <div class="alert alert-info small">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Quét mã QR bên dưới để đặt cọc <strong>30%</strong> giá trị đơn hàng.
                                                    Số tiền còn lại sẽ thanh toán khi nhận hàng.
                                                </div>
                                                <div class="text-center">
                                                    <div class="bg-white p-2 d-inline-block border rounded mb-2">
                                                        <img id="qrCodeImage" src="" alt="Mã QR thanh toán" class="img-fluid" style="max-width: 250px;">
                                                    </div>
                                                    <p class="mb-1 fw-bold text-primary" id="depositAmountDisplay"></p>
                                                    <p class="small text-muted mb-0">Chủ TK: <strong class="text-dark">TRAN THANH TUAN</strong></p>
                                                    <p class="small text-muted">STK: <strong class="text-dark">0783704196</strong> (MB Bank)</p>
                                                </div>
                                                
                                                <div class="form-check mt-3 bg-light p-3 rounded border">
                                                    <input class="form-check-input" type="checkbox" id="confirmTransfer" required>
                                                    <label class="form-check-label fw-bold text-danger" for="confirmTransfer">
                                                        Tôi xác nhận đã chuyển khoản thành công
                                                    </label>
                                                    <small class="d-block text-muted mt-1">Vui lòng chỉ tích chọn sau khi bạn đã thực hiện chuyển khoản.</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
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
                                    <span class="fw-bold fs-5" id="summaryLabel">Tổng cộng</span>
                                    <strong class="text-primary fs-4" id="summaryTotal">{{ number_format($total, 0, ',', '.') }}đ</strong>
                                </div>
                                
                                <!-- Payment on Delivery Amount (Hidden by default) -->
                                <div class="d-flex justify-content-between mb-3 d-none" id="remainingPaymentRow">
                                    <span class="text-muted fw-bold">Thanh toán khi nhận hàng (70%)</span>
                                    <strong class="text-dark fs-5" id="remainingAmountDisplay"></strong>
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
const totalAmount = {{ $total }};
const depositReq = Math.round(totalAmount * 0.3);
const remainingAmount = totalAmount - depositReq;

// Payment Method Toggle
const confirmCheckbox = document.getElementById('confirmTransfer');
const orderBtn = document.getElementById('placeOrderBtn');

function toggleOrderButtonState() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if (paymentMethod === 'deposit') {
        if (confirmCheckbox.checked) {
            orderBtn.disabled = false;
            orderBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Xác nhận đã chuyển khoản';
            orderBtn.classList.remove('btn-secondary');
            orderBtn.classList.add('btn-success');
        } else {
            orderBtn.disabled = true;
            orderBtn.innerHTML = 'Vui lòng xác nhận chuyển khoản';
            orderBtn.classList.remove('btn-success');
            orderBtn.classList.add('btn-secondary');
        }
    } else {
        // COD
        orderBtn.disabled = false;
        orderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Đặt hàng';
        orderBtn.classList.remove('btn-success', 'btn-secondary');
        orderBtn.classList.add('btn-primary');
    }
}

document.querySelectorAll('input[name="payment_method"]').forEach(input => {
    input.addEventListener('change', function() {
        const depositInfo = document.getElementById('depositInfo');
        const summaryTotal = document.getElementById('summaryTotal');
        const summaryLabel = document.getElementById('summaryLabel');
        
        if (this.value === 'deposit') {
            depositInfo.classList.remove('d-none');
            // Uncheck verification by default when switching
            confirmCheckbox.checked = false;
            
            // Format amounts
            const depositFormatted = new Intl.NumberFormat('vi-VN').format(depositReq) + 'đ';
            
            // Update UI text
            document.getElementById('depositAmountDisplay').innerHTML = `Số tiền cọc: <span class="fs-5 text-danger fw-bold">${depositFormatted}</span>`;
            
            // Generate QR Code
            const qrUrl = `https://img.vietqr.io/image/MB-0783704196-compact2.png?amount=${depositReq}&addInfo=COC%20DON%20HANG&accountName=TRAN%20THANH%20TUAN`;
            document.getElementById('qrCodeImage').src = qrUrl;
            
            // Update Summary
            if(summaryLabel) summaryLabel.textContent = "Cần thanh toán ngay (30%)";
            if(summaryTotal) summaryTotal.textContent = depositFormatted;

            // Show Remaining Amount
            const remainingRow = document.getElementById('remainingPaymentRow');
            const remainingDisplay = document.getElementById('remainingAmountDisplay');
            const remainingFormatted = new Intl.NumberFormat('vi-VN').format(remainingAmount) + 'đ';
            
            if(remainingRow) remainingRow.classList.remove('d-none');
            if(remainingDisplay) remainingDisplay.textContent = remainingFormatted;
            
        } else {
            depositInfo.classList.add('d-none');
            
            // Revert summary to full total
            const totalFormatted = new Intl.NumberFormat('vi-VN').format(totalAmount) + 'đ';
            if(summaryLabel) summaryLabel.textContent = "Tổng cộng";
            if(summaryTotal) summaryTotal.textContent = totalFormatted;

            // Hide Remaining Amount
            const remainingRow = document.getElementById('remainingPaymentRow');
            if(remainingRow) remainingRow.classList.add('d-none');
        }
        
        toggleOrderButtonState();
    });
});

// Checkbox Listener
if(confirmCheckbox) {
    confirmCheckbox.addEventListener('change', toggleOrderButtonState);
}

function placeOrder() {
    const form = document.getElementById('checkoutForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Get Payment Method
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if (paymentMethod === 'deposit' && !confirmCheckbox.checked) {
        alert('Vui lòng xác nhận bạn đã chuyển khoản trước khi tiếp tục!');
        return;
    }
    
    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
    
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data.payment_method = paymentMethod;

    fetch('{{ route("checkout.placeOrder") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            let msg = 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm.';
            if (paymentMethod === 'deposit') {
                msg = 'Đã nhận xác nhận chuyển khoản! Đơn hàng của bạn đang được xử lý.';
            }
            alert(msg);
            window.location.href = '/';
        } else {
            alert(result.message || 'Có lỗi xảy ra, vui lòng thử lại');
            btn.disabled = false;
            toggleOrderButtonState();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi kết nối, vui lòng thử lại');
        btn.disabled = false;
        toggleOrderButtonState();
    });
}
</script>
@endpush

