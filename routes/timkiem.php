<?php

Route::group(['prefix'=>'TraCuu'], function(){
    Route::group(['prefix'=>'CaNhan'], function(){
        Route::get('ThongTin','DanhMuc\dmdanhhieuthiduaController@ThongTin');
        Route::post('Them','DanhMuc\dmdanhhieuthiduaController@store');
    });
});


