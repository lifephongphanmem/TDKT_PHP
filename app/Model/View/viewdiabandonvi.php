<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;

class viewdiabandonvi extends Model
{
    protected $table = 'viewdiabandonvi';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[viewdiabandonvi]
// AS
// SELECT        dbo.dsdiaban.tendiaban, dbo.dsdiaban.capdo, dbo.dsdiaban.madiaban, dbo.dsdiaban.madonviQL, dbo.dsdiaban.madiabanQL, dbo.dsdonvi.madonvi, dbo.dsdonvi.tendonvi
// FROM            dbo.dsdonvi INNER JOIN
//                          dbo.dsdiaban ON dbo.dsdonvi.madiaban = dbo.dsdiaban.madiaban
// GO
