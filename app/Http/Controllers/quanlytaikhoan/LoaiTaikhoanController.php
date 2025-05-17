<?php

namespace App\Http\Controllers\quanlytaikhoan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loaitaikhoan;

class LoaiTaikhoanController extends Controller
{
    public function index()
    {
        // Lấy danh sách loại tài khoản từ database
        $loaitaikhoans = Loaitaikhoan::all();
        // Truyền dữ liệu vào view
        return view('quanlytaikhoan.loaitaikhoan.index', compact('loaitaikhoans'));
    }
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'tenloai' => 'required|string|max:255',
                'mota' => 'nullable|string|max:255',
            ]);
            // Tạo mới loại tài khoản
            $loaitaikhoan = Loaitaikhoan::create($validate);
            // Kiểm tra xem loại tài khoản đã được tạo thành công hay chưa
            if (!$loaitaikhoan) {
                return redirect()->route('loaitaikhoan.index')->with([
                    'error' => 'Đã xảy ra lỗi trong quá trình thêm loại tài khoản.',
                    'title' => 'Thêm loại tài khoản'
                ]);
            }
            return redirect()->route('loaitaikhoan.index')->with([
                'success' => 'Thêm loại tài khoản thành công.',
                'title' => 'Thêm loại tài khoản'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('loaitaikhoan.index')->with([
                'error' => 'Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.',
                'title' => 'Thêm loại tài khoản'
            ]);
        }
    }
    public function edit($id)
    {
        // Tìm loại tài khoản theo ID
        $loaitaikhoan = Loaitaikhoan::find($id);
        if (request()->ajax()) {
            return response()->json([
                'loaitaikhoan' => $loaitaikhoan,
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $validate = $request->validate([
                'tenloai' => 'required|string|max:255',
                'mota' => 'nullable|string|max:255',
            ]);
            // Cập nhật loại tài khoản
            $loaitaikhoan = Loaitaikhoan::find($id);
            if (!$loaitaikhoan) {
                return redirect()->route('loaitaikhoan.index')->with([
                    'error' => 'Đã xảy ra lỗi trong quá trình cập nhật loại tài khoản.',
                    'title' => 'Cập nhật loại tài khoản'
                ]);
            }
            $loaitaikhoan->update($validate);
            return redirect()->route('loaitaikhoan.index')->with([
                'success' => 'Cập nhật loại tài khoản thành công.',
                'title' => 'Cập nhật loại tài khoản'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('loaitaikhoan.index')->with([
                'error' => 'Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.',
                'title' => 'Cập nhật loại tài khoản'
            ]);
        }
    }
}
