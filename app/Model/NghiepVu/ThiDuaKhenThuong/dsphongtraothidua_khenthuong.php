<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dsphongtraothidua_khenthuong extends Model
{
    protected $table = 'dsphongtraothidua_khenthuong';
    protected $fillable = [
        'id',
        'stt',
        'maphongtraotd',
        'madanhhieutd',
        'tendanhhieutd', // tên danh hiệu thi đua
        'mahinhthuckt', // tên hình thức thi đua
        'phanloai',
        'soluong', // số lượng giải thưởng, khen thưởng
        'sotien', // số tiền (tương đương )
        'ghichu', //
    ];
}
