<?php

namespace App\Model\HeThong;

use Illuminate\Database\Eloquent\Model;

class hethongchung extends Model
{
    protected $table = 'HeThongChung';
    protected $fillable = [
        'id',
        'phanloai',
        'tendonvi',
        'maqhns',
        'diachi',
        'dienthoai',
        'thutruong',
        'ketoan',
        'nguoilapbieu',
        'diadanh',
        'thietlap',
        'thongtinhd',
        'emailql',
        'tendvhienthi',
        'tendvcqhienthi',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
        'solandn',
        //thông tin Form giới thiệu
        'tencongtycongty',
        'sodienthoaicongty',
        'diachicongty',
        'logocongty',
    ];
}
