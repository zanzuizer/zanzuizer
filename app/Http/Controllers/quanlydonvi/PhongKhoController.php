<?php

namespace App\Http\Controllers\quanlydonvi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhongKho;
use App\Models\Donvi;
use App\Models\Taikhoan;

class PhongKhoController extends Controller
{
    //
    public function index()
    {
        $phongkhos = PhongKho::with(['donvi', 'taikhoan'])->get();
        $donvis = Donvi::all();
        $magvqls = Taikhoan::all();
        return view('quanlydonvi.phongkho.index', compact('phongkhos', 'donvis', 'magvqls'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tenphong' => 'nullable|string|max:255',
                'maphong' => 'required|string|max:30',
                'khu' => 'nullable|string|max:10',
                'lau' => 'nullable|integer|max:255',
                'sophong' => 'nullable|integer|max:255',
                'magvql' => 'required|integer|max:255',
                'madonvi' => 'nullable|integer|max:255',
            ]);
            $phongkho = PhongKho::create($request->all());
            if (!$phongkho) {
                return redirect()->route('phongkho.index')->with([
                    'error' => 'Đã xảy ra lỗi trong quá trình thêm phòng kho.',
                    'title' => 'Thêm phòng kho'
                ]);
            }
            return redirect()->route('phongkho.index')->with([
                'success' => 'Thêm phòng kho thành công.',
                'title' => 'Thêm phòng kho'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('phongkho.index')->with([
                'error' => 'Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.',
                'title' => 'Thêm phòng kho'
            ]);
        }
    }
    public function edit($id)
    {
        $phongkho = PhongKho::find($id);
        $donvi = Donvi::all();
        $magvql = Taikhoan::all();
        if (request()->ajax()) {
            return response()->json([
                'phongkho' => $phongkho,
                'donvi' => $donvi,
                'magvql' => $magvql
            ]);
        }
        return view('quanlydonvi.phongkho.modals', compact('phongkho', 'donvi', 'magvql'));
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'maphong' => 'required|string|max:30',
                'tenphong' => 'nullable|string|max:255',
                'khu' => 'nullable|string|max:10',
                'lau' => 'nullable|integer|max:255',
                'sophong' => 'nullable|integer|max:255',
                'magvql' => 'required|integer|max:255',
                'madonvi' => 'required|integer|max:255',
            ]);
            $phongkho = PhongKho::findOrFail($id);
            $phongkho->update($request->all());
            return redirect()->route('phongkho.index')->with([
                'success' => 'Cập nhật phòng kho thành công.',
                'title' => 'Cập nhật phòng kho'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('phongkho.index')->with([
                'error' => 'Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.',
                'title' => 'Cập nhật phòng kho'
            ]);
        }
    }
    public function destroy($id)
    {
        try {
            $phongkho = PhongKho::findOrFail($id);
            if (!$phongkho) {
                return redirect()->route('phongkho.index')->with([
                    'error' => 'Phòng kho không tồn tại.',
                    'title' => 'Xóa phòng kho'
                ]);
            }
            $phongkho->delete();
            return redirect()->route('phongkho.index')->with([
                'success' => 'Xóa phòng kho thành công.',
                'title' => 'Xóa phòng kho'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('phongkho.index')->with([
                'error' => 'Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.',
                'title' => 'Xóa phòng kho'
            ]);
        }
    }
    public function getPhongKhoByDonVi($madonvi)
    {
        $phongkhos = PhongKho::where('madonvi', $madonvi)->get();
        return response()->json($phongkhos);
    }
}
