<?php
//Phong trào thi đua
Route::group(['prefix'=>'PhongTraoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThongTin');
    Route::get('Xem','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@XemThongTin');
    Route::get('Them','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Them','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');
    Route::get('Sua','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Sua','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');

    Route::get('ThemKhenThuong','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemKhenThuong');
    Route::get('ThemTieuChuan','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemTieuChuan');
    Route::get('LayTieuChuan','NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LayTieuChuan');

    //Route::get('Sua','system\DSTaiKhoanController@edit');
});

Route::group(['prefix'=>'HoSoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThongTin');
    Route::get('Them','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemHoSo');    
    Route::post('Them','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');    
    Route::get('Sua','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThayDoi');
    Route::post('Sua','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Xem','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XemHoSo');

    Route::get('ThemDoiTuong','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemDoiTuong');
    Route::get('ThemDoiTuongTapThe','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemDoiTuongTapThe');
    Route::get('LayDoiTuong','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayDoiTuong');

    Route::get('LayTieuChuan','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayTieuChuan');
    Route::get('LuuTieuChuan','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuTieuChuan');
    Route::post('ChuyenHoSo','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ChuyenHoSo');
    Route::post('delete','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@delete');
    Route::get('LayLyDo','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayLyDo');
    Route::get('XoaDoiTuong','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XoaDoiTuong');
});

Route::group(['prefix'=>'XetDuyetHoSoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ThongTin');
    Route::get('DanhSach','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@DanhSach');
    Route::post('TraLai','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@TraLai'); 
    Route::get('Xem','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@XemDanhSach');

    Route::post('ChuyenHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ChuyenHoSo'); 
    Route::post('NhanHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@NhanHoSo');
    
    Route::post('KetThuc','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@KetThuc');
});

Route::group(['prefix'=>'KhenThuongHoSoThiDua'], function(){
    Route::get('ThongTin','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@ThongTin');
    Route::post('KhenThuong','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KhenThuong');
    Route::get('DanhSach','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@DanhSach');
    Route::post('LuuHoSo','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LuuHoSo');
    Route::get('Xem','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@XemHoSo');

    Route::post('HoSo','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@HoSo');
    Route::post('KetQua','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KetQua');
    Route::post('PheDuyet','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@PheDuyet');

    Route::get('InKetQua','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InKetQua');
    Route::get('InQuyetDinh','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InQuyetDinh');
    Route::post('InQuyetDinh','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LuuQuyetDinh');
    Route::get('LayTieuChuan','NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LayTieuChuan');
});
//

//Khen thưởng theo công trạng
Route::group(['prefix'=>'KhenThuongCongTrang'], function(){
    Route::group(['prefix'=>'HoSoKhenThuong'], function(){
        Route::get('ThongTin','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThongTin');
        Route::post('Them','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@Them');
        Route::get('Sua','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThayDoi');
        Route::post('Sua','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LuuHoSo');
        Route::get('Xem','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@XemHoSo');
        Route::post('CaNhan','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThemCaNhan');
        Route::post('TapThe','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThemTapThe');
        Route::get('LayTieuChuan','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayTieuChuan');
        Route::get('LayDoiTuong','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayDoiTuong');
        Route::post('ChuyenHoSo','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ChuyenHoSo');
        Route::get('LayLyDo','NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayLyDo');
    });

    Route::group(['prefix'=>'XetDuyetHoSo'], function(){
        Route::get('ThongTin','NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@ThongTin');
        Route::post('TraLai','NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@TraLai');
        Route::post('NhanHoSo','NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@NhanHoSo');
        Route::post('ChuyenHoSo','NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@ChuyenHoSo');
    });
    Route::group(['prefix'=>'QuyetDinhKhenThuong'], function(){
        Route::get('ThongTin','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@ThongTin');
        Route::post('KhenThuong','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@KhenThuong');
        Route::get('DanhSach','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@DanhSach');
        Route::post('DanhSach','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@LuuHoSo');
        Route::post('PheDuyet','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@PheDuyet');
        Route::post('HoSo','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@HoSo');
        Route::post('KetQua','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@KetQua');

        Route::get('InQuyetDinh','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@InQuyetDinh');
        Route::post('InQuyetDinh','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@LuuQuyetDinh');
        Route::get('LayTieuChuan','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@LayTieuChuan');
        Route::get('Xem','NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@XemHoSo');

    });
});


//