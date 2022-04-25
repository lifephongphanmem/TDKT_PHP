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

        Route::post('Xoa','NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaHoSo');
    });
});