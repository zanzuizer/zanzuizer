<?php

namespace App\Http\Controllers\QuanLyBieuMau;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Bieumau;

class BieuMauThietBi extends Controller
{
    private function getFilePath($filename)
    {
        return public_path('storage/uploads/bieumau/thietbi/' . $filename);
    }    public function index()
    {
        // Lấy tất cả dữ liệu biểu mẫu vì không có cột 'loai' trong bảng bieumau
        $bieumaus = Bieumau::all();
        
        // Nếu là request ajax từ DataTable
        if (request()->ajax()) {
            return response()->json([
                'data' => $bieumaus
            ]);
        }
        
        // Nếu không phải ajax request, trả về view với dữ liệu
        return view('quanlybieumau.thietbi', compact('bieumaus'));
    }
      public function store(Request $request)
    {
        try {
            $request->validate([
                'tenbieumau' => 'required|string|max:50',
                'file' => 'required|mimes:pdf,doc,docx|max:10240',
            ]);
            
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $filePath = 'uploads/bieumau/thietbi/' . $fileName;
                $file->storeAs('uploads/bieumau/thietbi', $fileName, 'public');
                  $bieumau = Bieumau::create([
                    'tenbieumau' => $request->tenbieumau,
                    'tentaptin' => $fileName,
                    'create_at' => time()
                ]);
                
                // Kiểm tra xem biểu mẫu đã được tạo thành công hay chưa
                if (!$bieumau) {                return redirect()->route('bieumau.thietbi')
                    ->with([
                        "error" => "Đã xảy ra lỗi trong quá trình thêm biểu mẫu.",
                        "title" => "Thêm biểu mẫu"
                    ]);
                }
                
                return redirect()->route('bieumau.thietbi')
                    ->with([
                        "success" => "Biểu mẫu đã được tải lên thành công.",
                        "title" => "Thêm biểu mẫu"
                    ]);
            }
            
            return redirect()->back()
                ->with([
                    "error" => "Có lỗi xảy ra khi tải lên tập tin.",
                    "title" => "Thêm biểu mẫu"
                ]);
        } catch (\Exception $e) {
            return redirect()->route('bieumau.thietbi')
                ->with([
                    "error" => "Lỗi nhập liệu. Vui lòng kiểm tra lại thông tin.",
                    "title" => "Thêm biểu mẫu"
                ]);
        }
    }
      public function download($id)
    {
        $bieumau = Bieumau::find($id);
        
        if (!$bieumau) {
            return redirect()->back()->with('error', 'Không tìm thấy biểu mẫu');
        }
        
        $filePath = $this->getFilePath($bieumau->tentaptin);
        
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        
        return redirect()->back()->with('error', 'Tập tin không tồn tại');
    }
    
    public function destroy($id)
    {
        try {
            $bieumau = Bieumau::find($id);
            
            if (!$bieumau) {
                return redirect()->back()
                    ->with([
                        'error' => 'Không tìm thấy biểu mẫu',
                        'title' => 'Xóa biểu mẫu'
                    ]);
            }
            
            $filePath = $this->getFilePath($bieumau->tentaptin);
            
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $bieumau->delete();
            
            return redirect()->route('bieumau.thietbi')
                ->with([
                    'success' => 'Đã xóa biểu mẫu thành công',
                    'title' => 'Xóa biểu mẫu'
                ]);
        } catch (\Exception $e) {
            return redirect()->route('bieumau.thietbi')
                ->with([
                    'error' => 'Đã xảy ra lỗi trong quá trình xóa biểu mẫu',
                    'title' => 'Xóa biểu mẫu'
                ]);
        }
    }    public function edit($id)
    {
        $bieumau = Bieumau::find($id);
        
        if (!$bieumau) {
            return redirect()->back()->with('error', 'Không tìm thấy biểu mẫu');
        }
        
        // Kiểm tra file có tồn tại không, nhưng chỉ hiển thị cảnh báo
        $filePath = $this->getFilePath($bieumau->tentaptin);
        $fileExists = file_exists($filePath);
        
        if (!$fileExists) {
            // Thêm thông báo cảnh báo nhưng vẫn cho phép chỉnh sửa
            session()->flash('warning', 'File biểu mẫu không tồn tại trên máy chủ, bạn có thể cập nhật lại file');
        }
        
        return view('quanlybieumau.edit', compact('bieumau'));
    }

    public function update(Request $request, $id)
    {
        $bieumau = Bieumau::find($id);
        
        if (!$bieumau) {
            return redirect()->back()->with('error', 'Không tìm thấy biểu mẫu');
        }
        
        $request->validate([
            'tenbieumau' => 'required|string|max:50',
            'file' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);
        
        $updateData = [
            'tenbieumau' => $request->tenbieumau,
        ];
        
        // Kiểm tra nếu có file mới được tải lên
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Xóa file cũ nếu có
            $oldFilePath = $this->getFilePath($bieumau->tentaptin);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            
            // Lưu file mới
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads/bieumau/thietbi', $fileName, 'public');
            
            $updateData['tentaptin'] = $fileName;
        }
        
        $bieumau->update($updateData);
        
        return redirect()->route('bieumau.thietbi')->with('success', 'Biểu mẫu đã được cập nhật thành công');
    }
}