<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_khenthuong;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tieuchuan;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dshosokhenthuongcumkhoiController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dscumkhoi::all();
            
            //dd($model);
            $m_donvi = getDonVi(session('admin')->capdo);
            return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThongTin')
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_capdo', getPhamViApDung())
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách phong trào thi đua');
        } else
            return view('errors.notlogin');
    }

    public function DanhSach(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $m_cumkhoi = dscumkhoi::all();
            $m_donvi = getDonViCumKhoi($inputs['macumkhoi'],'MODEL');
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(),'madiaban'))->get();            
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $inputs['nam'] = $inputs['nam'] ?? date('Y');
            //nếu đơn vị trưởng cụm thì thấy tất cả hồ sơ
            //nếu đơn vị thành viên chỉ thấy hồ sơ của đơn vị mình
            $model = dshosotdktcumkhoi::where('macumkhoi',$inputs['macumkhoi'])->where('madonvi',$inputs['madonvi'])->get();
            return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.DanhSach')
                ->with('model', $model)
                ->with('m_cumkhoi', $m_cumkhoi)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_diaban', $m_diaban)
                ->with('a_donviql', getDonViQuanLyCumKhoi($inputs['macumkhoi']))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách phong trào thi đua');
        } else
            return view('errors.notlogin');
    }

    public function ThayDoi(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            $m_danhhieu = dmdanhhieuthidua::all();

            $inputs = $request->all();
            $inputs['mahosotdkt'] = $inputs['mahosotdkt'] ?? null;
            $inputs['trangthai'] = $inputs['trangthai'] ?? true;
            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();

            if ($model == null) {
                $model = new dshosotdktcumkhoi();
                $model->madonvi = $inputs['madonvi'];
                $model->tendonvi =$m_donvi->where('madonvi',$inputs['madonvi'])->first()->tendonvi;
                $model->mahosotdkt = (string)getdate()[0];
                $model->macumkhoi = $inputs['macumkhoi'];
                $model->ngayhoso = date('Y-m-d');
            }
            $model_khenthuong = dshosotdktcumkhoi_khenthuong::where('mahosotdkt', $model->mahosotdkt)->get();
            $model_tieuchuan = dshosotdktcumkhoi_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->get();
            //dd( $model);
            
            return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThayDoi')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $model_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('pageTitle', 'Hồ sơ thi đua');
        } else
            return view('errors.notlogin');
    }

    public function LuuHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            //dd($request->all());
            $inputs = $request->all();

            if (isset($inputs['baocao'])) {
                $filedk = $request->file('baocao');
                $inputs['baocao'] = $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
            }
            if (isset($inputs['bienban'])) {
                $filedk = $request->file('bienban');
                $inputs['bienban'] = $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
            }
            if (isset($inputs['tailieukhac'])) {
                $filedk = $request->file('tailieukhac');
                $inputs['tailieukhac'] = $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
            }

            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if ($model == null) {
                $inputs['trangthai'] = 'CC';
                dshosotdktcumkhoi::create($inputs);
                $trangthai = new trangthaihoso();
                $trangthai->trangthai = $inputs['trangthai'];
                $trangthai->madonvi = $inputs['madonvi'];
                $trangthai->phanloai = 'dshosotdktcumkhoi';
                $trangthai->mahoso = $inputs['mahosotdkt'];
                $trangthai->thoigian = date('Y-m-d H:i:s');
                $trangthai->save();
            } else {
                $model->update($inputs);
            }

            return redirect('CumKhoiThiDua/HoSoKhenThuong/DanhSach?madonvi='.$inputs['madonvi'].'&macumkhoi=' . $inputs['macumkhoi']);
        } else
            return view('errors.notlogin');
    }

    public function Sua(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();            
            $request->merge(['madonvi' => $model->madonvi,'macumkhoi'=>$model->macumkhoi]);
            //dd($request->all());
            return $this->ThayDoi($request);
        } else
            return view('errors.notlogin');
    }
    
}
