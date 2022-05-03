<?php

namespace App\Http\Controllers\TraCuu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\View\view_cumkhoi_canhan;
use App\Model\View\view_cumkhoi_tapthe;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_tapthe;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class tracuutaptheController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $m_tapthe = view_tdkt_tapthe::all();
            return view('TraCuu.TapThe.ThongTin')
                ->with('m_tapthe', $m_tapthe)
                ->with('pageTitle', 'Tìm kiếm thông tin theo cá nhân');
        } else
            return view('errors.notlogin');
    }   
    
    public function KetQua(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = view_tdkt_tapthe::where('tentapthe','like','%'.$inputs['tentapthe'].'%');
            $m_cumkhoi = view_cumkhoi_tapthe::where('tentapthe','Like','%'.$inputs['tentapthe'].'%');

            $model = $model->get();
            $m_cumkhoi = $m_cumkhoi->get();
            foreach($m_cumkhoi as $khenthuong){
                $model->add($khenthuong);
            }
            $detai = new Collection();
            foreach($model as $chitiet){
                if(isset($chitiet->tensangkien) && $chitiet->tensangkien != '')
                    $detai->add($chitiet);
            }
            return view('TraCuu.TapThe.KetQua')
                ->with('model', $model->first())
                ->with('khenthuong', $model)
                ->with('detai', $detai)
                ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('pageTitle', 'Kết quả tìm kiếm');
        } else
            return view('errors.notlogin');
    }    
}
