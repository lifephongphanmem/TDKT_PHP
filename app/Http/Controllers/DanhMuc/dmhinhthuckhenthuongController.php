<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use Illuminate\Support\Facades\Session;

class dmhinhthuckhenthuongController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $model = dmhinhthuckhenthuong::all();
            $inputs = $request->all();
            //dd($model);
            return view('DanhMuc.HinhThucKhenThuong.ThongTin')
                ->with('model', $model)
                ->with('inputs', $inputs)
                ->with('a_phanloai', getPhanLoaiHinhThucKT())
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
            $model = dmhinhthuckhenthuong::where('mahinhthuckt', $inputs['mahinhthuckt'])->first();
            if ($model == null) {
                $inputs['mahinhthuckt'] = getdate()[0];
                dmhinhthuckhenthuong::create($inputs);
            } else {
                $model->update($inputs);
            }

            return redirect('/HinhThucKhenThuong/ThongTin');
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
            dmhinhthuckhenthuong::findorfail($inputs['id'])->delete();
            return redirect('/HinhThucKhenThuong/ThongTin');
        } else
            return view('errors.notlogin');
    }    
}
