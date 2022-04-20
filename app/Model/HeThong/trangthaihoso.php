<?php

namespace App\Model\HeThong;

use Illuminate\Database\Eloquent\Model;

class trangthaihoso extends Model
{
    protected $table = 'trangthaihoso';
    protected $fillable = [
        'id',
        'phanloai', //Tên bảng
        'mahoso', //Mã phong trào, Mã hồ sơ
        'madonvi',
        'madonvi_nhan',
        'lydo',
        'thongtin',
        'trangthai',
        'thoigian',
        'tendangnhap',
    ];
}
