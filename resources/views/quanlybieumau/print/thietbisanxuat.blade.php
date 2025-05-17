@extends('layouts.print')

@section('title', 'Sổ Thiết Bị Sản Xuất')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h1>SỔ THIẾT BỊ SẢN XUẤT</h1>
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
                    <th>Nhà sản xuất</th>
                    <th>Công suất</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($thietbis as $key => $thietbi)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $thietbi->tenthietbi }}</td>
                    <td>{{ $thietbi->mathietbi }}</td>
                    <td>{{ $thietbi->namsx }}</td>
                    <td>{{ $thietbi->nhasx ?? 'N/A' }}</td>
                    <td>{{ $thietbi->congsuat ?? 'N/A' }}</td>
                    <td>{{ $thietbi->tinhtrang }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Không tìm thấy dữ liệu thiết bị sản xuất</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-6 text-center">
            <p>Người lập</p>
            <p>(Ký, ghi rõ họ tên)</p>
        </div>
        <div class="col-md-6 text-center">
            <p>Trưởng đơn vị</p>
            <p>(Ký, ghi rõ họ tên)</p>
        </div>
    </div>
</div>
@endsection