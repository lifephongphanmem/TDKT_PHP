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
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use Illuminate\Support\Facades\Session;

class dsphongtraothiduaController extends Controller
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
            $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
            $model = dsphongtraothidua::where('madonvi', $inputs['madonvi']);
            if ($inputs['nam'] != 'ALL')
                $model = $model->whereYear('ngayqd', $inputs['nam']);
            if ($inputs['phanloai'] != 'ALL')
                $model = $model->where('phanloai', $inputs['phanloai']);

            return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.ThongTin')
                ->with('model', $model->orderby('ngayqd')->get())
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_phamvi', getPhamViPhongTrao())
                ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách phong trào thi đua');
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
            $inputs['maphongtraotd'] = $inputs['maphongtraotd'] ?? null;

            $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            if ($model == null) {
                $model = new dsphongtraothidua();
                $model->madonvi = $inputs['madonvi'];
                $model->maphongtraotd = getdate()[0];
                $model->trangthai = 'CC';
                $model->maloaihinhkt = '1650358255'; //chưa làm mặc định
            }
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $model_khenthuong = dsphongtraothidua_khenthuong::where('maphongtraotd', $model->maphongtraotd)->get();
            $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();

            return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.ThayDoi')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong)
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách phong trào thi đua');
        } else
            return view('errors.notlogin');
    }

    public function XemThongTin(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }

            $inputs = $request->all();
            $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $model_khenthuong = dsphongtraothidua_khenthuong::where('maphongtraotd', $model->maphongtraotd)->get();
            $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();

            return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.Xem')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong)
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách phong trào thi đua');
        } else
            return view('errors.notlogin');
    }

    public function LuuPhongTrao(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
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

            $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
            if ($model == null) {
                $inputs['trangthai'] = 'CC';
                dsphongtraothidua::create($inputs);

                $trangthai = new trangthaihoso();
                $trangthai->trangthai = 'CC';
                $trangthai->madonvi = $inputs['madonvi'];
                $trangthai->phanloai = 'dsphongtraothidua';
                $trangthai->mahoso = $inputs['maphongtraotd'];
                $trangthai->thoigian = date('Y-m-d H:i:s');
                $trangthai->save();
            } else {
                $model->update($inputs);
            }

            return redirect('/PhongTraoThiDua/ThongTin?madonvi=' . $inputs['madonvi']);
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
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
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
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
            $model->tendanhhieutd = $m_danhhieu->tendanhhieutd;
            $model->phanloai = $m_danhhieu->phanloai;
            $model->save();
        }

        $modelct = dsphongtraothidua_khenthuong::where('maphongtraotd', $inputs['maphongtraotd'])->get();
        $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dskhenthuong">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center" width="25%">Phân loại</th>';
            $result['message'] .= '<th style="text-align: center">Danh hiệu thi đua</th>';
            $result['message'] .= '<th style="text-align: center">Hình thức khen thưởng</th>';
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
                $result['message'] .= '<td>' . ($a_hinhthuckt[$ct->mahinhthuckt] ?? '') . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->soluong . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->madanhhieutd . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i></button>' .
                    '<button title="Xóa" type="button" onclick="getId(' . $ct->id . ')"  class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal" data-toggle="modal">  <i class="icon-lg la fa-trash-alt text-danger"></i></button>' .
                    '</td>';

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
