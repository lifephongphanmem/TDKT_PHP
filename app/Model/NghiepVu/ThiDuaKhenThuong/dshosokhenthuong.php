<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosokhenthuong extends Model
{
    protected $table = 'dshosokhenthuong';
    protected $fillable = [
        'id',
        'mahosokt',
        'ngayhoso',
        'noidung',
        'maloaihinhkt', //lấy từ phong trào nếu là hồ sơ thi đua
        'maphongtraotd', //tùy theo phân loại
        'mahosotdkt',
        'macumkhoi',
        'phanloai',//Cụm khối; TDKT
        'soquyetdinh',
        'thongtinquyetdinh',
        'donvikhenthuong',
        'capkhenthuong',
        'chucvunguoiky',
        'hotennguoiky',
        'ghichu',
        //File đính kèm
        'totrinh', // Tờ trình
        'qdkt', // Quyết định
        'bienban', //biên bản cuộc họp
        'tailieukhac', //tài liệu khác
        //Trạng thái đơn vị
        'madonvi',
        'madonvi_nhan',
        'lydo',
        'thongtin', //chưa dùng
        'trangthai',
        'thoigian',
        //Trạng thái huyện
        'madonvi_h',
        'madonvi_nhan_h',
        'lydo_h',
        'thongtin_h', //chưa dùng
        'trangthai_h',
        'thoigian_h',
        //Trạng thái tỉnh
        'madonvi_t',
        'madonvi_nhan_t',
        'lydo_t',
        'thongtin_t', //chưa dùng
        'trangthai_t',
        'thoigian_t',
        //Trạng thái trung ương
        'madonvi_tw',
        'madonvi_nhan_tw',
        'lydo_tw',
        'thongtin_tw', //chưa dùng
        'trangthai_tw',
        'thoigian_tw',
    ];
}
