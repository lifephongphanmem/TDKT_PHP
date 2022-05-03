<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaodonviController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            
            return view('BaoCao.DonVi.ThongTin')
                ->with('pageTitle', 'Báo cáo theo đơn vị');
        } else
            return view('errors.notlogin');
    }   
    
      
}
