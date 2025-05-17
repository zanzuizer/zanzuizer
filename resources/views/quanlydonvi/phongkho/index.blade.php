@extends('layouts.app')
@section('title', 'Quản lý phòng kho')
@section('css')
<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" style="padding-left: 0;">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="my-ibox-title">
                        <h2>Danh sách phòng kho</h2>
                        <div class="gap-2 d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary me-2" data-toggle="modal" data-target="#importExcelModal"><i class="fa fa-file-excel-o"></i> Thêm kho bằng excel</button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addPKModal"><i class="fa fa-plus"></i> Thêm kho</button>
                        </div>
                    </div>
                    <div style="padding: 20px 0">
                        <label for="donvi-filter" style="white-space: nowrap;">Đơn vị quản lý</label>
                        <select id="donvi-filter" class="form-control">
                            <option value="">Tất cả đơn vị</option>
                            @foreach($donvis as $donvi)
                            <option value="{{ $donvi->id }}">{{ $donvi->tendonvi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- <div class="ibox-title my-ibox-title" style="padding: 10px 25px 10px 20px;">
                    <label for="donvi-filter" style="white-space: nowrap;">Đơn vị quản lý</label>
                    <select id="donvi-filter" class="form-control">
                        <option value="">Tất cả đơn vị</option>
                        @foreach($donvis as $donvi)
                        <option value="{{ $donvi->id }}">{{ $donvi->tendonvi }}</option>
                        @endforeach
                    </select>
                </div> -->
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-phongkho" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã phòng</th>
                                    <th>Tên phòng</th>
                                    <th>Khu</th>
                                    <th>Lầu</th>
                                    <th>Số phòng</th>
                                    <th>Giáo viên quản lý</th>
                                    <th>Đơn vị</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($phongkhos as $phongkho)
                                <tr class="gradeX">
                                    <td></td>
                                    <td>{{ $phongkho->maphong }}</td>
                                    <td>{{ $phongkho->tenphong }}</td>
                                    <td>{{ $phongkho->khu }}</td>
                                    <td>{{ $phongkho->lau}}</td>
                                    <td>{{ $phongkho->sophong}}</td>
                                    <td>{{ $phongkho->taikhoan->hoten ?? '' }}</td>
                                    <td>{{ $phongkho->donvi->tendonvi ?? '' }}</td>
                                    <td class="text-center" style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                                        <a href="#" class="btn btn-warning btn-sm edit-btn"
                                            data-tooltip="Cập nhật"
                                            data-id="{{ $phongkho->id }}"
                                            data-toggle="modal"
                                            data-target="#editPKModal">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm delete-btn"
                                            data-tooltip="Xóa"
                                            data-id="{{ $phongkho->id }}"
                                            data-toggle="modal"
                                            data-target="#deletePKModal">
                                            <i class="fa fa-trash"></i>
                                        </a>
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
@include('quanlydonvi.phongkho.partials.modals')
@endsection
@section('js')
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        // Xử lý nút sửa đơn vị
        $('.edit-btn').click(function() {
            var id = $(this).data('id');

            // Lấy thông tin đơn vị qua AJAX
            $.ajax({
                url: '{{ route("phongkho.edit", ":id") }}'.replace(':id', id),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Điền thông tin vào form
                    $('#edit-maphong').val(response.phongkho.maphong);
                    $('#edit-tenphong').val(response.phongkho.tenphong);
                    $('#edit-khu').val(response.phongkho.khu);
                    $('#edit-lau').val(response.phongkho.lau);
                    $('#edit-sophong').val(response.phongkho.sophong);
                    $('#edit-magvql').val(response.phongkho.magvql);
                    $('#edit-madonvi').val(response.phongkho.madonvi);
                    // Cập nhật action của form
                    $('#editForm').attr('action', '{{ route("phongkho.update", ":id") }}'.replace(':id', id));
                },
                error: function(xhr) {
                    console.log('Lỗi', xhr);
                    showToast('error', 'Đã xảy ra lỗi khi lấy thông tin phòng kho');
                }
            });
        });

        // Xử lý nút xóa
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("phongkho.destroy", ":id") }}'.replace(':id', id);
            $('#deleteForm').attr('action', url);
        });
        // Khởi tạo DataTables
        $('.dataTables-phongkho').DataTable({
            pageLength: 10,
            responsive: true,
            order: [], // Không sắp xếp mặc định
            columnDefs: [{
                orderable: false,
                targets: [0, 8], // Không sắp xếp cột STT và Thao tác
                className: 'text-center' // Căn giữa cho cột STT
            }],
            fixedHeader: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
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
                    // Thêm nút xuất CSV với encoding khác
                    text: 'CSV',
                    action: function(e, dt, button, config) {
                        // Lấy dữ liệu từ bảng
                        var data = dt.buttons.exportData();

                        // Tạo nội dung CSV
                        var csv = '';

                        // Thêm tiêu đề
                        for (var i = 0; i < data.header.length; i++) {
                            csv += '"' + data.header[i] + '"';
                            if (i < data.header.length - 1) {
                                csv += ',';
                            }
                        }
                        csv += '\r\n';

                        // Thêm dữ liệu
                        for (var i = 0; i < data.body.length; i++) {
                            for (var j = 0; j < data.body[i].length; j++) {
                                csv += '"' + data.body[i][j] + '"';
                                if (j < data.body[i].length - 1) {
                                    csv += ',';
                                }
                            }
                            csv += '\r\n';
                        }

                        // Tạo Blob với BOM
                        var blob = new Blob(['\ufeff' + csv], {
                            type: 'text/csv;charset=utf-8;'
                        });

                        // Tạo URL và tải xuống
                        var url = window.URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.setAttribute('hidden', '');
                        a.setAttribute('href', url);
                        a.setAttribute('download', 'Danh_sach_phong_kho.csv');
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel', // Không dùng title mặc định
                    filename: 'Danh_sach_phong_kho', // Tên file xuất ra
                    title: 'Danh sách phòng kho', // Tiêu đề trong file Excel
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7] // In ra tất cả các cột trừ cột thao tác
                    },
                    format: {
                        // Định dạng lại cột STT để đảm bảo nó được xuất ra
                        body: function(data, row, column, node) {
                            // Nếu là cột STT (cột 0) và không có giá trị
                            if (column === 0 && !data) {
                                return row + 1; // Trả về số thứ tự
                            }
                            return data; // Các cột khác giữ nguyên
                        }
                    },
                    // Đảm bảo rằng file Excel được xuất ra với định dạng UTF-8
                    charset: 'utf-8', // Đảm bảo encoding UTF-8

                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        var styles = xlsx.xl['styles.xml'];

                        // Đẩy toàn bộ các row xuống 1 hàng (dòng 2 trở đi)
                        $('row', sheet).each(function() {
                            var r = parseInt($(this).attr('r'));
                            $(this).attr('r', r + 1);
                            $(this).find('c').each(function() {
                                var cellRef = $(this).attr('r');
                                var col = cellRef.replace(/[0-9]/g, '');
                                var row = parseInt(cellRef.replace(/[A-Z]/g, '')) + 1;
                                $(this).attr('r', col + row);
                            });
                        });

                        // Thêm dòng tiêu đề chính ở A1
                        var title = `
            <row r="1">
                <c t="inlineStr" r="A1" s="50">
                    <is><t>Danh sách phòng kho</t></is>
                </c>
            </row>
        `;
                        sheet.getElementsByTagName('sheetData')[0].innerHTML = title + sheet.getElementsByTagName('sheetData')[0].innerHTML;

                        // Merge A1 và B1
                        var mergeCells = sheet.getElementsByTagName('mergeCells')[0];
                        if (!mergeCells) {
                            mergeCells = sheet.createElement('mergeCells');
                            sheet.getElementsByTagName('worksheet')[0].appendChild(mergeCells);
                        }

                        var mergeCell = sheet.createElement('mergeCell');
                        mergeCell.setAttribute('ref', 'A1:G1');
                        mergeCells.appendChild(mergeCell);
                        mergeCells.setAttribute('count', mergeCells.getElementsByTagName('mergeCell').length);

                        // Thêm style căn giữa với font-size cho title
                        var cellXfs = styles.getElementsByTagName('cellXfs')[0];
                        var newStyle = `
                                    <xf xfId="0" applyAlignment="1" applyFont="1">
                                        <alignment horizontal="center" vertical="center"/>
                                        <font><sz val="22"/><b/></font>
                                    </xf>
                                `;
                        var headerStyle = `
                                    <xf xfId="0" applyAlignment="1" applyFont="1">
                                        <alignment horizontal="center"/>
                                        <font><sz val="16"/><b/></font>
                                    </xf>
                                `;

                        cellXfs.innerHTML += newStyle + headerStyle;

                        // Gán style: dòng 1 (title) dùng style index 50, dòng 2 (header) dùng style index 51
                        $('row[r="2"] c', sheet).attr('s', '51'); // STT, Tên đơn vị
                        $('row[r="1"] c[r="A1"]', sheet).attr('s', '50'); // Danh sách đơn vị

                    }

                },
                {
                    extend: 'pdf',
                    title: 'Danh sách phòng kho',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7] // In ra cột thứ 1->7 (đánh số từ 0)
                    }
                },
                {
                    extend: 'print',
                    title: 'Danh sách phòng kho',

                    customize: function(win) {
                        $(win.document.body).addClass('white-bg').css('font-size', '10px');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                }
            ]
        });
        // Lọc theo đơn vị
        $('#donvi-filter').change(function() {
            var selectedValue = $(this).val();
            console.log("Selected Value:", selectedValue);

            // Lấy đối tượng DataTable
            var table = $('.dataTables-phongkho').DataTable();

            if (selectedValue === '') {
                // Nếu không chọn đơn vị nào, hiển thị tất cả
                table.column(7).search('').draw();
            } else {
                // Lấy text của option được chọn (tên đơn vị)
                var selectedText = $(this).find('option:selected').text();
                console.log('Selected Text:', selectedText);

                // Tìm kiếm theo tên đơn vị (cột 7)
                table.column(7).search(selectedText).draw();
            }
        });
    })
</script>
@endsection