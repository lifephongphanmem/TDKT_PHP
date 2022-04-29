<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong_chitiet;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong_khenthuong;
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

            //$model = $model->where('trangthai', 'DD');
            $ngayhientai = date('Y-m-d');
            $m_hoso = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) {
                $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothiduakhenthuong')->get();
            })->get();
            //dd($model);
            $m_khenthuong = dshosokhenthuong::where('madonvi', $inputs['madonvi'])->get();
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
                $khenthuong = $m_khenthuong->where('maphongtraotd', $DangKy->maphongtraotd)->where('madonvi', $inputs['madonvi'])->first();
                $DangKy->mahosokt = $khenthuong->mahosokt ?? '-1';
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
            $chk = dshosokhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
                ->where('madonvi', $inputs['madonvi'])->first();
            $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            if ($chk == null) {
                //chưa hoàn thiện
                $m_hosokt = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
                    ->wherein('mahosotdkt', function ($qr) {
                        $qr->select('mahosotdkt')->from('dshosothiduakhenthuong')
                            ->where('trangthai_t', 'CXKT')
                            ->orwhere('trangthai_h', 'CXKT')->get();
                    })->get();
                $inputs['mahosokt'] = (string)getdate()[0];
                $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;
                dshosokhenthuong::create($inputs);
                $m_phongtrao->trangthai = 'DXKT';
                $m_phongtrao->save();
                foreach ($m_hosokt as $hoso) {
                    $khenthuong = new dshosokhenthuong_chitiet();
                    $khenthuong->mahosokt = $inputs['mahosokt'];
                    $khenthuong->mahosotdkt = $hoso->mahosotdkt;
                    $khenthuong->ketqua = 0;
                    $khenthuong->madonvi = $inputs['madonvi'];
                    $khenthuong->save();
                    //Lưu trạng thái
                    $hoso->mahosokt = $inputs['mahosokt'];
                    $thoigian = date('Y-m-d H:i:s');
                    setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => 'DXKT']);
                    setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => 'DXKT']);
                    $hoso->save();
                }
            } else {
                $inputs['mahosokt'] = $chk->mahosokt;
            }
            $model =  dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            $m_chitiet = dshosokhenthuong_chitiet::where('mahosokt', $inputs['mahosokt'])->get();
            $m_hosokt = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])->get();
            foreach ($m_chitiet as $chitiet) {
                $chitiet->madonvi_kt = $m_hosokt->where('mahosotdkt', $chitiet->mahosotdkt)->first()->madonvi ?? null;
            }
            $m_khenthuong = dshosokhenthuong_khenthuong::where('mahosokt', $inputs['mahosokt'])->get();
            return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.DanhSach')
                ->with('model', $model)
                ->with('m_chitiet', $m_chitiet)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('m_phongtrao', $m_phongtrao)
                ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
                //->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                //->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_hinhthuckt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Kết quả phong trào thi đua');
        } else
            return view('errors.notlogin');
    }

    public function LuuHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            if (isset($inputs['totrinh'])) {
                $filedk = $request->file('totrinh');
                $inputs['totrinh'] = $inputs['maphongtraotd'] . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
            }
            if (isset($inputs['qdkt'])) {
                $filedk = $request->file('qdkt');
                $inputs['qdkt'] = $inputs['maphongtraotd'] . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/qdkt/', $inputs['qdkt']);
            }
            if (isset($inputs['bienban'])) {
                $filedk = $request->file('bienban');
                $inputs['bienban'] = $inputs['maphongtraotd'] . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
            }
            if (isset($inputs['tailieukhac'])) {
                $filedk = $request->file('tailieukhac');
                $inputs['tailieukhac'] = $inputs['maphongtraotd'] . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
            }            
            $model->update($inputs);
            return redirect('/KhenThuongHoSoThiDua/ThongTin?madonvi='.$model->madonvi);            
        } else
            return view('errors.notlogin');
    }

    public function DanhSach(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model =  dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();

            $m_chitiet = dshosokhenthuong_chitiet::where('mahosokt', $model->mahosokt)->get();
            $m_hosokt = dshosothiduakhenthuong::where('maphongtraotd', $model->maphongtraotd)->get();
            foreach ($m_chitiet as $chitiet) {
                $chitiet->madonvi_kt = $m_hosokt->where('mahosotdkt', $chitiet->mahosotdkt)->first()->madonvi ?? null;
            }

            //dd($m_chitiet);
            $m_khenthuong = dshosokhenthuong_khenthuong::where('mahosokt', $model->mahosokt)->get();
            foreach ($m_khenthuong as $chitiet) {
                $chitiet->madonvi_kt = $m_hosokt->where('mahosotdkt', $chitiet->mahosotdkt)->first()->madonvi ?? null;
            }
            return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.DanhSach')
                ->with('model', $model)
                ->with('m_chitiet', $m_chitiet)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('m_phongtrao', $m_phongtrao)
                ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Kết quả phong trào thi đua');
        } else
            return view('errors.notlogin');
    }



    public function HoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_chitiet = dshosokhenthuong_chitiet::where('mahosokt', $inputs['mahosokt'])->where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if ($inputs['khenthuong'] == 0) {
                dshosokhenthuong_khenthuong::where('mahosokt', $inputs['mahosokt'])->where('mahosotdkt', $inputs['mahosotdkt'])->delete();
            }
            if ($inputs['khenthuong'] == 1 && $m_chitiet->ketqua == 0) {
                $m_hosotdkt = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->get();
                $a_khenthuong = [];
                foreach ($m_hosotdkt as $khenthuong) {
                    $a_khenthuong[] = [
                        'mahosokt' => $inputs['mahosokt'],
                        'mahosotdkt' => $inputs['mahosotdkt'],
                        'madanhhieutd' => $khenthuong->madanhhieutd,
                        'noidungkhenthuong' => '',
                        'phanloai' => $khenthuong->phanloai,
                        //Thông tin cá nhân 
                        'madoituong' => $khenthuong->madoituong,
                        'maccvc' => $khenthuong->maccvc,
                        'tendoituong' => $khenthuong->tendoituong,
                        'ngaysinh' => $khenthuong->ngaysinh,
                        'gioitinh' => $khenthuong->gioitinh,
                        'chucvu' => $khenthuong->chucvu,
                        'lanhdao' => $khenthuong->lanhdao,
                        //Thông tin tập thể
                        'matapthe' => $khenthuong->matapthe,
                        'tentapthe' => $khenthuong->tentapthe,
                        //Kết quả đánh giá
                        'ketqua' => '1',
                        'mahinhthuckt' => $khenthuong->mahinhthuckt,
                    ];
                }
                //dd($a_khenthuong);
                dshosokhenthuong_khenthuong::insert($a_khenthuong);
            }
            $m_chitiet->ketqua = $inputs['khenthuong'];
            $m_chitiet->save();
            //dd($inputs);
            return redirect('KhenThuongHoSoThiDua/DanhSach?mahosokt=' . $inputs['mahosokt']);
        } else
            return view('errors.notlogin');
    }

    public function KetQua(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $inputs = $request->all();
            $model = dshosokhenthuong_khenthuong::findorfail($inputs['id']);
            $model->ketqua = isset($inputs['dieukien']) ? 1 : 0;
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
            $model->save();
            //dd($inputs);
            return redirect('/KhenThuongHoSoThiDua/DanhSach?mahosokt=' . $inputs['mahosokt']);
        } else
            return view('errors.notlogin');
    }

    public function InKetQua(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhenthuong_khenthuong::findorfail($inputs['id']);
            $model->tendanhhieutd = dmdanhhieuthidua::where('madanhhieutd', $model->madanhhieutd)->first()->tendanhhieutd ?? '';
            $model->tenphongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->tenphongtrao ?? '';
            //dd($model);
            return view('BaoCao.DonVi.InBangKhen')
                ->with('model', $model)
                ->with('pageTitle', 'Danh sách hồ sơ thi đua');
        } else
            return view('errors.notlogin');
    }
}
