<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmdanhhieuthidua extends Model
{
    protected $table = 'dmdanhhieuthidua';
    protected $fillable = [
        'id',
        'stt',
        'madanhhieutd',
        'tendanhhieutd',
        'phanloai',
        'ghichu',
        'ttnguoitao',
        'phamviapdung',
    ];
}
