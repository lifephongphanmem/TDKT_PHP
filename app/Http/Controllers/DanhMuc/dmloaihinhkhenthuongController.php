<?php

namespace App\Http\Controllers\DanhMuc;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use Illuminate\Support\Facades\Session;

class dmloaihinhkhenthuongController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $model = dmloaihinhkhenthuong::all();
            $inputs = $request->all();
            //dd($model);
            return view('DanhMuc.LoaiHinhKhenThuong.ThongTin')
                ->with('model', $model)
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh mục loại hình khen thưởng');
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
            $model = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->first();
            if ($model == null) {
                $inputs['maloaihinhkt'] = getdate()[0];
                dmloaihinhkhenthuong::create($inputs);
            } else {
                $model->update($inputs);
            }

            return redirect('/LoaiHinhKhenThuong/ThongTin');
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
            dmloaihinhkhenthuong::findorfail($inputs['id'])->delete();
            return redirect('/LoaiHinhKhenThuong/ThongTin');
        } else
            return view('errors.notlogin');
    }    
}
