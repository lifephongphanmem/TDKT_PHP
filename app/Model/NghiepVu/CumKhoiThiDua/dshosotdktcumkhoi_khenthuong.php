<?php

namespace App\Model\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi_khenthuong extends Model
{
    protected $table = 'dshosotdktcumkhoi_khenthuong';
    protected $fillable = [
        'id',
        'stt',
        'mahosotdkt',
        'madanhhieutd',
        'phanloai', //cá nhân, tập thể           
        //Thông tin cá nhân 
        'madoituong',
        'maccvc',
        'tendoituong',
        'ngaysinh',
        'gioitinh',
        'chucvu',
        'lanhdao',
        //Thông tin tập thể
        'matapthe',
        'tentapthe',
        'ghichu', //
        //Kết quả đánh giá
        'ketqua',
        'mahinhthuckt',
        'lydo',
        'madonvi', //phục vụ lấy dữ liệu
        //Đề tài, sáng kiến
        'tensangkien',//tên đề tài, sáng kiến
        'donvicongnhan',
        'thoigiancongnhan',
        'thanhtichdatduoc',
        'filedk',
    ];
}
