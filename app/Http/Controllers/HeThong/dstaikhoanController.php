<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dstaikhoan;
use Illuminate\Support\Facades\Session;

class dstaikhoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            //dd($m_donvi);
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $model = dstaikhoan::where('madonvi', $inputs['madonvi'])->get();
            return view('HeThongChung.TaiKhoan.ThongTin')
                ->with('model', $model)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_nhomtk', [])
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách tài khoản');
        } else
            return view('errors.notlogin');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_donvi = dsdonvi::all();
            $model = new dstaikhoan();
            $model->madonvi = $inputs['madonvi'];
            return view('HeThongChung.TaiKhoan.Sua')
                //->with('inputs', $inputs)
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('pageTitle', 'Tạo mới thông tin tài khoản');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $inputs['nhaplieu'] = isset($inputs['nhaplieu']) ? 1 : 0;
            $inputs['tonghop'] = isset($inputs['tonghop']) ? 1 : 0;
            $inputs['quantri'] = isset($inputs['quantri']) ? 1 : 0;
            $inputs['tendangnhap'] = chuanhoachuoi($inputs['tendangnhap']);

            $model = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
            if ($model == null) {
                $inputs['matkhau'] = md5($inputs['matkhau']);
                dstaikhoan::create($inputs);
            } else {
                if ($inputs['matkhau'] == '')
                    unset($inputs['matkhau']);
                $model->update($inputs);
            }

            return redirect('/TaiKhoan/ThongTin?madonvi=' . $inputs['madonvi']);
        } else {
            return view('errors.notlogin');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = DSDonVi::where('madonvi', $inputs['madonvi'])->first();
            return view('HeThongChung.TaiKhoan.Sua')
                ->with('model', $model)
                ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
        } else
            return view('errors.notlogin');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Session::has('admin')) {
            $id = $request->all()['id'];
            $model = dsdonvi::findorFail($id);
            //dd($model);
            $model->delete();
            return redirect('/DonVi/DanhSach?madiaban=' . $model->madiaban);
        } else
            return view('errors.notlogin');
    }
}
