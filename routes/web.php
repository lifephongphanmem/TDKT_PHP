<?php

Route::get('','HeThong\HeThongChungController@index');

Route::get('thongtinhotro',function(){
    return view('thongtinhotro')
        ->with('pageTitle','Thông tin hỗ trợ');
});
//System
include('HeThong.php');
