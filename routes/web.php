<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\quanlydonvi\DonViController;
use App\Http\Controllers\quanlydonvi\PhongKhoController;
use App\Http\Controllers\quanlytaikhoan\LoaiTaikhoanController;
use App\Http\Controllers\quanlytaikhoan\TaikhoanController;
use App\Http\Controllers\ghisonhatky\NhatKyPhongMayController;
use App\Http\Controllers\quanlynoithat\LoaiNoiThatController;
use App\Http\Controllers\quanlybieumau\BieuMauController;
use App\Http\Controllers\QuanLyBieuMau\BieuMauThietBi;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('layouts.app');
    })->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Password reset routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// DonVi routes
Route::middleware('auth')->group(function () {
    Route::prefix('donvi')->name('donvi.')->group(function () {
        Route::get('/', [DonViController::class, 'index'])->name('index');
        Route::post('/create', [DonViController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DonViController::class, 'edit'])->name('edit');
        Route::put('/upd/{id}', [DonViController::class, 'update'])->name('update');
        Route::delete('/del/{id}', [DonViController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('phongkho')->name('phongkho.')->group(function () {
        Route::get('/', [PhongKhoController::class, 'index'])->name('index');
        Route::post('/create', [PhongKhoController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [PhongKhoController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [PhongKhoController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [PhongKhoController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('loaitaikhoan')->name('loaitaikhoan.')->group(function () {
        Route::get('/', [LoaiTaikhoanController::class, 'index'])->name('index');
        Route::post('/create', [LoaiTaikhoanController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [LoaiTaikhoanController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [LoaiTaikhoanController::class, 'edit'])->name('edit');
    });
    Route::prefix('taikhoan')->name('taikhoan.')->group(function () {
        Route::get('/', [TaikhoanController::class, 'index'])->name('index');
        Route::post('/create', [TaikhoanController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [TaikhoanController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [TaikhoanController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [TaikhoanController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('nhatkyphongmay')->name('nhatkyphongmay.')->group(function () {
        Route::get('/', [NhatKyPhongMayController::class, 'index'])->name('index');
        Route::post('/create', [NhatKyPhongMayController::class, 'storeNew'])->name('storeNew');
        Route::put('/upd/{id}', [NhatKyPhongMayController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [NhatKyPhongMayController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [NhatKyPhongMayController::class, 'destroy'])->name('destroy');
        Route::get('/search-phong', [NhatKyPhongMayController::class, 'searchPhongMay'])->name('search-phong');
        Route::get('/loadTable', [NhatKyPhongMayController::class, 'loadTable'])->name('loadTable');
        Route::put('/update-status-pc/{idtb}', [NhatKyPhongMayController::class, 'updateStatusPC'])->name('update-status-pc');
    });
    Route::prefix('loainoithat')->name('loainoithat.')->group(function () {
        Route::get('/', [LoaiNoiThatController::class, 'index'])->name('index');
        Route::post('/create', [LoaiNoiThatController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [LoaiNoiThatController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [LoaiNoiThatController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [LoaiNoiThatController::class, 'destroy'])->name('destroy');
    });
    
    // Routes quản lý biểu mẫu
    Route::prefix('bieumau')->name('bieumau.')->group(function () {
        Route::get('/', [BieuMauController::class, 'index'])->name('index');
        Route::post('/create', [BieuMauController::class, 'store'])->name('store');
        Route::put('/upd/{id}', [BieuMauController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [BieuMauController::class, 'edit'])->name('edit');
        Route::delete('/del/{id}', [BieuMauController::class, 'destroy'])->name('destroy');
        Route::get('/download/{id}', [BieuMauController::class, 'download'])->name('download');
        Route::post('/upload', [BieuMauController::class, 'upload'])->name('upload');
        
        // Biểu mẫu thiết bị
        Route::get('/thietbi', [App\Http\Controllers\QuanLyBieuMau\BieuMauThietBi::class, 'index'])->name('thietbi');
        Route::post('/thietbi/store', [\App\Http\Controllers\QuanLyBieuMau\BieuMauThietBi::class, 'store'])->name('thietbi.store');
        Route::get('/thietbi/download/{id}', [\App\Http\Controllers\QuanLyBieuMau\BieuMauThietBi::class, 'download'])->name('thietbi.download');
        Route::delete('/thietbi/delete/{id}', [\App\Http\Controllers\QuanLyBieuMau\BieuMauThietBi::class, 'destroy'])->name('thietbi.destroy');
        Route::get('/thietbi/{id}/edit', [BieuMauThietBi::class, 'edit'])->name('thietbi.edit');
        Route::put('/thietbi/{id}/update', [BieuMauThietBi::class, 'update'])->name('thietbi.update');
        
        // Biểu mẫu nội thất
        Route::get('/noithat', [\App\Http\Controllers\QuanLyBieuMau\BieuMauNoiThat::class, 'index'])->name('noithat');
        Route::post('/noithat/store', [\App\Http\Controllers\QuanLyBieuMau\BieuMauNoiThat::class, 'store'])->name('noithat.store');
        
        // Sổ quản lý kho
        Route::get('/sokho', [\App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController::class, 'index'])->name('sokho');
        Route::get('/sokho/download/{id}', [\App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController::class, 'download'])->name('sokho.download');
        Route::get('/sokho/print', [\App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController::class, 'print'])->name('sokho.print');
        Route::get('/sokho/print-lylich', [\App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController::class, 'printLyLich'])->name('sokho.print-lylich');
        Route::get('/sokho/print-sanxuat', [\App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController::class, 'printSanXuat'])->name('sokho.print-sanxuat');
        Route::get('/bieumau/phongkho/get-by-khoa', [\App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController::class, 'getPhongByKhoa'])->name('bieumau.phongkho.get-by-khoa');
        
        // Nhật ký phòng máy
        Route::get('/nhatky', [\App\Http\Controllers\QuanLyBieuMau\NhatKyPhongMay::class, 'index'])->name('nhatky');
        Route::post('/nhatky/store', [\App\Http\Controllers\QuanLyBieuMau\NhatKyPhongMay::class, 'store'])->name('nhatky.store');
        Route::get('/bieumau/nhatky/download/{id}', [\App\Http\Controllers\QuanLyBieuMau\NhatKyPhongMay::class, 'download'])->name('bieumau.nhatky.download');
        Route::get('/bieumau/nhatky/export/{khoaId}/{phongId}', [\App\Http\Controllers\QuanLyBieuMau\NhatKyPhongMay::class, 'export'])->name('bieumau.nhatky.export');
    });
});

// Thêm các routes sau (thay vì đổi tên controller, sử dụng tên class hiện tại)
Route::get('bieumau/nhatky', 'App\Http\Controllers\QuanLyBieuMau\NhatKyPhongMay@index')->name('bieumau.nhatky');
Route::get('bieumau/nhatky/download/{id}', 'App\Http\Controllers\QuanLyBieuMau\NhatKyPhongMay@download')->name('bieumau.nhatky.download');
Route::get('bieumau/nhatky/export/{khoaId}/{phongId}', 'App\Http\Controllers\QuanLyBieuMau\NhatKyPhongMay@export')->name('bieumau.nhatky.export');
Route::get('bieumau/phongbykhoa', 'App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController@getPhongByKhoa')->name('bieumau.phongbykhoa');
Route::get('bieumau/phongkho/get-by-khoa', 'App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController@getPhongByKhoa')->name('bieumau.phongkho.get-by-khoa');

// Thêm routes mới cho in sổ quản lý kho
Route::get('bieumau/sokho/export/{khoaId}/{phongId}', 'BieuMauController@exportSoKho')->name('bieumau.sokho.export');
Route::get('bieumau/lylich/export/{khoaId}/{phongId}', 'App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController@printLyLich')->name('bieumau.lylich.export');
Route::get('bieumau/sanxuat/export/{khoaId}/{phongId}', 'App\Http\Controllers\QuanLyBieuMau\SoQuanLyKhoController@printSanXuat')->name('bieumau.sanxuat.export');
