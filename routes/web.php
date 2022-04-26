<?php

Route::get('','HeThong\hethongchungController@index');

Route::get('thongtinhotro',function(){
    return view('thongtinhotro')
        ->with('pageTitle','Thông tin hỗ trợ');
});
//Hệ thống
include('hethong.php');
include('danhmuc.php');
include('thiduakhenthuongcaccap.php');
include('cumkhoi.php');
