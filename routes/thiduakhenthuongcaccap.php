<?php

Route::group(['prefix'=>'PhongTraoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThongTin');
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
    Route::get('Them','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThayDoi');
    Route::post('Them','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');    

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
});