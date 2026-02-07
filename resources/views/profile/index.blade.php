@extends('layouts.app')

@section('title', 'Tài khoản')
@section('meta_description', 'Thông tin tài khoản người dùng.')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Hồ sơ</h5>
                            <p class="text-muted mb-0">Nguyễn Văn A</p>
                            <p class="text-muted">you@email.com</p>
                            <button class="btn btn-outline-secondary btn-sm">Chỉnh sửa</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Đơn hàng gần đây</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Ngày</th>
                                            <th>Trạng thái</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#DH001</td>
                                            <td>12/02/2026</td>
                                            <td><span class="badge bg-success">Hoàn tất</span></td>
                                            <td>658.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>#DH002</td>
                                            <td>05/02/2026</td>
                                            <td><span class="badge bg-warning text-dark">Đang xử lý</span></td>
                                            <td>399.000đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
