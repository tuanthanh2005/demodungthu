@extends('layouts.app')

@section('title', 'Giỏ Hàng Của Bạn')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center section-title">Giỏ Hàng Của Bạn</h1>

    @if(session('cart'))
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0 py-3 ps-4" style="width: 40%">Sản phẩm</th>
                                    <th scope="col" class="border-0 py-3 text-center" style="width: 15%">Giá</th>
                                    <th scope="col" class="border-0 py-3 text-center" style="width: 20%">Số lượng</th>
                                    <th scope="col" class="border-0 py-3 text-end pe-4" style="width: 15%">Tổng</th>
                                    <th scope="col" class="border-0 py-3" style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(session('cart') as $id => $details)
                                    <tr data-id="{{ $id }}">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $details['image'] }}" width="80" height="80" class="rounded me-3 object-fit-cover" alt="{{ $details['name'] }}">
                                                <div>
                                                    <h6 class="mb-1 text-truncate" style="max-width: 200px;">{{ $details['name'] }}</h6>
                                                    <small class="text-muted d-block">Size: {{ $details['size'] }}</small>
                                                    <small class="text-muted">Màu: {{ $details['color'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold text-primary">{{ number_format($details['price'], 0, ',', '.') }}đ</td>
                                        <td class="text-center">
                                            <div class="input-group input-group-sm mx-auto" style="width: 100px;">
                                                <button class="btn btn-outline-secondary btn-update-qty" type="button" data-action="decrease">-</button>
                                                <input type="number" value="{{ $details['quantity'] }}" class="form-control text-center quantity-input" min="1">
                                                <button class="btn btn-outline-secondary btn-update-qty" type="button" data-action="increase">+</button>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold pe-4 subtotal">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ</td>
                                        <td class="text-center">
                                            <button class="btn btn-link text-danger remove-from-cart p-0" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ url('/shop') }}" class="btn btn-outline-primary rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Tổng Giỏ Hàng</h5>
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-bold fs-5 cart-total">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Phí vận chuyển</span>
                            <span class="text-success fw-bold">Miễn phí</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Tổng cộng</span>
                            <span class="fw-bold fs-4 text-primary cart-grand-total">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <a href="{{ url('/checkout') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">
                            Tiến hành thanh toán <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        
                        <div class="mt-4">
                            <div class="alert alert-info d-flex gap-3 align-items-center mb-0" role="alert">
                                <i class="fas fa-shield-alt fs-4"></i>
                                <div>
                                    <small class="fw-bold d-block">Thanh toán an toàn</small>
                                    <small>Thông tin của bạn được bảo mật tuyệt đối.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-2130356-1800917.png" alt="Empty Cart" style="width: 200px; opacity: 0.7;">
            <h3 class="mt-4 text-muted">Giỏ hàng trống</h3>
            <p class="mb-4 text-muted">Bạn chưa thêm sản phẩm nào vào giỏ hàng.</p>
            <a href="{{ url('/shop') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                <i class="fas fa-shopping-bag me-2"></i> Mua sắm ngay
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update Quantity via AJAX
        document.querySelectorAll('.btn-update-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                const input = this.parentElement.querySelector('input');
                let currentValue = parseInt(input.value);
                
                if (action === 'increase') {
                    currentValue++;
                } else if (action === 'decrease' && currentValue > 1) {
                    currentValue--;
                }
                
                input.value = currentValue;
                updateCart(this.closest('tr').dataset.id, currentValue);
            });
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                let val = parseInt(this.value);
                if(val < 1) val = 1;
                this.value = val;
                updateCart(this.closest('tr').dataset.id, val);
            });
        });

        function updateCart(id, quantity) {
            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                // Update subtotal cell
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if(row) {
                    row.querySelector('.subtotal').textContent = data.subtotal;
                }
                // Update totals
                document.querySelector('.cart-total').textContent = data.total;
                document.querySelector('.cart-grand-total').textContent = data.total;
            });
        }

        // Remove from Cart
        document.querySelectorAll('.remove-from-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                if(confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                    const row = this.closest('tr');
                    const id = row.dataset.id;
                    
                    fetch('{{ route('cart.remove') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        row.remove();
                        document.querySelector('.cart-total').textContent = data.total;
                        document.querySelector('.cart-grand-total').textContent = data.total;
                        
                        // Update cart count badge in header instantly if possible
                        // Or reload page if empty
                        if(data.cart_count === 0) {
                            location.reload(); 
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
