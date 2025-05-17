@extends('layouts.app')

@section('title', 'Sổ quản lý kho')

@section('css')
<style>
    h1 {
        color: #6c757d;
        font-size: 28px;
        font-weight: normal;
        margin-bottom: 25px;
    }
    
    .form-label {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-control {
        border-radius: 0;
        height: 40px;
    }

    .btn-action {
        background-color: #3498db;
        color: white;
        margin-right: 10px;
        margin-bottom: 20px;
        padding: 8px 15px;
        border: none;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .download-text {
        color: #333;
        margin-top: 20px;
        margin-bottom: 5px;
    }
    
    .container-form {
        padding: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <h1>Sổ quản lý kho</h1>

    <div class="container-form">
        <!-- Chọn Khoa -->
        <div class="form-group">
            <label class="form-label">CHỌN KHOA</label>
            <select class="form-control" id="select-khoa">
                <option value="">-- Chọn khoa --</option>
                @foreach($khoas ?? [] as $khoa)
                    <option value="{{ $khoa->id }}">{{ $khoa->tendonvi }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Chọn Phòng -->
        <div class="form-group">
            <label class="form-label">CHỌN PHÒNG</label>
            <select class="form-control" id="select-phong" disabled>
                <option value="">-- Chọn phòng --</option>
            </select>
        </div>
        
        <!-- Nút In -->
        <div>
            <button type="button" class="btn btn-action" id="btn-in-sokho">
                IN SỔ QUẢN LÝ KHO
            </button>
            <button type="button" class="btn btn-action" id="btn-in-lylich">
                IN SỔ LÝ LỊCH THIẾT BỊ
            </button>
            <button type="button" class="btn btn-action" id="btn-in-sanxuat">
                IN SỔ THIẾT BỊ SẢN XUẤT
            </button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Xử lý khi chọn khoa
        $('#select-khoa').change(function() {
            var khoaId = $(this).val();
            
            if (khoaId) {
                // Enable select phòng
                $('#select-phong').prop('disabled', false);
                $('#select-phong').html('<option value="">-- Đang tải dữ liệu --</option>');
                
                // Debug log
                console.log('Đang gọi API lấy phòng với khoa_id = ' + khoaId);
                
                // Load danh sách phòng theo khoa
                $.ajax({
                    url: "{{ route('bieumau.phongkho.get-by-khoa') }}",
                    type: 'GET',
                    data: {khoa_id: khoaId},
                    dataType: 'json',
                    success: function(data) {
                        console.log('Dữ liệu phòng nhận được:', data);
                        
                        var options = '<option value="">-- Chọn phòng --</option>';
                        
                        if (data && data.length > 0) {
                            $.each(data, function(index, phong) {
                                options += '<option value="' + phong.id + '">' + phong.tenphong + '</option>';
                            });
                        } else {
                            options += '<option value="" disabled>Không có phòng nào cho khoa này</option>';
                        }
                        
                        $('#select-phong').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi AJAX:", xhr.responseText);
                        $('#select-phong').prop('disabled', true);
                        $('#select-phong').html('<option value="">-- Lỗi khi tải dữ liệu --</option>');
                        alert('Không thể tải danh sách phòng: ' + error);
                    }
                });
            } else {
                $('#select-phong').prop('disabled', true);
                $('#select-phong').html('<option value="">-- Chọn phòng --</option>');
            }
        });
        
        // Xử lý nút in sổ quản lý kho
        $('#btn-in-sokho').click(function() {
            var khoaId = $('#select-khoa').val();
            var phongId = $('#select-phong').val();
            
            if (!khoaId) {
                alert('Vui lòng chọn khoa');
                return;
            }
            
            if (!phongId) {
                alert('Vui lòng chọn phòng');
                return;
            }
            
            // Thay vì chuyển đến URL trực tiếp, sử dụng Ajax để tải file
            $.ajax({
                url: "{{ url('bieumau/sokho/export') }}/" + khoaId + "/" + phongId,
                type: 'GET',
                xhrFields: {
                    responseType: 'blob' // Để xử lý dữ liệu nhị phân (file)
                },
                success: function(data, status, xhr) {
                    // Lấy tên file từ header Content-Disposition hoặc sử dụng tên mặc định
                    var fileName = 'soquanlykho_' + phongId + '.docx';
                    
                    // Tạo một đối tượng URL cho blob
                    var blob = new Blob([data], {type: xhr.getResponseHeader('content-type')});
                    var url = window.URL.createObjectURL(blob);
                    
                    // Tạo một thẻ a tạm thời để tải file
                    var a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = fileName;
                    document.body.appendChild(a);
                    a.click();
                    
                    // Dọn dẹp
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                },
                error: function(xhr, status, error) {
                    alert('Có lỗi xảy ra khi tạo file: ' + error);
                }
            });
        });
        
        // Xử lý nút in sổ lý lịch thiết bị
        $('#btn-in-lylich').click(function() {
            var khoaId = $('#select-khoa').val();
            var phongId = $('#select-phong').val();
            
            if (!khoaId) {
                alert('Vui lòng chọn khoa');
                return;
            }
            
            if (!phongId) {
                alert('Vui lòng chọn phòng');
                return;
            }
            
            window.location.href = "{{ url('bieumau/lylich/export') }}/" + khoaId + "/" + phongId;
        });
        
        // Xử lý nút in sổ thiết bị sản xuất
        $('#btn-in-sanxuat').click(function() {
            var khoaId = $('#select-khoa').val();
            var phongId = $('#select-phong').val();
            
            if (!khoaId) {
                alert('Vui lòng chọn khoa');
                return;
            }
            
            if (!phongId) {
                alert('Vui lòng chọn phòng');
                return;
            }
            
            window.location.href = "{{ url('bieumau/sanxuat/export') }}/" + khoaId + "/" + phongId;
        });
    });
</script>
@endsection