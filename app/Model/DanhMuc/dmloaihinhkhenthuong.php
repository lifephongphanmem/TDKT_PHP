<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmloaihinhkhenthuong extends Model
{
    protected $table = 'dmloaihinhkhenthuong';
    protected $fillable = [
        'id',
        'stt',
        'maloaihinhkt',
        'tenloaihinhkt',
        'phanloai',
        'ghichu',
        'ttnguoitao',
        'phamviapdung',
    ];
}
