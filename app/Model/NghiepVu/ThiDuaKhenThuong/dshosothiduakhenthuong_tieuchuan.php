<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong_tieuchuan extends Model
{
    protected $table = 'dshosothiduakhenthuong_tieuchuan';
    protected $fillable = [
        'id',
        'stt',
        'mahosotdkt',
        'madoituong',
        'matapthe',
        'madanhhieutd',
        'matieuchuandhtd',
        'dieukien',
        'mota',
    ];
}
