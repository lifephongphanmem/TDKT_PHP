<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;

class viewdonvi_dsphongtrao extends Model
{
    protected $table = 'viewdonvi_dsphongtrao';
    protected $fillable = [        
    ];
}

// CREATE OR ALTER VIEW [dbo].[viewdonvi_dsphongtrao]
// AS
// SELECT        dbo.dsphongtraothidua.maphongtraotd, dbo.dsphongtraothidua.maloaihinhkt, dbo.dsphongtraothidua.soqd, dbo.dsphongtraothidua.ngayqd, dbo.dsphongtraothidua.noidung, dbo.dsphongtraothidua.phamviapdung, 
//                          dbo.dsphongtraothidua.tungay, dbo.dsphongtraothidua.denngay, dbo.dsphongtraothidua.ghichu, dbo.dsphongtraothidua.madonvi, dbo.dsphongtraothidua.totrinh, dbo.dsphongtraothidua.qdkt, dbo.dsphongtraothidua.bienban, 
//                          dbo.dsphongtraothidua.tailieukhac, dbo.dsdonvi.tendonvi, dbo.dsdiaban.tendiaban, dbo.dsdiaban.madiaban, dbo.dsdiaban.capdo, dbo.dsphongtraothidua.madonvi_nhan, dbo.dsphongtraothidua.lydo, 
//                          dbo.dsphongtraothidua.thongtin, dbo.dsphongtraothidua.trangthai, dbo.dsphongtraothidua.thoigian, dbo.dsphongtraothidua.madonvi_h, dbo.dsphongtraothidua.madonvi_nhan_h, dbo.dsphongtraothidua.lydo_h, 
//                          dbo.dsphongtraothidua.thongtin_h, dbo.dsphongtraothidua.trangthai_h, dbo.dsphongtraothidua.thoigian_h, dbo.dsphongtraothidua.madonvi_t, dbo.dsphongtraothidua.madonvi_nhan_t, dbo.dsphongtraothidua.lydo_t, 
//                          dbo.dsphongtraothidua.thongtin_t, dbo.dsphongtraothidua.trangthai_t, dbo.dsphongtraothidua.madonvi_tw, dbo.dsphongtraothidua.thoigian_t, dbo.dsphongtraothidua.lydo_tw, dbo.dsphongtraothidua.madonvi_nhan_tw, 
//                          dbo.dsphongtraothidua.thongtin_tw, dbo.dsphongtraothidua.trangthai_tw, dbo.dsphongtraothidua.thoigian_tw, dbo.dsphongtraothidua.phanloai, dbo.dsphongtraothidua.khauhieu
// FROM            dbo.dsdonvi INNER JOIN
//                          dbo.dsphongtraothidua ON dbo.dsdonvi.madonvi = dbo.dsphongtraothidua.madonvi INNER JOIN
//                          dbo.dsdiaban ON dbo.dsdonvi.madiaban = dbo.dsdiaban.madiaban
// GO