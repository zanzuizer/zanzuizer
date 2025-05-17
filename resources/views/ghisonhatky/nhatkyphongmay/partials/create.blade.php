<!-- Modal Thêm -->
<div class="modal fade" id="addModalNew" tabindex="-1" role="dialog" aria-labelledby="addLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="addModalLabel">Thêm nhật ký mới</h3>
            </div>
            <form action="{{ route('nhatkyphongmay.storeNew') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Chọn học kỳ -->
                    <div class="form-group">
                        <label for="hockySearch">HỌC KỲ</label>
                        <select id="hockySearch" name="idhocky" class="form-control">
                            @foreach($hockys->reverse() as $hk)
                            <option value="{{ $hk->id }}" @if($hk==$hockysCurrent) selected @endif>
                                Học kỳ {{ $hk->hocky }} ({{ $hk->tunam }} - {{ $hk->dennam }})
                                @if($hk == $hockysCurrent) - Học kỳ hiện tại @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Chọn phòng máy -->
                    <div class="form-group autocomplete">
                        <label for="phongSearchCreate">PHÒNG MÁY</label>
                        <input required id="phongSearchCreate" type="text" class="form-control" name="phongSearch"
                            placeholder="Nhập tên phòng (VD: A201)">
                    </div>
                    <!-- Chọn giáo viên -->
                    <div class="form-group">
                        <label class="control-label">GIÁO VIÊN</label>
                        <select name="magv" id="magv" class="form-control">
                            <option value="" selected disabled>
                                --Chọn giáo viên--
                            </option>
                            @foreach($taikhoans as $tk)
                            <option value="{{ $tk->id }}">
                                {{$tk->hoten}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!--Chọn ngày -->
                    <div class="form-group">
                        <label class="control-label">NGÀY</label>
                        <input type="text" id="ngay" name="ngay" class="form-control datePicker">
                    </div>
                    <div class="row mb-3">
                        <!--Chọn giờ vào -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_giovao" class="form-label fw-bold">GIỜ VÀO</label>
                                <input type="text" id="edit_giovao" name="giovao" class="form-control timePicker" required>
                            </div>
                        </div>

                        <!--Chọn giờ ra -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_giora" class="form-label fw-bold">GIỜ RA</label>
                                <input type="text" id="edit_giora" name="giora" class="form-control timePicker" required>
                            </div>
                        </div>
                    </div>

                    <!-- Mục đích sử dụng -->
                    <div class="form-group mb-3">
                        <label for="edit-mucdichsd" class="form-label fw-bold">MÔN HỌC/MỤC ĐÍCH SỬ DỤNG</label>
                        <textarea name="mucdichsd" id="edit_mucdichsd" class="form-control" rows="2"></textarea>
                    </div>

                    <!-- Tình trạng trước -->
                    <div class="form-group mb-3">
                        <label for="edit_tinhtrangtruoc" class="form-label fw-bold">TÌNH TRẠNG TRƯỚC KHI SỬ DỤNG</label>
                        <textarea name="tinhtrangtruoc" id="edit_tinhtrangtruoc" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Tình trạng sau -->
                    <div class="form-group mb-3">
                        <label for="edit_tinhtrangsau" class="form-label fw-bold">TÌNH TRẠNG SAU KHI SỬ DỤNG</label>
                        <textarea name="tinhtrangsau" id="edit_tinhtrangsau" class="form-control" rows="3"></textarea>
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