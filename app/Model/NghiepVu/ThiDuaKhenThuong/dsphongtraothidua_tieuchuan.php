<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dsphongtraothidua_tieuchuan extends Model
{
    protected $table = 'dsphongtraothidua_tieuchuan';
    protected $fillable = [
        'id',
        'stt',
        'maphongtraotd', // ký hiệu
        'madanhhieutd',
        'matieuchuandhtd',
        'tentieuchuandhtd',
        'cancu',
        'ghichu',
        'batbuoc',
    ];
}
