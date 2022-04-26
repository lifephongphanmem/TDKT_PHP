<?php
//Đăng nhập
Route::get('DangNhap','HeThong\hethongchungController@DangNhap');
Route::post('DangNhap','HeThong\hethongchungController@XacNhanDangNhap');
Route::post('QuenMatKhau','HeThong\hethongchungController@QuenMatKhau');
Route::get('DangXuat','HeThong\hethongchungController@DangXuat');

Route::group(['prefix'=>'HeThongChung'], function(){
    Route::get('ThongTin','GeneralConfigsController@index');
    Route::get('ThayDoi','GeneralConfigsController@edit');
    Route::post('ThayDoi','GeneralConfigsController@update');
});
Route::group(['prefix'=>'DiaBan'], function(){
    Route::get('ThongTin','HeThong\dsdiabanController@index');
    Route::post('Sua','HeThong\dsdiabanController@modify');
    Route::post('delete','HeThong\dsdiabanController@delete');
});

Route::group(['prefix'=>'DonVi'], function(){
    Route::get('ThongTin','HeThong\dsdonviController@ThongTin');
    Route::get('DanhSach','HeThong\dsdonviController@DanhSach');
    Route::get('Them','HeThong\dsdonviController@create');
    Route::post('Them','HeThong\dsdonviController@store');
    Route::get('Sua','HeThong\dsdonviController@edit');
    Route::post('Sua','HeThong\dsdonviController@store');
    Route::post('Xoa','HeThong\dsdonviController@destroy');
    Route::get('QuanLy','HeThong\dsdonviController@QuanLy');
    Route::post('QuanLy','HeThong\dsdonviController@LuuQuanLy');

});

Route::group(['prefix'=>'TaiKhoan'], function(){
    Route::get('ThongTin','HeThong\DSTaiKhoanController@ThongTin');
    Route::get('Them','HeThong\DSTaiKhoanController@create');
    Route::post('Them','HeThong\DSTaiKhoanController@store');
    Route::get('Sua','HeThong\DSTaiKhoanController@edit');

});
Route::group(['prefix'=>'HeThongAPI'], function(){
    Route::get('CaNhan','HeThong\HeThongAPIController@CaNhan');
    Route::get('TapThe','HeThong\HeThongAPIController@TapThe');
    Route::get('PhongTrao','HeThong\HeThongAPIController@PhongTrao');
});