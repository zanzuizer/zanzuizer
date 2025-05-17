<!-- Modal Sửa -->
<div class="modal fade" id="editPMModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="editModalLabel">Cập nhật</h3>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Phòng máy -->
                    <div class="form-group autocomplete">
                        <label class="form-label fw-bold">PHÒNG MÁY</label>
                        <input required id="edit-phong" type="text" class="form-control"
                            placeholder="Nhập tên phòng (VD: A201)">
                    </div>
                    <div class="row mb-3">
                        <!-- Giờ vào -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Giờ vào</label>
                                <input type="text" id="edit-giovao" name="giovao" class="form-control timePicker" required>
                            </div>
                        </div>

                        <!-- Giờ ra -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Giờ ra</label>
                                <input type="text" id="edit-giora" name="giora" class="form-control timePicker" required>
                            </div>
                        </div>
                    </div>

                    <!-- Mục đích sử dụng -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Mục đích sử dụng</label>
                        <textarea name="mucdichsd" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Tình trạng trước -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Tình trạng trước khi sử dụng</label>
                        <textarea name="tinhtrangtruoc" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Tình trạng sau -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Tình trạng sau khi sử dụng</label>
                        <textarea name="tinhtrangsau" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>