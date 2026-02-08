@extends('layouts.app')

@section('title', 'Giảm giá')
@section('meta_description', 'Chương trình khuyến mãi và giảm giá.')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-danger mb-3">🔥 Flash Sale</h1>
        <p class="lead text-muted">Săn deal hot giá sốc - Số lượng có hạn!</p>
        <div class="d-inline-flex align-items-center bg-danger text-white px-4 py-2 rounded-pill shadow-sm">
            <i class="far fa-clock me-2"></i> Kết thúc trong: <span class="fw-bold ms-2" id="countdown">04:12:36</span>
        </div>
    </div>

    @if(isset($products) && $products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-6">
                @include('partials.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3 opacity-50"></i>
            <h3 class="h5 text-muted">Chưa có sản phẩm khuyến mãi</h3>
            <p class="text-muted">Vui lòng quay lại sau.</p>
            <a href="{{ url('/shop') }}" class="btn btn-outline-primary rounded-pill mt-3">
                Xem tất cả sản phẩm
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Simple Countdown
    function startTimer(duration, display) {
        var timer = duration, hours, minutes, seconds;
        setInterval(function () {
            hours = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = hours + ":" + minutes + ":" + seconds;

            if (--timer < 0) {
                timer = duration;
            }
        }, 1000);
    }

    window.onload = function () {
        var time = 4 * 3600 + 12 * 60 + 36, // 4h 12m 36s
            display = document.querySelector('#countdown');
        if(display) startTimer(time, display);
    };


</script>
@endpush
