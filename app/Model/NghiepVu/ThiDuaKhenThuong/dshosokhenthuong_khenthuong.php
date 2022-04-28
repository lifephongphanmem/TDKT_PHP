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
        'noidungkhenthuong',
        'phanloai', //cá nhân, tập thể           
        //Thông tin cá nhân 
        'madoituong',
        'matapthe',
        'tentapthe',
        //Kết quả đánh giá
        'ketqua',
        'mahinhthuckt',
        'lydo',
        'madonvi', //phục vụ lấy dữ liệu
    ];
}
