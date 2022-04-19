<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dscumkhoi_chitiet extends Model
{
    protected $table = 'dscumkhoi_chitiet';
    protected $fillable = [
        'id',
        'macumkhoi',
        'madonvi',
        'phanloai',        
        'ghichu',
    ];
}
