@extends('layouts.app')

@section('title', 'Biểu mẫu thiết bị')

@section('css')
<style>
    .ibox-title h2 {
        font-size: 24px;
        margin: 6px 0;
        color: #2f4050;
    }
    
    .dataTables-example {
        margin-top: 10px;
    }
    
    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.428571429;
    }
    
    .btn-themmoi {
        float: right;
        margin-bottom: 10px;
    }

    /* Thêm khoảng cách giữa các phần tử */
    .dataTables_wrapper .dataTables_length {
        padding-bottom: 10px;
    }
    
    .actions-container {
        background-color: #f9f9f9;
        padding: 10px;
        border-top: none;
    }
    
    .action-row td {
        padding-top: 0 !important;
    }
    
    /* Thêm style cho nút khi active */
    .btn-circle.active {
        background-color: #f8ac59;
        border-color: #f8ac59;
    }
    
    /* Đồng bộ màu sắc với các trang quản lý khác */
    .btn-primary {
        background-color: #f8ac59;
        border-color: #f8ac59;
    }
    
    .btn-primary:hover, 
    .btn-primary:focus, 
    .btn-primary:active {
        background-color: #e8a04b;
        border-color: #e8a04b;
    }
    
    .btn-danger {
        background-color: #ed5565;
        border-color: #ed5565;
    }
    
    .btn-info {
        background-color: #23c6c8;
        border-color: #23c6c8;
    }
    
    /* Style cho các nút thao tác theo ảnh minh họa */
    .action-buttons .btn {
        margin: 2px;
    }
    
    .btn-edit {
        background-color: #f8ac59;
        border-color: #f8ac59;
        color: white;
    }
    
    .btn-edit:hover {
        background-color: #e8a04b;
        border-color: #e8a04b;
        color: white;
    }
    
    .btn-delete {
        background-color: #ed5565;
        border-color: #ed5565;
        color: white;
    }
      .btn-delete:hover {
        background-color: #dd4455;
        border-color: #dd4455;
        color: white;
    }
    
    /* Style cho cột action */
    .action-btns {
        min-width: 150px;
    }
    
    /* Fixed cho bảng DataTables để nút thao tác hiển thị đúng */
    .dataTables-bieumau td.action-btns {
        white-space: nowrap;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>DANH SÁCH BIỂU MẪU</h2>
                </div>
                <div class="ibox-content">
                    <div class="btn-themmoi">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                            <i class="fa fa-plus"></i> Thêm mới
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-bieumau">
                            <thead>                                <tr>
                                    <th>STT</th>
                                    <th>Tên biểu mẫu</th>
                                    <th>Tên tập tin</th>
                                    <th style="width: 120px;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bieumaus as $bm)
                                <tr class="gradeX">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bm->tenbieumau }}</td>
                                    <td>{{ $bm->tentaptin }}</td>                                    <td class="text-center action-btns">
                                        <div style="display: flex; justify-content: center; gap: 5px;">
                                            <!-- Nút chỉnh sửa -->
                                            <a href="{{ route('bieumau.thietbi.edit', $bm->id) }}" class="btn btn-warning btn-sm action-btn" title="Chỉnh sửa">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            
                                            <!-- Nút xóa -->
                                            <button class="btn btn-danger btn-sm delete-btn" 
                                                data-id="{{ $bm->id }}" 
                                                title="Xóa">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                      <!-- Modal Xóa Biểu Mẫu -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Xác nhận xóa</h4>
                                </div>
                                <form id="deleteForm" action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa biểu mẫu này không?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tải lên biểu mẫu mới</h4>
            </div>
            <form action="{{ route('bieumau.thietbi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">                    <div class="form-group">
                        <label for="tenbieumau">Tên biểu mẫu</label>
                        <input type="text" class="form-control" id="tenbieumau" name="tenbieumau" required>
                    </div>
                    <div class="form-group">
                        <label for="file">Tập tin</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                        <p class="help-block">Chỉ hỗ trợ file PDF, DOC, DOCX</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>    $(document).ready(function(){        // Xử lý nút xóa - sử dụng event delegation để bắt sự kiện cho các phần tử mới được tạo bởi DataTables
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            var url = '{{ route("bieumau.thietbi.destroy", ":id") }}'.replace(':id', id);
            $('#deleteForm').attr('action', url);
            $('#deleteModal').modal('show');
        });
        
        // Xử lý nút chỉnh sửa
        $(document).on('click', '.edit-btn', function(e) {
            // Không cần ngăn chặn hành vi mặc định vì chúng ta muốn nút chuyển hướng đến trang chỉnh sửa
            console.log("Đã nhấn nút chỉnh sửa");
        });// Khởi tạo DataTables
        var table = $('.dataTables-bieumau').DataTable({
            pageLength: 10,
            responsive: true,
            processing: true, // Hiển thị thông báo khi xử lý
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Tất cả"]
            ],
            order: [], // Không sắp xếp mặc định
            columnDefs: [{
                orderable: false,
                targets: [0, 3], // Không sắp xếp cột STT và Thao tác
                className: 'text-center' // Căn giữa cho cột STT và Thao tác
            }],
            createdRow: function(row, data, index) {
                // Đảm bảo các nút trong cột thao tác được hiển thị đúng
                $('td:eq(3)', row).addClass('action-btns');
            },
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
                    extend: 'copy',
                    text: 'Sao chép'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    charset: 'utf-8',
                    bom: true // Thêm BOM để fix lỗi font tiếng Việt
                },
                {                    extend: 'excelHtml5',
                    text: 'Excel', 
                    filename: 'Danh sách biểu mẫu thiết bị', 
                    exportOptions: {
                        columns: [0, 1, 2] // Chỉ xuất 3 cột đầu: STT, Tên biểu mẫu, Tên tập tin
                    },
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
                        });                        // Thêm tiêu đề
                        var r1 = $('<row r="1"></row>');
                        var titleCell = $('<c r="A1" t="inlineStr" s="51"><is><t>DANH SÁCH BIỂU MẪU THIẾT BỊ</t></is></c>');
                        r1.append(titleCell);
                        $('worksheet sheetData', sheet).prepend(r1);
                        
                        // Merge tiêu đề ra giữa
                        var mergeCells = $('mergeCells', sheet);
                        if (mergeCells.length === 0) {
                            mergeCells = $('<mergeCells count="1"></mergeCells>');
                            $('worksheet', sheet).append(mergeCells);
                        }
                        mergeCells.append('<mergeCell ref="A1:C1"/>');
                    }
                },
                {
                    extend: 'print',
                    text: 'In',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    customize: function(win) {
                        $(win.document.body).prepend('<h4 style="text-align:center;margin-bottom:20px;">DANH SÁCH BIỂU MẪU THIẾT BỊ</h4>');
                    }
                }
            ],
            language: {
                search: "Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                infoEmpty: "Hiển thị 0 đến 0 của 0 mục",
                infoFiltered: "(được lọc từ _MAX_ mục)",
                emptyTable: "Không có dữ liệu",
                zeroRecords: "Không tìm thấy kết quả phù hợp",
                paginate: {
                    first: "Đầu tiên",
                    last: "Cuối cùng", 
                    next: "Tiếp",
                    previous: "Trước"
                }
            }
        });        // Xử lý form thêm biểu mẫu
        $('#uploadModal form').submit(function() {
            // Kiểm tra dữ liệu nhập
            var tenbieumau = $('#tenbieumau').val();
            var file = $('#file').val();
            
            if (!tenbieumau || !file) {
                alert('Vui lòng nhập đầy đủ thông tin');
                return false;
            }
            
            return true;
        });
        
        // Ẩn thông báo sau 5 giây
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Cập nhật đường dẫn cho các mục biểu mẫu
        $('.nav-second-level a').each(function() {
            var href = $(this).attr('href');
            if (href == '#') {
                if ($(this).text().trim() == "Biểu mẫu thiết bị") {
                    $(this).attr('href', "{{ route('bieumau.thietbi') }}");
                }
                if ($(this).text().trim() == "Biểu mẫu đồ nội thất") {
                    $(this).attr('href', "{{ route('bieumau.noithat') }}");
                }
                if ($(this).text().trim() == "Sổ quản lý kho") {
                    $(this).attr('href', "{{ route('bieumau.sokho') }}");
                }
                if ($(this).text().trim() == "Nhật ký phòng máy") {
                    $(this).attr('href', "{{ route('bieumau.nhatky') }}");
                }
            }
        });
    });
</script>
@endsection