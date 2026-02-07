@extends('layouts.app')

@section('title', 'Thanh toán')
@section('meta_description', 'Thông tin thanh toán đơn hàng.')

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">Thanh toán</h1>
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Thông tin giao hàng</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Họ và tên">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Số điện thoại">
                                </div>
                                <div class="col-12">
                                    <input class="form-control" placeholder="Email">
                                </div>
                                <div class="col-12">
                                    <input class="form-control" placeholder="Địa chỉ">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Tỉnh/Thành phố">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Quận/Huyện">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="3" placeholder="Ghi chú"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Đơn hàng</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính</span>
                                <strong>628.000đ</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển</span>
                                <strong>30.000đ</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tổng cộng</span>
                                <strong>658.000đ</strong>
                            </div>
                            <button class="btn btn-primary w-100">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
