<?php

Route::group(['prefix'=>'DangKyDanhHieu'], function(){
    Route::group(['prefix'=>'HoSo'], function(){
        Route::get('ThongTin','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThongTin');
        Route::post('Them','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@Them');
        Route::get('Sua','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThayDoi');
        Route::post('Sua','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@LuuHoSo');        
        Route::get('Xem','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@XemHoSo');
        Route::post('CaNhan','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThemCaNhan');
        Route::post('TapThe','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThemTapThe');
        Route::get('LayDoiTuong','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@LayDoiTuong');
        Route::post('ChuyenHoSo','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ChuyenHoSo');
        Route::get('LayLyDo','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@LayLyDo');
    });

    Route::group(['prefix'=>'XetDuyet'], function(){
        Route::get('ThongTin','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@ThongTin');
        Route::post('TraLai','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@TraLai');
        Route::post('NhanHoSo','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@NhanHoSo');
        Route::post('ChuyenHoSo','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@ChuyenHoSo');
    });
});


