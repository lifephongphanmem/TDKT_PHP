<?php
Route::group(['prefix'=>'CumKhoiThiDua'], function(){
    Route::group(['prefix'=>'DanhSach'], function(){
        Route::get('ThongTin','NghiepVu\CumKhoiThiDua\dscumkhoiController@ThongTin');
        Route::get('Them','NghiepVu\CumKhoiThiDua\dscumkhoiController@ThayDoi');
        Route::post('Them','NghiepVu\CumKhoiThiDua\dscumkhoiController@LuuCumKhoi');
        Route::get('Sua','NghiepVu\CumKhoiThiDua\dscumkhoiController@ThayDoi');
        Route::post('Sua','NghiepVu\CumKhoiThiDua\dscumkhoiController@LuuCumKhoi');
        Route::post('Xoa','NghiepVu\CumKhoiThiDua\dscumkhoiController@Xoa');

        Route::get('DanhSach','NghiepVu\CumKhoiThiDua\dscumkhoiController@DanhSach');
        Route::post('ThemDonVi','NghiepVu\CumKhoiThiDua\dscumkhoiController@ThemDonVi');
        Route::post('XoaDonVi','NghiepVu\CumKhoiThiDua\dscumkhoiController@XoaDonVi');
    });
    Route::group(['prefix'=>'HoSoKhenThuong'], function(){
        Route::get('ThongTin','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThongTin');
        Route::get('DanhSach','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@DanhSach');

        Route::get('Them','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThayDoi');
        Route::post('Them','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');
        Route::get('Sua','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@Sua');
        Route::post('Sua','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');

        Route::get('ThemDoiTuong','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuong');
        Route::get('ThemDoiTuongTapThe','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuongTapThe');
        Route::get('LayTieuChuan','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayTieuChuan');
        Route::get('LuuTieuChuan','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuTieuChuan');
        
        Route::get('LayLyDo','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayLyDo');
        Route::get('XoaDoiTuong','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaDoiTuong');

        Route::post('Xoa','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaHoSo');
        Route::post('ChuyenHoSo','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ChuyenHoSo');
    });

    Route::group(['prefix'=>'XetDuyetHoSoKhenThuong'], function(){
        Route::get('ThongTin','NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController@ThongTin');
        
        
        
        Route::get('DanhSach','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@DanhSach');
        Route::post('TraLai','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@TraLai'); 
        
        Route::post('ChuyenHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ChuyenHoSo'); 
        Route::post('NhanHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@NhanHoSo');
        
        Route::post('KetThuc','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    });
});