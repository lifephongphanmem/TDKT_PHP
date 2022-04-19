<?php

namespace App\Http\Controllers\DanhMuc;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use Illuminate\Support\Facades\Session;

class dmdanhhieuthiduaController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $model = dmdanhhieuthidua::all();
            $inputs = $request->all();
            //dd($model);
            return view('DanhMuc.DanhHieuThiDua.ThongTin')
                ->with('model', $model)
                ->with('inputs', $inputs)
                ->with('a_phanloai', getPhanLoaiTDKT())
                //->with('a_diaban', getDiaBan_All(true))
                ->with('pageTitle', 'Danh mục danh hiệu thi đua');
        } else
            return view('errors.notlogin');
    }

    public function store(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
            if ($model == null) {
                $inputs['madanhhieutd'] = getdate()[0];
                dmdanhhieuthidua::create($inputs);
            } else {
                $model->update($inputs);
            }

            return redirect('/DanhHieuThiDua/ThongTin');
        } else
            return view('errors.notlogin');
    }

    public function delete(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            dmdanhhieuthidua::findorfail($inputs['id'])->delete();
            return redirect('/DanhHieuThiDua/ThongTin');
        } else
            return view('errors.notlogin');
    }

    public function TieuChuan(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            return view('DanhMuc.DanhHieuThiDua.TieuChuan')
                ->with('model', $model)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('m_danhhieu', $m_danhhieu->where('madanhhieutd', $inputs['madanhhieutd'])->first())
                ->with('pageTitle', 'Danh sách danh mục tiêu chuẩn danh hiệu thi đua');
        } else
            return view('errors.notlogin');
    }

    public function ThemTieuChuan(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dmdanhhieuthidua_tieuchuan::where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();
            if ($model == null) {
                $inputs['matieuchuandhtd'] = getdate()[0];
                dmdanhhieuthidua_tieuchuan::create($inputs);
            } else {
                $model->update($inputs);
            }

            return redirect('/DanhHieuThiDua/TieuChuan?madanhhieutd=' . $inputs['madanhhieutd']);
        } else
            return view('errors.notlogin');
    }

    public function delete_TieuChuan(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dmdanhhieuthidua_tieuchuan::findorfail($inputs['id']);
            $model->delete();
            return redirect('/DanhHieuThiDua/TieuChuan?madanhhieutd=' . $model->madanhhieutd);
        } else
            return view('errors.notlogin');
    }
}
