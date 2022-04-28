<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong_khenthuong extends Model
{
    protected $table = 'dshosothiduakhenthuong_khenthuong';
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
        'tensangkien', //tên đề tài, sáng kiến
        'donvicongnhan',
        'thoigiancongnhan',
        'thanhtichdatduoc',
        'filedk',
    ];
}
