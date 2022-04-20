<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dsphongtraothidua extends Model
{
    protected $table = 'dsphongtraothidua';
    protected $fillable = [
        'id',
        'maphongtraotd',
        'maloaihinhkt',
        'soqd', // Số quyết định
        'ngayqd', // Ngày quyết định
        'noidung',
        'tungay', // Ngày bắt đầu nhận hồ sơ
        'denngay', // Ngày kết thúc nhận hồ sơ
        'madonvi', // Mã đơn vị
        'ghichu',
        //tài liệu đính kèm
        'totrinh', // Tờ trình
        'qdkt', // Quyết định
        'bienban', // Biên bản           
        'tailieukhac', // Tài liệu khác
        'phamviapdung',
    ];
}
