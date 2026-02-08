@extends('layouts.app')

@section('title', 'Tài khoản của tôi')
@section('meta_description', 'Thông tin tài khoản người dùng và lịch sử đơn hàng.')

@section('content')
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h1 class="mb-4">Tài khoản của tôi</h1>
            <div class="row g-4">
                <!-- Sidebar Profile -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body text-center py-4">
                            <div class="mb-3 position-relative d-inline-block">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff&size=128" class="rounded-circle shadow-sm" alt="Avatar">
                            </div>
                            <h5 class="card-title fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-3 small">{{ $user->email }}</p>
                            
                            <div class="d-grid gap-2 mt-4">
                                @if($user->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning text-white fw-bold"><i class="fas fa-shield-alt me-2"></i>Trang quản trị</a>
                                @endif
                                
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();" class="btn btn-outline-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                </a>
                                <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Orders -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white py-3 border-bottom-0">
                            <h5 class="card-title fw-bold mb-0 text-primary"><i class="fas fa-history me-2"></i>Lịch sử đơn hàng</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($orders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light text-muted small text-uppercase">
                                            <tr>
                                                <th scope="col" class="ps-4 py-3">Mã đơn</th>
                                                <th scope="col" class="py-3">Ngày đặt</th>
                                                <th scope="col" class="py-3">Trạng thái</th>
                                                <th scope="col" class="py-3">Thanh toán</th>
                                                <th scope="col" class="text-end pe-4 py-3">Tổng tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td class="ps-4 fw-bold text-primary">#{{ $order->id }}</td>
                                                <td class="small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($order->status == 'completed')
                                                        <span class="badge bg-success rounded-pill">Hoàn thành</span>
                                                    @elseif($order->status == 'pending')
                                                        <span class="badge bg-warning text-dark rounded-pill">Chờ xử lý</span>
                                                    @elseif($order->status == 'cancelled')
                                                        <span class="badge bg-danger rounded-pill">Đã hủy</span>
                                                    @else
                                                        <span class="badge bg-secondary rounded-pill">{{ ucfirst($order->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->payment_method == 'cod')
                                                        <span class="badge bg-light text-dark border">COD</span>
                                                    @elseif($order->payment_method == 'deposit')
                                                        <span class="badge bg-primary">Cọc 30%</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $order->payment_method }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-end pe-4 fw-bold">{{ number_format($order->total_amount ?? 0, 0, ',', '.') }}đ</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-shopping-bag fa-3x text-muted opacity-25"></i>
                                    </div>
                                    <h6 class="text-muted fw-normal">Bạn chưa có đơn hàng nào</h6>
                                    <p class="small text-muted mb-4">Hãy khám phá các sản phẩm tuyệt vời của chúng tôi</p>
                                    <a href="{{ url('/shop') }}" class="btn btn-primary px-4 rounded-pill">Mua sắm ngay</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
