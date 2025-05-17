@extends('layouts.app')
@section('title', 'Quản lý loại nội thất')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" style="padding-left: 0;">
            <div class="ibox float-e-margins">
                <div class="ibox-title my-ibox-title">
                    <h2>Danh sách loại nội thất</h2>
                    <button class="btn btn-success" data-toggle="modal" data-target="#addLNTModal"><i class="fa fa-plus"></i> Thêm loại nội thất</button>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-lnt">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên loại</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loainoithats as $lnt)
                                <tr class="gradeX">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $lnt->tenloai}}</td>
                                    <td class="text-center" style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                                        <button class="btn btn-warning btn-sm edit-btn"
                                            data-tooltip="Cập nhật"
                                            data-id="{{ $lnt->id }}"
                                            data-toggle="modal"
                                            data-target="#editLNTModal">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-btn"
                                            data-tooltip="Xóa"
                                            data-id="{{ $lnt->id }}"
                                            data-toggle="modal"
                                            data-target="#deleteLNTModal">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('quanlynoithat.loainoithat.partials.modals')
@endsection
@section('js')
<script>
    $(document).ready(function() {
        // Xử lý nút sửa đơn vị
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            // Lấy thông tin đơn vị qua AJAX
            $.ajax({
                url: '{{ route("loainoithat.edit", ":id") }}'.replace(':id', id),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Điền thông tin vào form
                    $('input[name="tenloai"]').val(response.loainoithat.tenloai);
                    // Cập nhật action của form
                    $('#editForm').attr('action', '{{ route("loainoithat.update", ":id") }}'.replace(':id', id));
                },
                error: function(xhr) {
                    console.log('Đã xảy ra lỗi khi lấy thông tin đơn vị');
                }
            });
        });

        // Xử lý nút xóa
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("loainoithat.destroy", ":id") }}'.replace(':id', id);
            $('#deleteForm').attr('action', url);
        });
        // Khởi tạo DataTables
        $('.dataTables-lnt').DataTable({
            pageLength: 10,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            order: [], // Không sắp xếp mặc định
            columnDefs: [{
                orderable: false,
                targets: [0, 2], // Không sắp xếp cột STT và Thao tác
                className: 'text-center' // Căn giữa cho cột STT
            }],
            // Tính toán lại STT dựa trên trang hiện tại
            drawCallback: function(settings) {
                var api = this.api();
                var startIndex = api.context[0]._iDisplayStart;

                api.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = startIndex + i + 1;
                });
            },
            fixedHeader: true,
            dom: "<'row mb-3'" +
                "<'col-md-4'l>" + // show entries
                "<'col-md-4 text-center'B>" + // buttons
                "<'col-md-4 d-flex justify-content-end'f>" + // search về phải
                ">" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    charset: 'utf-8',
                    bom: true //  THÊM DÒNG NÀY để fix lỗi font
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    filename: 'Danh sách loại nội thất',
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Danh sách loại nội thất',
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'print',
                    title: 'Danh sách loại nội thất',

                    customize: function(win) {
                        $(win.document.body).addClass('white-bg').css('font-size', '10px');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                }
            ]
        });
    });
</script>
@endsection