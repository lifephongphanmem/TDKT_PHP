<?php

Route::group(['prefix'=>'DanhHieuThiDua'], function(){
    Route::get('ThongTin','DanhMuc\dmdanhhieuthiduaController@ThongTin');
    Route::post('Them','DanhMuc\dmdanhhieuthiduaController@store');
    Route::post('Xoa','HeThong\dmdanhhieuthiduaController@delete');
    Route::get('TieuChuan','DanhMuc\dmdanhhieuthiduaController@TieuChuan');
    Route::post('TieuChuan','DanhMuc\dmdanhhieuthiduaController@ThemTieuChuan');
    Route::post('XoaTieuChuan','HeThong\dmdanhhieuthiduaController@delete_TieuChuan');
    //Route::get('Sua','system\DSTaiKhoanController@edit');
});

Route::group(['prefix'=>'LoaiHinhKhenThuong'], function(){
    Route::get('ThongTin','DanhMuc\dmloaihinhkhenthuongController@ThongTin');
    Route::post('Them','DanhMuc\dmloaihinhkhenthuongController@store');
    Route::post('Xoa','HeThong\dmloaihinhkhenthuongController@delete');
});

Route::group(['prefix'=>'HinhThucKhenThuong'], function(){
    Route::get('ThongTin','DanhMuc\dmhinhthuckhenthuongController@ThongTin');
    Route::post('Them','DanhMuc\dmhinhthuckhenthuongController@store');
    Route::post('Xoa','HeThong\dmhinhthuckhenthuongController@delete');
});

