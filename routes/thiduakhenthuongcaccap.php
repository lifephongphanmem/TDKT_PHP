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