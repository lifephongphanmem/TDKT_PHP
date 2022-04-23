<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosokhenthuong_chitiet extends Model
{
    protected $table = 'dshosokhenthuong_chitiet';
    protected $fillable = [
        'id',
        'mahosokt',
        'mahosotdkt', //lưu trữ sau cần dùng            
        'ketqua',
        'lydo',
        'madonvi', //phục vụ lấy dữ liệu
    ];
}
