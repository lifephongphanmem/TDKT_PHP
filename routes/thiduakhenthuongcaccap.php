<?php
//Phong trào thi đua
Route::group(['prefix'=>'PhongTraoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThongTin');
    Route::get('Xem','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@XemThongTin');
    Route::get('Them','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Them','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');
    Route::get('Sua','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Sua','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');

    Route::get('ThemKhenThuong','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemKhenThuong');
    Route::get('ThemTieuChuan','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemTieuChuan');
    Route::get('LayTieuChuan','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LayTieuChuan');

    //Route::get('Sua','system\DSTaiKhoanController@edit');
});

Route::group(['prefix'=>'HoSoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThongTin');
    Route::get('Them','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemHoSo');
    
    Route::post('Them','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');    
    Route::get('Sua','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThayDoi');
    Route::post('Sua','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Xem','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XemHoSo');

    Route::get('ThemDoiTuong','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemDoiTuong');
    Route::get('ThemDoiTuongTapThe','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemDoiTuongTapThe');
    Route::get('LayTieuChuan','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayTieuChuan');
    Route::get('LuuTieuChuan','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuTieuChuan');
    Route::post('ChuyenHoSo','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ChuyenHoSo');
    Route::post('delete','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@delete');
    Route::get('LayLyDo','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayLyDo');
    Route::get('XoaDoiTuong','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XoaDoiTuong');
});

Route::group(['prefix'=>'XetDuyetHoSoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ThongTin');
    Route::get('DanhSach','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@DanhSach');
    Route::post('TraLai','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@TraLai'); 
    
    Route::post('ChuyenHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ChuyenHoSo'); 
    Route::post('NhanHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@NhanHoSo');
    
    Route::post('KetThuc','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
});

Route::group(['prefix'=>'KhenThuongHoSoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@ThongTin');
    Route::post('KhenThuong','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KhenThuong');
    Route::get('DanhSach','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@DanhSach');

    Route::post('HoSo','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@HoSo');
    Route::post('KetQua','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KetQua');

    Route::get('InKetQua','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InKetQua');
});
//

//Khen thưởng theo công trạng
Route::group(['prefix'=>'KhenThuongCongTrang'], function(){
    Route::group(['prefix'=>'HoSoKhenThuong'], function(){
        Route::get('ThongTin','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThongTin');


        // Route::get('DanhSach','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@DanhSach');

        // Route::get('Them','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThayDoi');
        // Route::post('Them','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');
        // Route::get('Sua','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@Sua');
        // Route::post('Sua','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');

        // Route::get('ThemDoiTuong','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuong');
        // Route::get('ThemDoiTuongTapThe','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuongTapThe');
        // Route::get('LayTieuChuan','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayTieuChuan');
        // Route::get('LuuTieuChuan','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuTieuChuan');
        
        // Route::get('LayLyDo','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayLyDo');
        // Route::get('XoaDoiTuong','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaDoiTuong');

        // Route::post('Xoa','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaHoSo');
        // Route::post('ChuyenHoSo','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ChuyenHoSo');
    });
});


//