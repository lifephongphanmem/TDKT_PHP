<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmdanhhieuthidua_tieuchuan extends Model
{
    protected $table = 'dmdanhhieuthidua_tieuchuan';
    protected $fillable = [
        'id',
        'stt',
        'madanhhieutd',
        'matieuchuandhtd',
        'tentieuchuandhtd',
        'cancu',
        'ghichu',
    ];
}
