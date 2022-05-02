<?php

namespace App\Model\NghiepVu\DangKyDanhHieu;

use Illuminate\Database\Eloquent\Model;

class dshosodangkyphongtraothidua_chitiet extends Model
{
    protected $table = 'dshosodangkyphongtraothidua_chitiet';
    protected $fillable = [
        'id',
        'mahosodk',
        'madanhhieutd',//có thể chọn nhiều
        'phanloai',//cá nhân, tập thể
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
        'ghichu',//
        //Kết quả đánh giá
        'madonvi',//phục vụ lấy dữ liệu
    ];
}
