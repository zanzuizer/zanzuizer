<!-- Modal Thêm -->
<div class="modal fade" id="addPKModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="addModalLabel">Thêm phòng kho mới</h4>
            </div>
            <form action="{{ route('phongkho.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Mã phòng</label>
                        <div class="col-sm-8">
                            <input type="text" name="maphong" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tên phòng</label>
                        <div class="col-sm-8">
                            <input type="text" name="tenphong" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Khu</label>
                        <div class="col-sm-8">
                            <input type="text" name="khu" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Lầu</label>
                        <div class="col-sm-8">
                            <input type="number" name="lau" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Số phòng</label>
                        <div class="col-sm-8">
                            <input type="number" name="sophong" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Giáo viên quản lý</label>
                        <div class="col-sm-8">
                            <select name="magvql" class="form-control" required>
                                @foreach($magvqls as $gv)
                                <option value="{{ $gv->id }}">{{ $gv->hoten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Loại đơn vị</label>
                        <div class="col-sm-8">
                            <select name="madonvi" class="form-control">
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
<div class="modal fade" id="editPKModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" style="font-size: 20px;" id="editModalLabel">Cập nhật phòng kho</h3>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Mã phòng</label>
                        <div class="col-sm-8">
                            <input type="text" name="maphong" id="edit-maphong" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tên phòng</label>
                        <div class="col-sm-8">
                            <input type="text" name="tenphong" id="edit-tenphong" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Khu</label>
                        <div class="col-sm-8">
                            <input type="text" name="khu" id="edit-khu" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Lầu</label>
                        <div class="col-sm-8">
                            <input type="number" name="lau" id="edit-lau" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Số phòng</label>
                        <div class="col-sm-8">
                            <input type="number" name="sophong" id="edit-sophong" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Giáo viên quản lý</label>
                        <div class="col-sm-8">
                            <select name="magvql" id="edit-magvql" class="form-control" required>
                                @foreach($magvqls as $gv)
                                <option value="{{ $gv->id }}">{{ $gv->hoten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Loại đơn vị</label>
                        <div class="col-sm-8">
                            <select name="madonvi" id="edit-madonvi" class="form-control">
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
<div class="modal fade" id="deletePKModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 400px; margin: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="deleteModalLabel">
                    <i class="fa fa-exclamation-triangle text-danger"></i> Xóa phòng
                </h4>
            </div>
            <div class="modal-body">
                <p><strong>Bạn có chắc chắn muốn xóa phòng này không?</strong></p>
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