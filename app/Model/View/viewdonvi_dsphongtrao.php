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
//                          dbo.dsphongtraothidua.tailieukhac, dbo.dsdonvi.tendonvi, dbo.dsdiaban.tendiaban, dbo.dsdiaban.madiaban, dbo.dsdiaban.capdo
// FROM            dbo.dsdonvi INNER JOIN
//                          dbo.dsphongtraothidua ON dbo.dsdonvi.madonvi = dbo.dsphongtraothidua.madonvi INNER JOIN
//                          dbo.dsdiaban ON dbo.dsdonvi.madiaban = dbo.dsdiaban.madiaban
// GO