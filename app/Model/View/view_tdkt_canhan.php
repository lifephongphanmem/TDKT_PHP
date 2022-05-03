<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;

class view_tdkt_canhan extends Model
{
    protected $table = 'view_tdkt_canhan';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_tdkt_canhan]
// AS
// SELECT        dbo.dshosokhenthuong_khenthuong.madanhhieutd, dbo.dshosokhenthuong_khenthuong.madoituong, dbo.dshosokhenthuong_khenthuong.ketqua, dbo.dshosothiduakhenthuong_khenthuong.tendoituong, 
//                          dbo.dshosothiduakhenthuong_khenthuong.ngaysinh, dbo.dshosothiduakhenthuong_khenthuong.gioitinh, dbo.dshosothiduakhenthuong_khenthuong.chucvu, dbo.dshosothiduakhenthuong_khenthuong.lanhdao, 
//                          dbo.dshosokhenthuong_khenthuong.mahinhthuckt, dbo.dshosothiduakhenthuong_khenthuong.tensangkien, dbo.dshosothiduakhenthuong_khenthuong.donvicongnhan, 
//                          dbo.dshosothiduakhenthuong_khenthuong.thanhtichdatduoc, dbo.dshosothiduakhenthuong_khenthuong.filedk, dbo.dshosothiduakhenthuong_khenthuong.thoigiancongnhan, dbo.dshosokhenthuong_khenthuong.mahosokt
// FROM            dbo.dshosokhenthuong_khenthuong INNER JOIN
//                          dbo.dshosothiduakhenthuong_khenthuong ON dbo.dshosokhenthuong_khenthuong.mahosotdkt = dbo.dshosothiduakhenthuong_khenthuong.mahosotdkt AND 
//                          dbo.dshosokhenthuong_khenthuong.madoituong = dbo.dshosothiduakhenthuong_khenthuong.madoituong
// GO