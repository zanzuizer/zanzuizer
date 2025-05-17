<?php

namespace App\Http\Controllers\quanlydonvi;

use App\Http\Controllers\Controller;
use App\Models\Donvi;
use App\Models\Loaidonvi;
use Illuminate\Http\Request;

class DonViController extends Controller
{
    /**
     * Hiển thị danh sách đơn vị
     */
    public function index()
    {
        $donvis = Donvi::with('loaidonvi')->get();
        $loaidonvi = Loaidonvi::all();
        return view('quanlydonvi.donvi.index', compact('donvis', 'loaidonvi'));
    }

    /**
     * Lưu đơn vị mới vào database
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tendonvi' => 'required|string|max:255',
                'tenviettat' => 'required|string|max:255',
                'maloai' => 'required|integer|max:255',
            ]);

            $donvi = Donvi::create($request->all());
            // Kiểm tra xem đơn vị đã được tạo thành công hay chưa
            if (!$donvi) {
                return redirect()->route('donvi.index')
                    ->with([
                        "error" => "Đã xảy ra lỗi trong quá trình thêm đơn vị.",
                        "title" => "Thêm đơn vị"
                    ]);
            }
            return redirect()->route('donvi.index')
                ->with([
                    "success" => "Thêm đơn vị thành công.",
                    "title" => "Thêm đơn vị"
                ]);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return redirect()->route('donvi.index')
                ->with([
                    "error" => "Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.",
                    "title" => "Thêm đơn vị"
                ]);
        }
    }

    /**
     * Hiển thị form sửa đơn vị
     **/
    public function edit($id)
    {
        $donvi = Donvi::find($id);
        $loaidonvi = Loaidonvi::all();

        if (request()->ajax()) {
            return response()->json([
                'donvi' => $donvi,
                'loaidonvi' => $loaidonvi
            ]);
        }
        return view('quanlydonvi.donvi.partials.modals', compact('donvi', 'loaidonvi'));
    }
    /**
     * Cập nhật thông tin đơn vị
     */
    public function update(Request $request, $id)
    {
        try {
            $donvi = Donvi::findOrFail($id);
            if (!$donvi) {
                return redirect()->route('donvi.index')
                    ->with([
                        'error' => 'Đơn vị không tồn tại.',
                        'title' => 'Cập nhật đơn vị'
                    ]);
            }
            $request->validate([
                'tendonvi' => 'required|string|max:255|unique:donvi,tendonvi,' . $id,
                'tenviettat' => 'required|string|max:255|unique:donvi,tenviettat,' . $id,
                'tenviettat' => 'required|string|max:255',
                'maloai' => 'required|integer|max:255',
            ]);
            $donvi->update($request->all());
            if (!$donvi) {
                return redirect()->route('donvi.index')
                    ->with([
                        "error" => "Đã xảy ra lỗi trong quá trình cập nhật đơn vị.",
                        "title" => "Cập nhật đơn vị"
                    ]);
            }
            // Cập nhật thành công
            return redirect()->route('donvi.index')
                ->with([
                    "success" => "Đơn vị đã được cập nhật thành công.",
                    "title" => "Cập nhật đơn vị"
                ]);
        } catch (\Exception $e) {
            return redirect()->route('donvi.index')
                ->with([
                    "error" => "Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.",
                    "title" => "Cập nhật đơn vị"
                ]);
        }
    }

    /**
     * Xóa đơn vị
     */
    public function destroy($id)
    {
        try {
            $donvi = Donvi::find($id);
            if (!$donvi) {
                return redirect()->route('donvi.index')
                    ->with([
                        "error" => "Đơn vị không tồn tại.",
                        "title" => "Xóa đơn vị"
                    ]);
            }
            $donvi->taikhoans()->delete();
            $donvi->phong_khos()->delete();
            $donvi->hockies()->delete();
            $donvi->delete();
            return redirect()->route('donvi.index')
                ->with([
                    "success" => "Xóa đơn vị thành công.",
                    "title" => "Xóa đơn vị"
                ]);
        } catch (\Exception $e) {
            return redirect()->route('donvi.index')
                ->with([
                    "error" => "Đã xảy ra lỗi trong quá trình cập nhật đơn vị.",
                    "title" => "Xóa đơn vị"
                ]);;
        }
    }
}
