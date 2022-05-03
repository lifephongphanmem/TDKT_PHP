<?php

Route::group(['prefix'=>'BaoCao'], function(){
    Route::group(['prefix'=>'DonVi'], function(){
        Route::get('ThongTin','BaoCao\baocaodonviController@ThongTin');
    });
    Route::group(['prefix'=>'TongHop'], function(){
        Route::get('ThongTin','BaoCao\baocaotonghopController@ThongTin');
        Route::post('PhongTrao','BaoCao\baocaotonghopController@PhongTrao');
    });
});


