<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\Session;

class xetduyethosothiduaController extends Controller
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

            $ngayhientai = date('Y-m-d');
            $m_hoso = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) {
                $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothiduakhenthuong')->get();
            })->get();
            //$m_trangthai_phongtrao = trangthaihoso::where('phanloai', 'dsphongtraothidua')->orderby('thoigian', 'desc')->get();
            //dd($ngayhientai);
            foreach ($model as $DangKy) {
                if ($DangKy->trangthai == 'CC') {
                    $DangKy->nhanhoso = 'CHUABATDAU';
                    if ($DangKy->tungay < $ngayhientai && $DangKy->denngay > $ngayhientai) {
                        $DangKy->nhanhoso = 'DANGNHAN';
                    }
                    if (strtotime($DangKy->denngay) < strtotime($ngayhientai)) {
                        $DangKy->nhanhoso = 'KETTHUC';
                    }
                } else {
                    $DangKy->nhanhoso = 'KETTHUC';
                }

                $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd);
                $DangKy->sohoso = $HoSo == null ? 0 : $HoSo->count();
            }
            //dd($model);

            return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.ThongTin')
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

    public function DanhSach(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_dangky = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
            // $model = dshosothiduakhenthuong::where('maphongtraotd',$inputs['maphongtraotd'])
            // ->wherein('mahosotdkt',function($qr){
            //     $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai',['CD','DD'])->where('phanloai','dshosothiduakhenthuong')->get();
            // })->get();
            //$m_trangthai = trangthaihoso::wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothiduakhenthuong')->orderby('thoigian', 'desc')->get();
            $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
                ->wherein('mahosotdkt', function ($qr) use ($inputs) {
                    $qr->select('mahosotdkt')->from('dshosothiduakhenthuong')
                        ->where('madonvi_nhan', $inputs['madonvi'])
                        ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                        ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
                })->get();
            foreach ($model as $chitiet) {
                $chitiet->chuyentiephoso = false;
                if ($m_dangky->phamviapdung == 'TOANTINH' && $donvi->capdo == 'H')
                    $chitiet->chuyentiephoso = true;

                getDonViChuyen($inputs['madonvi'], $chitiet);
                //$chitiet->trangthai = $donvi->capdo == 'H' ? $chitiet->trangthai_h : $chitiet->trangthai_t;
            }
            //dd($model);
            $m_donvi = getDonVi(session('admin')->capdo);

            return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.DanhSach')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_dangky', $m_dangky)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_donviql', getDonViQuanLyTinh()) //chưa lọc hết (chỉ chuyển lên cấp Tỉnh)
                ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
        } else
            return view('errors.notlogin');
    }

    public function XemDanhSach(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_dangky = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
            // $model = dshosothiduakhenthuong::where('maphongtraotd',$inputs['maphongtraotd'])
            // ->wherein('mahosotdkt',function($qr){
            //     $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai',['CD','DD'])->where('phanloai','dshosothiduakhenthuong')->get();
            // })->get();
            //$m_trangthai = trangthaihoso::wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothiduakhenthuong')->orderby('thoigian', 'desc')->get();
            $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
                ->wherein('mahosotdkt', function ($qr) use ($inputs) {
                    $qr->select('mahosotdkt')->from('dshosothiduakhenthuong')
                        ->where('madonvi_nhan', $inputs['madonvi'])
                        ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                        ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
                })->get();
            foreach ($model as $chitiet) {
                $chitiet->chuyentiephoso = false;
                if ($m_dangky->phamviapdung == 'TOANTINH' && $donvi->capdo == 'H')
                    $chitiet->chuyentiephoso = true;
                getDonViChuyen($inputs['madonvi'], $chitiet);
                //$chitiet->trangthai = $donvi->capdo == 'H' ? $chitiet->trangthai_h : $chitiet->trangthai_t;
            }
            //dd($model);
            $m_donvi = getDonVi(session('admin')->capdo);

            return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.Xem')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_dangky', $m_dangky)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_donviql', getDonViQuanLyTinh()) //chưa lọc hết (chỉ chuyển lên cấp Tỉnh)
                ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
        } else
            return view('errors.notlogin');
    }

    public function TraLai(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
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
    //Chưa hoàn thiện
    public function ChuyenHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            //dd($inputs);
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
            $model->trangthai = 'DD';
            $model->trangthai_h = 'DD';
            $model->madonvi_nhan_h = $inputs['madonvi_nhan'];
            $model->thoigian_h = date('Y-m-d H:i:s');

            setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CNXKT']);
            //dd($model);
            $model->save();

            return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $model->madonvi_h);
        } else
            return view('errors.notlogin');
    }

    //Chưa hoàn thiện
    public function NhanHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $thoigian = date('Y-m-d H:i:s');
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
            $model->trangthai = 'CXKT';
            setNhanHoSo($inputs['madonvi_nhan'], $model, ['trangthai' => 'CXKT']);
            setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
            $model->save();

            return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $inputs['madonvi_nhan']);
        } else
            return view('errors.notlogin');
    }


    public function KetThuc(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            //dd($inputs);
            $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            $model->trangthai = 'CXKT';
            $model->thoigian = date('Y-m-d H:i:s');
            $model->save();

            return redirect('/KhenThuongHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
        } else
            return view('errors.notlogin');
    }
}
