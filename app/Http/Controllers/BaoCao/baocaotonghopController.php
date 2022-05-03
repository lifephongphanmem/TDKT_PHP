<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaotonghopController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $m_diaban = dsdiaban::all();
            return view('BaoCao.TongHop.ThongTin')
                ->with('m_diaban', $m_diaban)
                ->with('a_diaban', array_column($m_diaban->toArray(), 'tendiaban', 'madiaban'))
                ->with('pageTitle', 'Báo cáo theo đơn vị');
        } else
            return view('errors.notlogin');
    }

    public function PhongTrao(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dsphongtraothidua::all();
            $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($model->toArray(), 'madonvi'))->get();
            $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
            foreach ($model as $ct) {
                $ct->madiaban = $m_donvi->where('madonvi', $ct->madonvi)->first()->madiaban;
            }
            return view('BaoCao.TongHop.PhongTrao')
                ->with('model', $model)
                ->with('m_donvi', $m_donvi->first())
                ->with('a_diaban', $a_diaban)
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_phamvi', getPhamViPhongTrao())
                ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
        } else
            return view('errors.notlogin');
    }
}
