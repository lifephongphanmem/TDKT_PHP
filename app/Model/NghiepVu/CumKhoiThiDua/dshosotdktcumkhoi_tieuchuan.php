<?php

namespace App\Model\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi_tieuchuan extends Model
{
    protected $table = 'dshosotdktcumkhoi_tieuchuan';
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
