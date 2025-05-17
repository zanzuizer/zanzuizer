<?php

namespace App\Http\Controllers\QuanLyBieuMau;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;

class SoQuanLyKhoController extends Controller
{
    public function index()
    {
        // Lấy danh sách khoa
        $khoas = DB::table('donvi')->get();
        
        // Lấy dữ liệu biểu mẫu sổ quản lý kho
        $bieumaus = DB::table('bieumau')
            ->whereIn('tenbieumau', ['BM-TH-05-00'])
            ->get();
        
        return view('quanlybieumau.sokho', compact('khoas', 'bieumaus'));
    }
    
    public function getPhongByKhoa(Request $request)
    {
        $khoaId = $request->input('khoa_id');
        
        try {
            \Log::info('Đang truy vấn phòng cho khoa: ' . $khoaId);
            
            $phongs = DB::table('phong_kho')
                ->where('madonvi', $khoaId)  // madonvi là khóa ngoại liên kết với bảng donvi
                ->select(['id', 'tenphong'])  // id sẽ được sử dụng làm maphong trong soquanlythietbi
                ->orderBy('tenphong', 'asc')
                ->get();
            
            \Log::info('Tìm thấy ' . count($phongs) . ' phòng');
            
            return response()->json($phongs);
        } catch (\Exception $e) {
            \Log::error('Lỗi getPhongByKhoa: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function download($id)
    {
        $bieumau = DB::table('bieumau')->where('id', $id)->first();
        
        if (!$bieumau) {
            return redirect()->back()->with('error', 'Không tìm thấy biểu mẫu');
        }
        
        $filePath = storage_path('app/public/uploads/bieumau/' . $bieumau->tentaptin);
        
        if (file_exists($filePath)) {
            return Response::download($filePath, $bieumau->tentaptin);
        }
        
        return redirect()->back()->with('error', 'Không tìm thấy tập tin');
    }
    
    public function print(Request $request)
    {
        try {
            $khoaId = $request->route('khoaId');
            $phongId = $request->route('phongId');
            
            // Lấy thông tin khoa và phòng
            $khoa = DB::table('donvi')->where('id', $khoaId)->first();
            $phong = DB::table('phong_kho')->where('id', $phongId)->first();
            
            if (!$khoa || !$phong) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin khoa hoặc phòng');
            }
            
            // Tìm file biểu mẫu sổ quản lý kho
            $filePath = storage_path('app/public/uploads/bieumau/soquanlykho/SỔ_QUẢN_LÝ_KHO_THIẾT_BỊ_(NỘI_DUNG).docx');
            
            if (!file_exists($filePath)) {
                // Thử tìm file trong thư mục uploads/bieumau
                $bieumau = DB::table('bieumau')
                    ->where('tenbieumau', 'BM-TH-05-00')
                    ->where('tentaptin', 'LIKE', '%SỔ_QUẢN_LÝ_KHO_THIẾT_BỊ_(NỘI_DUNG)%')
                    ->first();
                
                if ($bieumau) {
                    $filePath = storage_path('app/public/uploads/bieumau/' . $bieumau->tentaptin);
                }
            }
            
            if (file_exists($filePath)) {
                $downloadName = 'So_Quan_Ly_Kho_' . $khoa->tendonvi . '_' . $phong->tenphong . '.docx';
                $downloadName = str_replace(' ', '_', $downloadName);
                return Response::download($filePath, $downloadName);
            }
            
            // Nếu không tìm thấy file, trả về view như cũ
            $thietbis = DB::table('thietbi')
                ->where('donvi_id', $khoaId)
                ->where('phongkho_id', $phongId)
                ->get();
            
            return view('quanlybieumau.print.sokho', compact('khoa', 'phong', 'thietbis'));
            
        } catch (\Exception $e) {
            \Log::error('Lỗi in sổ quản lý kho: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi in sổ quản lý kho: ' . $e->getMessage());
        }
    }
    
    public function printLyLich(Request $request)
    {
        try {
            $khoaId = $request->route('khoaId');
            $phongId = $request->route('phongId');
            
            // Lấy thông tin khoa và phòng
            $khoa = DB::table('donvi')->where('id', $khoaId)->first();
            $phong = DB::table('phong_kho')->where('id', $phongId)->first();
            
            if (!$khoa || !$phong) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin khoa hoặc phòng');
            }
            
            // Tìm file biểu mẫu lý lịch thiết bị
            $filePath = storage_path('app/public/uploads/bieumau/soquanlykho/LÝ_LỊCH_THIẾT_BỊ.docx');
            
            if (!file_exists($filePath)) {
                // Thử tìm file trong thư mục uploads/bieumau
                $bieumau = DB::table('bieumau')
                    ->where('tenbieumau', 'BM-TH-02-00')
                    ->where('tentaptin', 'LIKE', '%LÝ_LỊCH_THIẾT_BỊ%')
                    ->first();
                
                if ($bieumau) {
                    $filePath = storage_path('app/public/uploads/bieumau/' . $bieumau->tentaptin);
                }
            }
            
            if (file_exists($filePath)) {
                $downloadName = 'Ly_Lich_Thiet_Bi_' . $khoa->tendonvi . '_' . $phong->tenphong . '.docx';
                $downloadName = str_replace(' ', '_', $downloadName);
                return Response::download($filePath, $downloadName);
            }
            
            // Nếu không tìm thấy file, trả về view như cũ
            $thietbis = DB::table('thietbi')
                ->where('donvi_id', $khoaId)
                ->where('phongkho_id', $phongId)
                ->get();
            
            return view('quanlybieumau.print.lylichthietbi', compact('khoa', 'phong', 'thietbis'));
            
        } catch (\Exception $e) {
            \Log::error('Lỗi in sổ lý lịch thiết bị: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi in sổ lý lịch thiết bị: ' . $e->getMessage());
        }
    }
    
    public function printSanXuat(Request $request)
    {
        try {
            $khoaId = $request->route('khoaId');
            $phongId = $request->route('phongId');
            
            // Lấy thông tin khoa và phòng
            $khoa = DB::table('donvi')->where('id', $khoaId)->first();
            $phong = DB::table('phong_kho')->where('id', $phongId)->first();
            
            if (!$khoa || !$phong) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin khoa hoặc phòng');
            }
            
            // Tìm file biểu mẫu thiết bị sản xuất
            $filePath = storage_path('app/public/uploads/bieumau/soquanlykho/DANH_MỤC_THIẾT_BỊ_SẢN_XUẤT.docx');
            
            if (!file_exists($filePath)) {
                // Thử tìm file trong thư mục uploads/bieumau
                $bieumau = DB::table('bieumau')
                    ->where('tenbieumau', 'BM-TH-01-00')
                    ->where('tentaptin', 'LIKE', '%DANH_MỤC_THIẾT_BỊ_SẢN_XUẤT%')
                    ->first();
                
                if ($bieumau) {
                    $filePath = storage_path('app/public/uploads/bieumau/' . $bieumau->tentaptin);
                }
            }
            
            if (file_exists($filePath)) {
                $downloadName = 'Danh_Muc_Thiet_Bi_San_Xuat_' . $khoa->tendonvi . '_' . $phong->tenphong . '.docx';
                $downloadName = str_replace(' ', '_', $downloadName);
                return Response::download($filePath, $downloadName);
            }
            
            // Nếu không tìm thấy file, trả về view như cũ
            $thietbis = DB::table('thietbi')
                ->where('donvi_id', $khoaId)
                ->where('phongkho_id', $phongId)
                ->get();
            
            return view('quanlybieumau.print.thietbisanxuat', compact('khoa', 'phong', 'thietbis'));
            
        } catch (\Exception $e) {
            \Log::error('Lỗi in sổ thiết bị sản xuất: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi in sổ thiết bị sản xuất: ' . $e->getMessage());
        }
    }
}