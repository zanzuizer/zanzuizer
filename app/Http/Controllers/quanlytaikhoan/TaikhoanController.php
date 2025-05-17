<?php

namespace App\Http\Controllers\quanlytaikhoan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Taikhoan;
use Illuminate\Support\Facades\Hash;
use App\Models\Loaitaikhoan;
use App\Models\Donvi;

class TaikhoanController extends Controller
{
    //
    public function index()
    {
        // Lấy danh sách tài khoản từ database
        $taikhoans = Taikhoan::with('loaitaikhoan', 'donvi')->get();
        // Lấy danh sách loại tài khoản từ database
        $loaitaikhoans = Loaitaikhoan::all();
        // Lấy danh sách đơn vị từ database
        $donvis = Donvi::all();
        // Truyền dữ liệu vào view
        return view('quanlytaikhoan.taikhoan.index', compact('taikhoans', 'loaitaikhoans', 'donvis'));
    }
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'hoten' => 'required|string|max:255',
                'matkhau' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:taikhoan,email',
                'cmnd' => 'nullable|string|max:255',
                'chucvu' => 'nullable|string|max:255',
                'maloaitk' => 'required|integer',
                'madonvi' => 'nullable|integer',
                'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Xử lý hình ảnh nếu có
            if ($request->hasFile('hinhanh') && $request->file('hinhanh')->isValid()) {
                $file = $request->file('hinhanh');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/taikhoan'), $fileName);
                $validate['hinhanh'] = 'uploads/taikhoan/' . $fileName;
            }

            // Mã hóa mật khẩu
            $validate['matkhau'] = Hash::make($validate['matkhau']);

            // Tạo mới tài khoản
            $taikhoan = Taikhoan::create($validate);

            // Kiểm tra xem tài khoản đã được tạo thành công hay chưa
            if (!$taikhoan) {
                return redirect()->route('taikhoan.index')->with([
                    'error' => 'Đã xảy ra lỗi trong quá trình thêm tài khoản.',
                    'title' => 'Thêm tài khoản'
                ]);
            }

            return redirect()->route('taikhoan.index')->with([
                'success' => 'Thêm tài khoản thành công.',
                'title' => 'Thêm tài khoản'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('taikhoan.index')->with([
                'error' => 'Lỗi: ' . $e->getMessage(),
                'title' => 'Thêm tài khoản'
            ]);
        }
    }
    public function edit($id)
    {
        // Tìm tài khoản theo ID
        $taikhoan = Taikhoan::find($id);
        // Nếu là ajax, trả về JSON
        if (request()->ajax()) {
            return response()->json([
                'taikhoan' => $taikhoan,
            ]);
        }
        // Nếu không phải ajax, trả về view
        // return view('quanlytaikhoan.taikhoan.modals', compact('taikhoan'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validate = $request->validate([
                'hoten' => 'string|max:255',
                'email' => 'email|max:255',
                'cmnd' => 'nullable|string|max:255',
                'chucvu' => 'nullable|string|max:255',
                'maloaitk' => 'integer|exists:loaitaikhoan,id',
                'madonvi' => 'nullable|integer',
                'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // Cập nhật tài khoản
            $taikhoan = Taikhoan::find($id);
            if (!$taikhoan) {
                return redirect()->route('taikhoan.index')->with([
                    'error' => 'Không tìm thấy tài khoản.',
                    'title' => 'Cập nhật tài khoản'
                ]);
            }
            $taikhoan->update($validate);
            return redirect()->route('taikhoan.index')->with([
                'success' => 'Cập nhật tài khoản thành công.',
                'title' => 'Cập nhật tài khoản'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('taikhoan.index')->with([
                'error' => 'Lỗi nhập liệu.' . $e->getMessage(),
                'title' => 'Cập nhật tài khoản'
            ]);
        }
    }
    public function destroy($id)
    {
        // Xóa tài khoản
        $taikhoan = Taikhoan::find($id);
        if ($taikhoan) {
            $taikhoan->delete();
            return redirect()->route('taikhoan.index')->with([
                'success' => 'Xóa tài khoản thành công.',
                'title' => 'Xóa tài khoản'
            ]);
        } else {
            return redirect()->route('taikhoan.index')->with([
                'error' => 'Tài khoản không tồn tại.',
                'title' => 'Xóa tài khoản'
            ]);
        }
    }
}
