<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;

class view_cumkhoi_tapthe extends Model
{
    protected $table = 'view_cumkhoi_tapthe';
    protected $fillable = [        
    ];
}

// CREATE OR ALTER VIEW [dbo].[view_cumkhoi_tapthe]
// AS
// SELECT        dbo.dshosokhenthuong_khenthuong.mahosokt, dbo.dshosokhenthuong_khenthuong.mahosotdkt, dbo.dshosokhenthuong_khenthuong.madanhhieutd, dbo.dshosokhenthuong_khenthuong.ketqua, 
//                          dbo.dshosokhenthuong_khenthuong.mahinhthuckt, dbo.dshosokhenthuong_khenthuong.madonvi, dbo.dshosotdktcumkhoi_khenthuong.tensangkien, dbo.dshosotdktcumkhoi_khenthuong.donvicongnhan, 
//                          dbo.dshosotdktcumkhoi_khenthuong.thoigiancongnhan, dbo.dshosotdktcumkhoi_khenthuong.thanhtichdatduoc, dbo.dshosotdktcumkhoi_khenthuong.filedk, dbo.dshosokhenthuong_khenthuong.matapthe, 
//                          dbo.dshosotdktcumkhoi_khenthuong.tentapthe
// FROM            dbo.dshosokhenthuong_khenthuong INNER JOIN
//                          dbo.dshosotdktcumkhoi_khenthuong ON dbo.dshosokhenthuong_khenthuong.mahosotdkt = dbo.dshosotdktcumkhoi_khenthuong.mahosotdkt AND 
//                          dbo.dshosokhenthuong_khenthuong.matapthe = dbo.dshosotdktcumkhoi_khenthuong.matapthe
// GO