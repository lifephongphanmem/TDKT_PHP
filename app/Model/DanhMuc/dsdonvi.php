<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dsdonvi extends Model
{
    protected $table = 'dsdonvi';
    protected $fillable = [
        'id',
        'madiaban',
        'madonvi',
        'maqhns',
        'tendonvi',
        'diachi',
        'sodt',
        'cdlanhdao',
        'lanhdao',
        'cdketoan',
        'ketoan',
        'songuoi',
        'diadanh',
        'nguoilapbieu',
        'madonviQL',
        'caphanhchinh',
        'maphanloai',
        'linhvuchoatdong', //lĩnh vực hoạt động
        'ngaydung',
        'chuyendoi',
        'trangthai',
        'sotk',
        'tennganhang',
        'madinhdanh',
        'tendvhienthi',
        'tendvcqhienthi',
    ];
}
