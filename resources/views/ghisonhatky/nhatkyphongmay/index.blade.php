@extends('layouts.app')
@section('title', 'Nhật ký phòng máy')
@section('css')
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="header">
    <h2 style="padding-left: 15px;">Nhật ký phòng máy</h2>
</div>
<div class="col-lg-12">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">Nhật ký sử dụng</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Danh sách thiết bị</a></li>
            <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Bảo trì sửa chữa</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <div class="row">
                        <!-- Bên trái: Sơ đồ phòng máy -->
                        <div class="col-md-6 col-sm-12 text-center" style="margin-bottom: 20px;">
                            <div style="background: #f8f9fa; border: 1px solid #ccc; padding: 25px; border-radius: 10px;">
                                <h4 class="text-center" style="color: #dc3545; font-weight: bold;">SƠ ĐỒ PHÒNG MÁY</h4>
                                <div class="room-map">
                                    <p id="noMap" class="hidden text-center" style="font-size: 18px;">Chưa có sơ đồ phòng máy!</p>
                                    <!-- Dùng flex thay vì grid cho Bootstrap 3 -->
                                    <div id="hasMap" class="machine-grid"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div style="padding: 20px;">
                                <p class="text-right" style="margin-top: -18px; color: black;">
                                    GIÁO VIÊN QUẢN LÝ: <strong id="gvql" style="color: red;"></strong>
                                </p>

                                <div class="form-group">
                                    <label for="hockySearch">HỌC KỲ</label>
                                    <select id="hockySearch" name="idhocky" class="form-control">
                                        @foreach($hockys->reverse() as $hk)
                                        <option value="{{ $hk->id }}" @if($hk==$hockysCurrent) selected @endif>
                                            Học kỳ {{ $hk->hocky }} ({{ $hk->tunam }} - {{ $hk->dennam }})
                                            @if($hk == $hockysCurrent) - Học kỳ hiện tại @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group autocomplete">
                                    <label for="phongSearch">PHÒNG MÁY</label>
                                    <input id="phongSearch" required type="text" class="form-control" name="phongSearch"
                                        placeholder="Nhập tên phòng (VD: A201)">
                                </div>

                                <div class="row" style="margin-top: 15px;">
                                    <!-- <div class="col-xs-12 col-sm-4">
                                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#addModalOld">
                                            <i class="fa fa-calendar"></i> Thêm lịch cũ
                                        </a>
                                    </div> -->
                                    <div class="col-xs-12 col-sm-4">
                                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#addModalNew">
                                            <i class="fa fa-calendar-plus-o"></i> Thêm lịch sử dụng
                                        </a>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalPrint">
                                            <i class="fa fa-print"></i> In sổ nhật ký
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bảng nhật ký -->
                    @include('ghisonhatky.nhatkyphongmay.partials.table')
                </div>
            </div>
            <div id="tab-2" class="tab-pane">
                <div class="panel-body">
                </div>
            </div>
            <div id="tab-3" class="tab-pane">
                <div class="panel-body">
                    <strong>dsad</strong>
                    <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among the stalks, and grow familiar with the countless indescribable forms of the insects
                        and flies, then I feel the presence of the Almighty, who formed us in his own image, and the breath </p>

                    <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                        sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet.</p>
                </div>
            </div>
        </div>
        @include('ghisonhatky.nhatkyphongmay.partials.statusPC')
        @include('ghisonhatky.nhatkyphongmay.partials.create')
        @include('ghisonhatky.nhatkyphongmay.partials.edit')
        @include('ghisonhatky.nhatkyphongmay.partials.delete')

    </div>
</div>
@endsection