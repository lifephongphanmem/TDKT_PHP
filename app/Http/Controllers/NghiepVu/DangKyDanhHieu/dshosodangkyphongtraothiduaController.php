<?php

namespace App\Http\Controllers\NghiepVu\DangKyDanhHieu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dsdiaban;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Model\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua_chitiet;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dshosodangkyphongtraothiduaController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::all();
            $inputs['nam'] = $inputs['nam'] ?? 'ALL';
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
            $model = dshosodangkyphongtraothidua::where('madonvi', $inputs['madonvi']);
            if ($inputs['nam'] != 'ALL')
                $model = $model->where('namdangky', $inputs['nam']);
            $model = $model->orderby('ngayhoso')->get();            

            return view('NghiepVu.DangKyDanhHieu.HoSo.ThongTin')
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_capdo', getPhamViApDung())
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_donviql', getDonViQuanLyDiaBan($donvi->madiaban))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách hồ sơ đăng ký');
        } else
            return view('errors.notlogin');
    }

    public function Them(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $inputs['mahosodk'] = (string)getdate()[0];
            $inputs['trangthai'] = 'CC';
            $inputs['namdangky'] = date('Y');
            dshosodangkyphongtraothidua::create($inputs);
            return redirect('/DangKyDanhHieu/HoSo/Sua?mahosodk=' . $inputs['mahosodk']);
        } else
            return view('errors.notlogin');
    }

    public function ThayDoi(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahosodk'])->first();
            $m_khenthuong = dshosodangkyphongtraothidua_chitiet::where('mahosodk', $inputs['mahosodk'])->get();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            return view('NghiepVu.DangKyDanhHieu.HoSo.ThayDoi')
                ->with('model', $model)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
        } else
            return view('errors.notlogin');
    }

    public function XemHoSo(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahosodk'])->first();
            $m_khenthuong = dshosodangkyphongtraothidua_chitiet::where('mahosodk', $inputs['mahosodk'])->get();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            return view('NghiepVu.DangKyDanhHieu.HoSo.Xem')
                ->with('model', $model)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
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
            $inputs = $request->all();
            
            if (isset($inputs['bienban'])) {
                $filedk = $request->file('bienban');
                $inputs['bienban'] =$inputs['mahosodk'].'_bienban.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
            }
            if (isset($inputs['tailieukhac'])) {
                $filedk = $request->file('tailieukhac');
                $inputs['tailieukhac'] =$inputs['mahosodk'].'tailieukhac.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
            }
            dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahosodk'])->first()->update($inputs);

            return redirect('/DangKyDanhHieu/HoSo/ThongTin?madonvi=' . $inputs['madonvi']);
        } else
            return view('errors.notlogin');
    }

    public function ThemCaNhan(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosodangkyphongtraothidua_chitiet::where('madoituong', $inputs['madoituong'])
                ->where('mahosodk', $inputs['mahosodk'])->first();

            if ($model == null) {
                $inputs['madoituong'] = (string)getdate()[0];
                $inputs['phanloai'] = 'CANHAN';
                dshosodangkyphongtraothidua_chitiet::create($inputs);
            } else
                $model->update($inputs);

            //dd($inputs);
            return redirect('/DangKyDanhHieu/HoSo/Sua?mahosodk=' . $inputs['mahosodk']);
        } else
            return view('errors.notlogin');
    }

    public function ThemTapThe(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosodangkyphongtraothidua_chitiet::where('matapthe', $inputs['matapthe'])
                ->where('mahosodk', $inputs['mahosodk'])->first();

            if ($model == null) {
                $inputs['matapthe'] = (string)getdate()[0];
                $inputs['phanloai'] = 'TAPTHE';
                dshosodangkyphongtraothidua_chitiet::create($inputs);
            } else
                $model->update($inputs);

            //dd($inputs);
            return redirect('/DangKyDanhHieu/HoSo/Sua?mahosodk=' . $inputs['mahosodk']);
        } else
            return view('errors.notlogin');
    } 

    public function LayLyDo(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if (!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }

        $inputs = $request->all();
        $model = dshosodangkyphongtraothidua::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        die(json_encode($model));
    }

    public function XoaDoiTuong(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if (!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        //dd($request);
        $inputs = $request->all();
        $model = dshosodangkyphongtraothidua_chitiet::findorfail($inputs['id']);
        $model->delete();
        return redirect('/DangKyDanhHieu/HoSo/Sua?mahosodk=' . $inputs['mahosodk']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
            
            $model->trangthai = 'CD';
            $model->madonvi_nhan = $inputs['madonvi_nhan'];
            $model->thoigian = date('Y-m-d H:i:s');
            setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CD']);
            //dd($model);
            $model->save();

            $trangthai = new trangthaihoso();
            $trangthai->trangthai = 'CD';
            $trangthai->madonvi = $model->madonvi;
            $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
            $trangthai->phanloai = 'dshosodangkyphongtraothidua';
            $trangthai->mahoso = $model->mahosotdkt;
            $trangthai->thoigian = $model->thoigian;
            $trangthai->save();

            return redirect('/DangKyDanhHieu/HoSo/ThongTin?madonvi=' . $model->madonvi);
        } else
            return view('errors.notlogin');
    }

    public function LayDoiTuong(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if (!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        //dd($request);
        $inputs = $request->all();
        $model = dshosodangkyphongtraothidua_chitiet::findorfail($inputs['id']);
        die(json_encode($model));
    }
}
