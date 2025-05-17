<!-- Modal Cập nhật tình trạng thiết bị -->
<div class="modal fade" id="modalUpdateStatus" tabindex="-1" role="dialog" aria-labelledby="modalUpdateStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 800px; margin-left: auto; margin-right: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" style="font-size: 20px;" id="editModalLabel">Cập nhật tình trạng thiết bị</h3>
            </div>
            <form id="editStatusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tên thiết bị</label>
                        <div class="col-sm-8">
                            <input type="text" name="tentb" id="edit-tentb" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Mô tả</label>
                        <div class="col-sm-8">
                            <textarea rows="3" type="text" name="mota" id="edit-mota" class="form-control" disabled></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Ghi chú</label>
                        <div class="col-sm-8">
                            <textarea rows="5" type="text" name="ghichu" id="edit-ghichu" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tình trạng</label>
                        <div class="col-sm-8">
                            <select name="tinhtrang" id="edit-tinhtrang" class="form-control">
                                <option value="Đang sử dụng">Đang sử dụng</option>
                                <option value="Hư hỏng">Hư hỏng</option>
                            </select>
                            <span style="font-size: 12px;">Nếu thiết bị đã được sửa chữa thì cập nhật lại tình trạng mới.</span>
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