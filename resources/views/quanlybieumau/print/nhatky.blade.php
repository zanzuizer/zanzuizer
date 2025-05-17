@extends('layouts.print')

@section('title', 'In nhật ký phòng máy')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1>NHẬT KÝ PHÒNG MÁY</h1>
        <h3>{{ $khoa->tendonvi }}</h3>
        <h4>{{ $phong->tenphong }}</h4>
    </div>

    <div class="mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên thiết bị</th>
                    <th>Mã số</th>
                    <th>Năm sản xuất</th>
                    <th>Nội dung bảo trì</th>
                    <th>Thời gian bảo trì</th>
                    <th>Thời gian thực hiện</th>
                    <th>Đơn vị thực hiện</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nhatky as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->ten_tb }}</td>
                    <td>{{ $item->maso }}</td>
                    <td>{{ $item->namsx }}</td>
                    <td>{{ $item->nd_baotri }}</td>
                    <td>{{ $item->tg_baotri }}</td>
                    <td>{{ $item->tg_thuchien }}</td>
                    <td>{{ $item->dv_thuchien }}</td>
                    <td>{{ $item->ghichu }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Không có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection