@extends('layouts.app')

@section('title', 'Giỏ hàng')
@section('meta_description', 'Các sản phẩm trong giỏ hàng.')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">Giỏ hàng</h1>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 3; $i++)
                        <tr>
                            <td>Sản phẩm {{ $i }}</td>
                            <td>{{ number_format(199000 + $i * 5000) }}đ</td>
                            <td style="width: 120px;"><input type="number" class="form-control" value="1" min="1"></td>
                            <td>{{ number_format(199000 + $i * 5000) }}đ</td>
                            <td><button class="btn btn-sm btn-outline-danger">Xóa</button></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <div style="min-width: 260px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính</span>
                        <strong>628.000đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển</span>
                        <strong>30.000đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tổng cộng</span>
                        <strong>658.000đ</strong>
                    </div>
                    <a href="/checkout" class="btn btn-primary w-100">Thanh toán</a>
                </div>
            </div>
        </div>
    </section>
@endsection
