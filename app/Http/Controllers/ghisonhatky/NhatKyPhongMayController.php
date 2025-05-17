<?php

namespace App\Http\Controllers\ghisonhatky;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Nhatkyphongmay;
use App\Models\TaiKhoan;
use App\Models\Hocky;
use App\Models\PhongKho;
use App\Models\Maymocthietbi;



class NhatKyPhongMayController extends Controller
{
    public function index()
    {
        $nhatkys = Nhatkyphongmay::with([
            'phong_kho',
            'taikhoan',
            'hocky'
        ])->get();
        $phongmays = PhongKho::all();
        $taikhoans = Taikhoan::all();
        $hockys = Hocky::all();
        $hockysCurrent = Hocky::where('current', 1)->first();
        // Logic to display the index view for NhatKyPhongMay
        return view('ghisonhatky.nhatkyphongmay.index', compact('nhatkys', 'phongmays', 'taikhoans', 'hockys', 'hockysCurrent'));
    }
    public function storeNew(Request $request)
    {
        try {
            $validate = $request->validate([
                'maphong' => 'integer|exists:phong_khos,id',
                'mahocky' => 'integer|exists:hockies,id',
                'matk' => 'integer|exists:taikhoans,id',
                'ngay' => 'date_format:d/m/Y',
                'giovao' => 'string|max:255',
                'giora' => 'string|max:255',
                'mucdichsd' => 'string|max:255',
                'tinhtrangtruoc' => 'string|max:255',
                'tinhtrangsau' => 'string|max:255',
            ]);
            Nhatkyphongmay::create($validate);
            return redirect()->route('nhatkyphongmay.index')->with([
                'scuccess' => 'Thêm nhật ký phòng máy thành công',
                'title' => 'Thêm nhật ký phòng máy',
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating NhatKyPhongMay: ' . $e->getMessage());
            return redirect()->route('nhatkyphongmay.index')->with([
                'error' => 'Đã xảy ra lỗi trong quá trình thêm nhật ký.',
                'title' => 'Thêm nhật ký phòng máy',
            ]);
        }
    }
    public function storeOld(Request $request) {}
    public function edit($id)
    {
        $nhatky = Nhatkyphongmay::find($id);
        if (request()->ajax()) {
            return response()->json([
                'nhatky' => $nhatky
            ]);
        }
        return view('ghisonhatky.nhatkyphongmay.statusPC', compact('nhatky'));
    }
    public function update(Request $request, $id)
    {
        try {
            $nhatky = Nhatkyphongmay::findOrFail($id);
            if (!$nhatky) {
                return redirect()->route('nhatkyphongmay.index')
                    ->with([
                        'error' => 'Đơn vị không tồn tại.',
                        'title' => 'Cập nhật nhật ký phòng máy'
                    ]);
            }
            $validate = $request->validate([
                'maphong' => 'integer',
                'giovao' => 'string|max:255',
                'giora' => 'string|max:255',
                'mucdichsd' => 'string|max:255',
                'tinhtrangtruoc' => 'string|max:255',
                'tinhtrangsau' => 'string|max:255',
            ]);
            //update từng các trường của đối tượng $nhatky bằng giá trị mới từ request
            $nhatky->update($validate);
            return redirect()->route('nhatkyphongmay.index')
                ->with([
                    'success' => 'Cập nhật nhật ký phòng máy thành công.',
                    'title' => 'Cập nhật nhật ký phòng máy'
                ]);
        } catch (\Exception $e) {
            Log::error('Error updating NhatKyPhongMay: ' . $e->getMessage());
            return redirect()->route('nhatkyphongmay.index')
                ->with([
                    'error' => 'Đã xảy ra lỗi trong quá trình cập nhật.',
                    'title' => 'Cập nhật nhật ký phòng máy'
                ]);
        }
    }
    public function destroy($id)
    {
        try {
            $nhatky = Nhatkyphongmay::findOrFail($id);
            $nhatky->delete();
            return redirect()->route('nhatkyphongmay.index')
                ->with([
                    'success' => 'Xóa nhật ký phòng máy thành công.',
                    'title' => 'Xóa nhật ký phòng máy'
                ]);
        } catch (\Exception $e) {
            Log::error('Error deleting NhatKyPhongMay: ' . $e->getMessage());
            return  redirect()->route('nhatkyphongmay.index')
                ->with([
                    'error' => 'Đã xảy ra lỗi trong quá trình xóa nhật ký.',
                    'title' => 'Xóa nhật ký phòng máy',
                ]);
        }
    }
    public function getMayMocByPhong($idphong)
    {
        $mays = Maymocthietbi::whereNotNull('somay')
            ->where('maphongkho', $idphong)->get()->toArray();
        return $mays;
    }
    public function getGVQL($idphong)
    {
        try {
            $phong = PhongKho::with(['taikhoan'])->find($idphong);
            if ($phong) {
                $tengvql = $phong->taikhoan->hoten;
                if (!$tengvql) {
                    return null;
                }
                return $tengvql;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching GVQL: ' . $e->getMessage());
            return null;
        }
    }
    public function searchPhongMay(Request $request)
    {
        $search = $request->input('q');
        // Log::info('Searching for phong: ' . $search);

        $result = PhongKho::where('maphong', 'LIKE', '%' . $search . '%')
            ->select('id', 'tenphong', 'maphong')
            ->limit(10)
            ->get();
        if ($result->isEmpty()) {
            return response()->json([
                "message" => 'Không tìm thấy'
            ]);
        }
        // Log::info('Found ' . count($result) . ' results');
        $response = array();
        foreach ($result as $phong) {
            $id = $phong->id;
            $tenphong = $phong->tenphong;
            $maphong = $phong->maphong;
            $mays = $this->getMayMocByPhong($id);
            $tengvql = $this->getGVQL($id);
            $response[] = array(
                "id" => $id,
                "maphong" => $maphong,
                "tenphong" => $tenphong,
                "mays" => $mays,
                "tengvql" => $tengvql,
            );
        }
        // Log::info('Response: ' . json_encode($response));
        return response()->json($response);
    }
    public function loadTable(Request $request)
    {
        $idphong = $request->input('idphong');
        $idhocky = $request->input('idhocky');
        $data = Nhatkyphongmay::with([
            'taikhoan',
        ])->where('maphong', $idphong)
            ->where('mahocky', $idhocky)->get();
        if ($data->isEmpty()) {
            return response()->json([
                "message" => 'Không có dữ liệu'
            ]);
        }
        return response()->json([
            'data' => $data
        ]);
    }
    public function updateStatusPC(Request $request, $idtb)
    {
        try {
            $tb = Maymocthietbi::find($idtb);
            if (!$tb) {
                return response()->json([
                    "message" => 'Thiết bị không tồn tại.'
                ]);
            }
            $tb->tinhtrang = $request->input('tinhtrang');
            $tb->ghichu = $request->input('ghichu');
            $tb->save();
            if ($tb->tinhtrang == 'Hư hỏng') {
                $gvql = PhongKho::find($tb->maphongkho);
                $this->sendHuHongEmail($tb->phong_kho, $tb, $gvql->taikhoan);
                return redirect()->route('nhatkyphongmay.index')->with([
                    'success' => "Đã gửi email thông báo đến GVQL.",
                    'title' => 'Cập nhật trạng thái thiết bị'
                ]);
                // return response()->json([
                //     'maphong' => $tb->phong_kho,
                //     'tb' => $tb,
                //     "gvql" => $gvql->taikhoan
                // ]);
            }
            return redirect()->route('nhatkyphongmay.index')->with([
                'success' => "Trạng thái đã được cập nhật.",
                'title' => "Đã gửi email"
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating status PC: ' . $e->getMessage());
            return redirect()->route('nhatkyphongmay.index')->with([
                'error' =>  $e->getMessage(),
                'title' => "Lỗi nhập liệu"
            ]);
        }
    }
    public function sendHuHongEmail($phong, $thietbi, $gvql)
    {
        $data = [
            'hoten' => $gvql->hoten,
            'tenphong' => $phong->tenphong,
            'tentb' => $thietbi->tentb,
            'matb' => $thietbi->id,
            'somay' => $thietbi->somay,
            'mota' => $thietbi->mota,
            'ghichu' => $thietbi->ghichu,
            'tinhtrang' => $thietbi->tinhtrang,
        ];

        Mail::send('emails.sendStatusPC', $data, function ($message) use ($gvql) {
            $message->to($gvql->email)
                ->subject('Thông báo thiết bị hư hỏng');
        });
    }
}
