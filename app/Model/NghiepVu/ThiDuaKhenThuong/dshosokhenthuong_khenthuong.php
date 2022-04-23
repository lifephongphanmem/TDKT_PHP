<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosokhenthuong_khenthuong extends Model
{
    protected $table = 'dshosokhenthuong_khenthuong';
    protected $fillable = [
        'id',
        'stt',
        'mahosokt',
        'mahosotdkt', //lưu trữ sau cần dùng
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
    ];
}
