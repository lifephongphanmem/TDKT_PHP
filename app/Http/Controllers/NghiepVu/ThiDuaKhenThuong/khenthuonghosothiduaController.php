<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\Session;

class khenthuonghosothiduaController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $m_donvi = getDonViXetDuyetHoSo(session('admin')->capdo, null, null, 'MODEL');
            $m_diaban = getDiaBanXetDuyetHoSo(session('admin')->capdo, null, null, 'MODEL');
            $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($m_donvi->toarray(), 'madonviQL'))->get();
            $inputs['nam'] = $inputs['nam'] ?? 'ALL';
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
            $capdo = $donvi->capdo ?? '';

            $model = viewdonvi_dsphongtrao::where('phamviapdung', 'TOANTINH')->orwhere('maphongtraotd', function ($qr) use ($capdo) {
                $qr->select('maphongtraotd')->from('viewdonvi_dsphongtrao')->where('phamviapdung', 'CUNGCAP')->where('capdo', $capdo)->get();
            })->orderby('tungay')->get();
            $model = $model->where('trangthai', 'DD');
            //$ngayhientai = date('Y-m-d');
            $m_hoso = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) {
                $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothiduakhenthuong')->get();
            })->get();
            //dd($model);
            foreach ($model as $DangKy) {
                $DangKy->nhanhoso = 'KETTHUC';
                $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd);
                $DangKy->sohoso = $HoSo == null ? 0 : $HoSo->count();
            }
            //dd($model);

            return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.ThongTin')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_trangthaihoso', getTrangThaiTDKT())
                ->with('a_phamvi', getPhamViPhongTrao())
                ->with('pageTitle', 'Danh sách hồ sơ thi đua');
        } else
            return view('errors.notlogin');
    }
 

    public function KhenThuong(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            dd($inputs);
            //Xóa trạng thái chuyển (mỗi đơn vị chỉ để 1 bản ghi trên bảng trạng thái)
            $m_trangthai = trangthaihoso::where('mahoso', $inputs['mahoso'])
                ->where('madonvi_nhan', $inputs['madonvi'])
                ->where('phanloai', 'dshosothiduakhenthuong')->first();
            $m_trangthai->delete();

            $model = trangthaihoso::where('mahoso', $inputs['mahoso'])
                ->where('madonvi', $m_trangthai->madonvi)
                ->where('phanloai', 'dshosothiduakhenthuong')->first();
            $model->trangthai = 'BTL';
            $model->lydo = $inputs['lydo'];
            $model->thoigian = date('Y-m-d H:i:s');
            $model->save();
            $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();

            return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $m_hoso->maphongtraotd . '&madonvi=' . $inputs['madonvi']);
        } else
            return view('errors.notlogin');
    }

    public function KetQua(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_dangky = dsphongtraothidua::where('maphongtraotd',$inputs['maphongtraotd'])->first();
            $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd',$inputs['maphongtraotd'])->get();
            //dd($m_tieuchuan);
            $m_hoso = dshosothiduakhenthuong::where('maphongtraotd',$inputs['maphongtraotd'])->get();
            
            $model_canhan = dshosothiduakhenthuong_khenthuong::wherein('mahosotdkt',array_column($m_hoso->toarray(),'mahosotdkt'))->where('phanloai','CANHAN')->get();
            $model_tapthe = dshosothiduakhenthuong_khenthuong::wherein('mahosotdkt',array_column($m_hoso->toarray(),'mahosotdkt'))->where('phanloai','TAPTHE')->get();
            $model_tieuchuan = dshosothiduakhenthuong_tieuchuan::wherein('mahosotdkt',array_column($m_hoso->toarray(),'mahosotdkt'))->get();
            foreach ($model_canhan as $canhan){
                $canhan->tongtieuchuan = $m_tieuchuan->where('madanhhieutd',$canhan->madanhhieutd)->count();
                $canhan->tongdieukien = $model_tieuchuan->where('madanhhieutd',$canhan->madanhhieutd)
                    ->where('dieukien','1')->count();
            }
            foreach ($model_tapthe as $tapthe){
                $tapthe->tongtieuchuan = $m_tieuchuan->where('madanhhieutd',$tapthe->madanhhieutd)->count();
                $tapthe->tongdieukien = $model_tieuchuan->where('madanhhieutd',$tapthe->madanhhieutd)
                    ->where('dieukien','1')->count();
            }
            $m_donvi = dsdonvi::all();
            $m_danhhieu = dsphongtraothidua_khenthuong::where('maphongtraotd',$inputs['maphongtraotd'])->get();
            //$a_hinhthuckt = array_column(dmloaihinhkt::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt');
            return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.DanhSach')
                ->with('inputs',$inputs)
                ->with('model_canhan',$model_canhan->sortby('tongdieukien'))
                ->with('model_tapthe',$model_tapthe->sortby('tongdieukien'))
                ->with('m_dangky',$m_dangky)
                ->with('a_donvi', array_column($m_donvi->toArray(),'tendonvi','madonvi'))
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(),'tendanhhieutd','madanhhieutd'))
                ->with('a_hinhthuckt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('pageTitle','Kết quả phong trào thi đua');

        } else
            return view('errors.notlogin');
    }
}
