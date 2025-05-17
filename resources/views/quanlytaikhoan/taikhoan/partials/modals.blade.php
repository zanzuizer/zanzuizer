<!-- Modal Thêm -->
<div class="modal fade" id="addTKModal" tabindex="-1" role="dialog" aria-labelledby="addLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="addModalLabel">Thêm tài khoản mới</h4>
            </div>
            <form action="{{ route('taikhoan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Họ tên</label>
                        <div class="col-sm-8">
                            <input type="text" name="hoten" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Căn cước công dân</label>
                        <div class="col-sm-8">
                            <input type="text" name="cmnd" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Chức vụ</label>
                        <div class="col-sm-8">
                            <input type="text" name="chucvu" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Loại tài khoản</label>
                        <div class="col-sm-8">
                            <select name="maloaitk" class="form-control" required>
                                @foreach($loaitaikhoans as $loai)
                                <option value="{{ $loai->id }}">{{ $loai->tenloai }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tổ chức</label>
                        <div class="col-sm-8">
                            <select name="madonvi" class="form-control" required>
                                @foreach($donvis as $dv)
                                <option value="{{ $dv->id }}">{{ $dv->tendonvi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa -->
<div class="modal fade" id="editTKModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editModalLabel">Câp nhật thông tin tài khoản</h4>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Họ tên</label>
                        <div class="col-sm-8">
                            <input type="text" name="hoten" id="edit_hoten" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Căn cước công dân</label>
                        <div class="col-sm-8">
                            <input type="text" name="cmnd" id="edit_cmnd" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                            <!-- @if ($errors->has('email'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Chức vụ</label>
                        <div class="col-sm-8">
                            <input type="text" name="chucvu" id="edit_chucvu" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Loại tài khoản</label>
                        <div class="col-sm-8">
                            <select name="maloaitk" id="edit_maloaitk" class="form-control" required>
                                @foreach($loaitaikhoans as $loai)
                                <option value="{{ $loai->id }}">{{ $loai->tenloai }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tổ chức</label>
                        <div class="col-sm-8">
                            <select name="madonvi" id="edit_madonvi" class="form-control">
                                @foreach($donvis as $dv)
                                <option value="{{ $dv->id }}">{{ $dv->tendonvi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xóa -->
<div class="modal fade" id="deleteTKModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 400px; margin: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="deleteModalLabel">
                    <i class="fa fa-exclamation-triangle text-danger"></i> Xóa tài khoản
                </h4>
            </div>
            <div class="modal-body">
                <p><strong>Tất cả dữ liệu liên quan đến tài khoản này sẽ bị xóa.<br> Bạn có chắc chắn muốn xóa không?</strong></p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>