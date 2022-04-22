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
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
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
            $capdo = $donvi->capdo ?? '';
            $model = viewdonvi_dsphongtrao::where('phamviapdung', 'TOANTINH')->orwhere('maphongtraotd', function ($qr) use ($capdo) {
                $qr->select('maphongtraotd')->from('viewdonvi_dsphongtrao')->where('phamviapdung', 'CUNGCAP')->where('capdo', $capdo)->get();
            })->orderby('tungay')->get();

            $ngayhientai = date('Y-m-d');
            $m_hoso = dshosothiduakhenthuong::all();
            $m_trangthai_hoso = trangthaihoso::where('phanloai', 'dshosothiduakhenthuong')->get();
            $m_trangthai_phongtrao = trangthaihoso::where('phanloai','dsphongtraothidua')->get();
            //dd($ngayhientai);
            foreach ($model as $DangKy) {
                $DangKy->trangthai = $m_trangthai_phongtrao->where('mahoso',$DangKy->maphongtraotd)->first()->trangthai ?? 'CC';
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

                $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd)
                    ->where('madonvi', $inputs['madonvi'])->first();
                $trangthai = $m_trangthai_hoso->where('mahoso', $HoSo->mahosotdkt ?? '')->first();

                $DangKy->trangthai = $trangthai->trangthai ?? 'CXD';
                $DangKy->ngaychuyen = $trangthai->thoigian ?? '';
                $DangKy->hosodonvi = $HoSo == null ? 0 : 1;
                $DangKy->id = $HoSo == null ? -1 : $HoSo->id;
                $DangKy->mahosotdkt = $HoSo == null ? -1 : $HoSo->mahosotdkt;
            }
            //dd($model);

            return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThongTin')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_trangthaihoso', getTrangThaiTDKT())
                ->with('pageTitle', 'Danh sách hồ sơ thi đua');
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
            $m_phongtrao = dsphongtraothidua::where('maphongtraotd',$inputs['maphongtraotd'])->first();
            
            if ($model == null) {
                $model = new dshosothiduakhenthuong();
                $model->madonvi = $inputs['madonvi'];
                $model->mahosotdkt = getdate()[0];
                $model->maloaihinhkt = $m_phongtrao->maloaihinhkt;
                $model->maloaihinhkt = $inputs['maphongtraotd'];
            }

            $model_khenthuong = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $model->mahosotdkt)->get();
            $model_tieuchuan = dshosothiduakhenthuong_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->get();
            
            return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThayDoi')
                ->with('model', $model)
                ->with('model_khenthuong',$model_khenthuong->where('phanloai','CANHAN'))
                ->with('model_tapthe',$model_khenthuong->where('phanloai','TAPTHE'))
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
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
            dd($request->all());
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

            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if ($model == null) {
                dshosothiduakhenthuong::create($inputs);
                $trangthai = new trangthaihoso();
                $trangthai->trangthai = 'CC';
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
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            dsdiaban::findorfail($inputs['iddelete'])->delete();
            return redirect('/DiaBan/ThongTin');
        } else
            return view('errors.notlogin');
    }

    public function ThemKhenThuong(Request $request)
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
        $m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        $model = dsphongtraothidua_khenthuong::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->first();
        if ($model == null) {
            $model = new dsphongtraothidua_khenthuong();
            $model->madanhhieutd = $m_danhhieu->madanhhieutd;
            $model->maphongtraotd = $inputs['maphongtraotd'];
            $model->soluong = $inputs['soluong'];
            $model->tendanhhieutd = $m_danhhieu->tendanhhieutd;
            $model->phanloai = $m_danhhieu->phanloai;
            $model->save();
            $m_tieuchuan = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();
            foreach ($m_tieuchuan as $tieuchuan) {
                $model = new dsphongtraothidua_tieuchuan();
                $model->maphongtraotd = $inputs['maphongtraotd'];
                $model->madanhhieutd = $tieuchuan->madanhhieutd;
                $model->matieuchuandhtd = $tieuchuan->matieuchuandhtd;
                $model->tentieuchuandhtd = $tieuchuan->tentieuchuandhtd;
                $model->cancu = $tieuchuan->cancu;
                $model->batbuoc = 1;
                $model->save();
            }
        } else {
            $model->soluong = $inputs['soluong'];
            $model->tendanhhieutd = $m_danhhieu->tendanhhieutd;
            $model->phanloai = $m_danhhieu->phanloai;
            $model->save();
        }

        $modelct = dsphongtraothidua_khenthuong::where('maphongtraotd', $inputs['maphongtraotd'])->get();
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dskhenthuong">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center" width="25%">Phân loại</th>';
            $result['message'] .= '<th style="text-align: center">Danh hiệu thi đua</th>';
            $result['message'] .= '<th style="text-align: center" width="8%">Số lượng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->phanloai . '</td>';
                $result['message'] .= '<td class="active">' . $ct->tendanhhieutd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->soluong . '</td>';
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-delete" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getId(' . $ct->id . ')" ><i class="fa fa-trash-o"></i></button>' .
                    '<button type="button" data-target="#modal-edit" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="editDanhHieu(' . $ct->id . ')"><i class="fa fa-edit"></i></button>'
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

    public function ThemTieuChuan(Request $request)
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
        $m_tieuchuan = dmdanhhieuthidua_tieuchuan::where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();
        $model = dsphongtraothidua_tieuchuan::where('matieuchuandhtd', $inputs['matieuchuandhtd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->first();
        if ($model == null) {
            $model = new dsphongtraothidua_tieuchuan();
            $model->maphongtraotd = $inputs['maphongtraotd'];
            $model->madanhhieutd = $m_tieuchuan->madanhhieutd;
            $model->tentieuchuandhtd = $m_tieuchuan->tentieuchuandhtd;
            $model->matieuchuandhtd = $m_tieuchuan->matieuchuandhtd;
            $model->batbuoc = $inputs['batbuoc'];
            $model->save();
        } else {
            $model->batbuoc = $inputs['batbuoc'];
            $model->tentieuchuandhtd = $m_tieuchuan->tentieuchuandhtd;
            $model->save();
        }

        $modelct = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->get();
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên danh hiệu</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="8%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->madanhhieutd . '</td>';
                $result['message'] .= '<td class="active">' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-delete" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getId(' . $ct->id . ')" ><i class="fa fa-trash-o"></i></button>' .
                    '<button type="button" data-target="#modal-edit" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="editDanhHieu(' . $ct->id . ')"><i class="fa fa-edit"></i></button>'
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
        $m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $model = dsphongtraothidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->get();

        if (isset($model)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($model as $ct) {

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
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
}
