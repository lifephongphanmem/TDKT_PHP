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

            $ngayhientai = date('Y-m-d');
            $m_hoso = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) {
                $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothiduakhenthuong')->get();
            })->get();
            $m_trangthai_phongtrao = trangthaihoso::where('phanloai', 'dsphongtraothidua')->orderby('thoigian', 'desc')->get();
            //dd($ngayhientai);
            foreach ($model as $DangKy) {
                $DangKy->trangthai = $m_trangthai_phongtrao->where('mahoso', $DangKy->maphongtraotd)->first()->trangthai ?? 'CC';
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
}
