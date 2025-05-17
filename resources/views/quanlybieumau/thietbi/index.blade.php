@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Biểu mẫu thiết bị</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Form upload biểu mẫu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tải lên biểu mẫu mới</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('bieumau.thietbi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="tenbieumau" placeholder="Tên biểu mẫu" required>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="file" required>
                        <small class="form-text text-muted">Hỗ trợ: PDF, DOC, DOCX, XLS, XLSX (tối đa 10MB)</small>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Tải lên</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách biểu mẫu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách biểu mẫu thiết bị</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên biểu mẫu</th>
                            <th>Tên tập tin</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bieumaus as $key => $bieumau)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $bieumau->tenbieumau }}</td>
                            <td>{{ $bieumau->tentaptin }}</td>
                            <td>{{ date('d/m/Y H:i', $bieumau->create_at) }}</td>
                            <td>
                                <a href="{{ route('bieumau.thietbi.download', $bieumau->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-download"></i> Tải xuống
                                </a>
                                <form action="{{ route('bieumau.thietbi.destroy', $bieumau->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Không có biểu mẫu nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection