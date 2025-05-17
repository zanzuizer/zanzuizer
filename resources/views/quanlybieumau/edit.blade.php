@extends('layouts.app')

@section('title', 'Chỉnh sửa biểu mẫu')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>CHỈNH SỬA BIỂU MẪU</h2>
                </div>
                <div class="ibox-content">
                    <a href="{{ route('bieumau.thietbi') }}" class="btn btn-primary mb-3">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('warning'))
                        <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif                    <form action="{{ route('bieumau.thietbi.update', $bieumau->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                          <div class="form-group">
                            <label for="tenbieumau">Tên biểu mẫu</label>
                            <input type="text" class="form-control" id="tenbieumau" name="tenbieumau" value="{{ $bieumau->tenbieumau }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="file">Tập tin hiện tại</label>
                            <p>{{ $bieumau->tentaptin }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="file">Tải lên tập tin mới (nếu cần)</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <p class="help-block">Chỉ hỗ trợ file PDF, DOC, DOCX</p>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('bieumau.thietbi') }}" class="btn btn-default">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        // Ẩn thông báo sau 5 giây
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Xác nhận form trước khi submit
        $('form').submit(function() {
            var tenbieumau = $('#tenbieumau').val();
            
            if (!tenbieumau) {
                alert('Vui lòng nhập tên biểu mẫu');
                return false;
            }
            
            return true;
        });
    });
</script>
@endsection