<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong extends Model
{
    protected $table = 'dshosothiduakhenthuong';
    protected $fillable = [
        'id',
        'mahosotdkt',
        'ngayhoso',
        'noidung',
        'phanloai', //hồ sơ thi đua; hồ sơ khen thưởng (để sau thống kê)
        'maloaihinhkt', //lấy từ phong trào nếu là hồ sơ thi đua
        'maphongtraotd', //tùy theo phân loại
        'ghichu',
        'madonvi',
        //File đính kèm
        'baocao', //báo cáo thành tích
        'bienban', //biên bản cuộc họp
        'tailieukhac', //tài liệu khác
        //Kết quả khen thưởng
        'mahosokt',
    ];
}
