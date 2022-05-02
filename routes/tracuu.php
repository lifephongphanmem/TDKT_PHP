<?php

Route::group(['prefix'=>'TraCuu'], function(){
    Route::group(['prefix'=>'CaNhan'], function(){
        Route::get('ThongTin','TraCuu\tracuucanhanController@ThongTin');
        Route::post('ThongTin','DanhMuc\dmdanhhieuthiduaController@KetQua');
    });
});


