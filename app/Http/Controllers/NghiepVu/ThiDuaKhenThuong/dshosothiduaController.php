<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\Session;

class dshosothiduaController extends Controller
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
            //dd($donvi);
            $capdo = $donvi->capdo ?? '';

            //dd($capdo);
            //Chưa xét trường hợp Huyện phát động            
            if($capdo != 'X'){
                $model = viewdonvi_dsphongtrao::where('phamviapdung', 'TOANTINH')->orwhere('maphongtraotd', function ($qr) use ($capdo) {
                    $qr->select('maphongtraotd')->from('viewdonvi_dsphongtrao')->where('phamviapdung', 'CUNGCAP')->where('capdo', $capdo)->get();
                })->orderby('tungay')->get();
            }else{
                $model = viewdonvi_dsphongtrao::where('phamviapdung', 'TOANTINH')->orwhere('madonvi', $inputs['madonvi'])->orderby('tungay')->get();
            }
            $ngayhientai = date('Y-m-d');
            $m_hoso = dshosothiduakhenthuong::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->get();
            $m_hoso_khenthuong = dshosokhenthuong::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->where('trangthai','DKT')->get();
            //dd($m_hoso);
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

                $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd)->wherein('trangthai', ['CD', 'DD', 'CNXKT', 'DXKT', 'CXKT', 'DKT']);
                $DangKy->sohoso = $HoSo == null ? 0 : $HoSo->count();
                $DangKy->mahosokt = $m_hoso_khenthuong->where('maphongtraotd', $DangKy->maphongtraotd)->where('madonvi', $inputs['madonvi'])->first()->mahosokt ?? null;

                $HoSodv = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd)->where('madonvi', $inputs['madonvi'])->first();
                $DangKy->trangthai = $HoSodv->trangthai ?? 'CXD';
                $DangKy->thoigian = $HoSodv->thoigian ?? '';
                $DangKy->hosodonvi = $HoSodv == null ? 0 : 1;
                $DangKy->id = $HoSodv == null ? -1 : $HoSodv->id;
                $DangKy->mahosotdkt = $HoSodv == null ? -1 : $HoSodv->mahosotdkt;
            }
            //dd($model);

            return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThongTin')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_donviql', getDonViQuanLyDiaBan($donvi->madiaban))
                ->with('a_phamvi', getPhamViPhongTrao())
                ->with('a_trangthaihoso', getTrangThaiTDKT())
                ->with('pageTitle', 'Danh sách hồ sơ thi đua');
        } else
            return view('errors.notlogin');
    }

    public function ThemHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }

            $inputs = $request->all();
            $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            $model = new dshosothiduakhenthuong();
            $model->madonvi = $inputs['madonvi'];
            $model->tendonvi = getThongTinDonVi($inputs['madonvi'], 'tendonvi');
            $model->mahosotdkt = (string)getdate()[0];
            $model->maloaihinhkt = $m_phongtrao->maloaihinhkt;
            $model->tenphongtrao = $m_phongtrao->noidung;
            $model->maphongtraotd = $inputs['maphongtraotd'];

            $model_khenthuong = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $model->mahosotdkt)->get();
            $model_tieuchuan = dshosothiduakhenthuong_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->get();

            $m_danhhieu = dsphongtraothidua_khenthuong::where('maphongtraotd', $inputs['maphongtraotd'])->get();
            $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->get();
            //dd( $model);
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThayDoi')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $model_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_tieuchuan', $m_tieuchuan)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('pageTitle', 'Hồ sơ thi đua');
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

            $inputs = $request->all();
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();           
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $model->tenphongtrao = $m_phongtrao->noidung;

            $model_khenthuong = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $model->mahosotdkt)->get();
            $model_tieuchuan = dshosothiduakhenthuong_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->get();

            $m_danhhieu = dsphongtraothidua_khenthuong::where('maphongtraotd', $model->maphongtraotd)->get();
            $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
            //dd( $model);
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThayDoi')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $model_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_tieuchuan', $m_tieuchuan)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('pageTitle', 'Hồ sơ thi đua');
        } else
            return view('errors.notlogin');
    }

    public function XemHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }

            $inputs = $request->all();
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();           
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $model->tenphongtrao = $m_phongtrao->noidung;

            $model_khenthuong = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $model->mahosotdkt)->get();
            $model_tieuchuan = dshosothiduakhenthuong_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->get();

            $m_danhhieu = dsphongtraothidua_khenthuong::where('maphongtraotd', $model->maphongtraotd)->get();
            $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
            //dd( $model);
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.Xem')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $model_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_tieuchuan', $m_tieuchuan)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
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
                $inputs['baocao'] = $inputs['mahosotdkt'].'_baocao.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
            }
            if (isset($inputs['bienban'])) {
                $filedk = $request->file('bienban');
                $inputs['bienban'] =$inputs['mahosotdkt'].'_bienban.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
            }
            if (isset($inputs['tailieukhac'])) {
                $filedk = $request->file('tailieukhac');
                $inputs['tailieukhac'] =$inputs['mahosotdkt'].'tailieukhac.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
            }

            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if ($model == null) {
                $inputs['trangthai'] = 'CC';
                $inputs['phanloai'] = 'THIDUA';
                dshosothiduakhenthuong::create($inputs);
                $trangthai = new trangthaihoso();
                $trangthai->trangthai = $inputs['trangthai'];
                $trangthai->madonvi = $inputs['madonvi'];
                $trangthai->phanloai = 'dshosothiduakhenthuong';
                $trangthai->mahoso = $inputs['mahosotdkt'];
                $trangthai->thoigian = date('Y-m-d H:i:s');
                $trangthai->save();
            } else {
                $model->update($inputs);
            }

            return redirect('/HoSoThiDua/ThongTin?madonvi=' . $inputs['madonvi']);
        } else
            return view('errors.notlogin');
    }


    public function delete(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosothiduakhenthuong::findorfail($inputs['id']);
            dshosothiduakhenthuong_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->delete();
            dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $model->mahosotdkt)->delete();
            $model->delete();
            return redirect('HoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
        } else
            return view('errors.notlogin');
    }

    public function ChuyenHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
            //dd($model);
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
            $trangthai->phanloai = 'dshosothiduakhenthuong';
            $trangthai->mahoso = $model->mahosotdkt;
            $trangthai->thoigian = $model->thoigian;
            $trangthai->save();

            return redirect('HoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
        } else
            return view('errors.notlogin');
    }

    public function ThemDoiTuong(Request $request)
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
        //$m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $m_phongtrao = dsphongtraothidua_khenthuong::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->first();

        $model = dshosothiduakhenthuong_khenthuong::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->first();
            
        if ($model == null) {
            $model = new dshosothiduakhenthuong_khenthuong();
            $inputs['madoituong'] = getdate()[0];
            $inputs['phanloai'] = 'CANHAN';
            $inputs['mahinhthuckt'] = $m_phongtrao->mahinhthuckt ?? '';
            dshosothiduakhenthuong_khenthuong::create($inputs);
        } else {
            $model->update($inputs);
        }

        if (isset($inputs['filedk'])) {
            $filedk = $request->file('filedk');
            $inputs['filedk'] = $inputs['madoituong'].'_'. $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/detaisangkien/', $inputs['filedk']);
        }

        $modelct = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])
            ->where('phanloai', 'CANHAN')->get();

        $result = $this->returnHTMLCaNhan($modelct);

        die(json_encode($result));
    }

    function returnHTMLCaNhan($modelct)
    {
        $result = [];
        if (isset($modelct)) {
            $result['message'] = '<div class="row" id="dskhenthuong">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên đối tượng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Ngày sinh</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Giới tính</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Chức vụ</th>';
            $result['message'] .= '<th style="text-align: center" width="20%">Tên danh hiệu<br>đăng ký</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tendoituong . '</td>';
                $result['message'] .= '<td>' . getDayVn($ct->ngaysinh) . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->gioitinh . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->chucvu . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->madanhhieutd . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->madoituong . ',' . $ct->madanhhieutd . ',' . $ct->tendoituong . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-primary"></i></button>' .
                    '<button title="Sửa" type="button" data-target="#modal-create" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getCaNhan(' . $ct->id . ')"><i class="icon-lg la la fa-edit text-primary"></i></button>' .
                    '<button title="Xóa" type="button" data-target="#modal-delete-khenthuong" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="delKhenThuong(' . $ct->id . ',CANHAN)" ><i class="icon-lg la la fa-trash text-danger"></i></button>' .
                    '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        return $result;
    }

    public function ThemDoiTuongTapThe(Request $request)
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
        $m_donvi = DSDonVi::where('madonvi', $inputs['matapthe'])->first();
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $m_phongtrao = dsphongtraothidua_khenthuong::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model = dshosothiduakhenthuong_khenthuong::where('matapthe', $inputs['matapthe'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if ($model == null) {
            $model = new dshosothiduakhenthuong_khenthuong();
            $model->matapthe = $inputs['matapthe'];
            $model->mahosotdkt = $inputs['mahosotdkt'];
            $model->mahinhthuckt = $m_phongtrao->mahinhthuckt ?? '';
            $model->tentapthe = $m_donvi->tendonvi ?? '';
            $model->phanloai = 'TAPTHE';
            $model->madonvi = $inputs['madonvi'];
            $model->madanhhieutd = $inputs['madanhhieutd'];
            $model->save();
        } else {
            $model->madanhhieutd = $inputs['madanhhieutd'];
            $model->matapthe = $inputs['matapthe'];
            $model->tentapthe = $m_donvi->tendonvi ?? '';
            $model->save();
        }

        $modelct = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])
            ->where('phanloai', 'TAPTHE')
            ->get();

        $result = $this->returnHTMLTapThe($modelct);
        die(json_encode($result));
    }

    public function returnHTMLTapThe($modelct)
    {
        $result = [];
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="5%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên đơn vi</th>';
            $result['message'] .= '<th style="text-align: center" width="30%">Tên danh hiệu<br>đăng ký</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentapthe . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->madanhhieutd . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->matapthe . ',' . $ct->madanhhieutd . ',' . $ct->tentapthe . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-primary"></i></button>' .
                    '<button type="button" data-target="#modal-create-tapthe" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getTapThe(' . $ct->id . ')"><i class="icon-lg la fa-edit text-primary"></i></button>' .
                    '<button type="button" data-target="#modal-delete-khenthuong" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="delKhenThuong(' . $ct->id . ',TAPTHE)" ><i class="icon-lg la fa-trash text-danger"></i></button>' .
                    '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        return $result;
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
        $model = dshosothiduakhenthuong_khenthuong::findorfail($inputs['id']);        
        die(json_encode($model));
    }

    public function LayTieuChuan(Request $request)
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
        //$m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->get();

        if (isset($model_tieuchuan)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Đạt điều kiên</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($model_tieuchuan as $ct) {
                $ct->dieukien = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first()->dieukien ?? 0;
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->dieukien . '</td>';
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
                    . '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        die(json_encode($result));
    }

    public function LuuTieuChuan(Request $request)
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
        //$m_danhhieu = dmdanhhieutd::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('matieuchuandhtd', $inputs['matieuchuandhtd'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->first();

        //chưa lấy biến điều kiện đang dùng tạm để demo
        if ($model == null) {
            $model = new dshosothiduakhenthuong_tieuchuan();
            $model->madoituong = $inputs['madoituong'];
            $model->matieuchuandhtd = $inputs['matieuchuandhtd'];
            $model->madanhhieutd = $inputs['madanhhieutd'];
            //$model->madonvi = $inputs['madonvi'];
            $model->mahosotdkt = $inputs['mahosotdkt'];
            $model->dieukien = 1;
            $model->save();
        } else {
            $model->dieukien = 1;
            $model->save();
        }
        //
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->get();

        if (isset($model_tieuchuan)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Đạt điều kiên</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($model_tieuchuan as $ct) {
                $ct->dieukien = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first()->dieukien ?? 0;
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->dieukien . '</td>';
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
                    . '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        die(json_encode($result));
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
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        //dd($inputs);

        $result['message'] = '<div class="col-md-12" id="showlido">';
        $result['message'] .= $model->lido;

        $result['message'] .= '</div>';
        $result['status'] = 'success';


        die(json_encode($result));
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
        $model = dshosothiduakhenthuong_khenthuong::findorfail($inputs['id']);

        $model->delete();

        $modelct = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])
            ->where('phanloai', $inputs['phanloai'])
            ->get();
        if ($inputs['phanloai'] == 'CANHAN') {
            dshosothiduakhenthuong_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
                ->where('mahosotdkt', $inputs['mahosotdkt'])
                ->where('madoituong', $model->madoituong)->delete();
            $result = $this->returnHTMLCaNhan($modelct);
        } else {
            dshosothiduakhenthuong_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
                ->where('mahosotdkt', $inputs['mahosotdkt'])
                ->where('matapthe', $model->matapthe)->delete();
            $result = $this->returnHTMLTapThe($modelct);
        }


        die(json_encode($result));
    }
}
