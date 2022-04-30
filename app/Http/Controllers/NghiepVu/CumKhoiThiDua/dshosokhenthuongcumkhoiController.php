<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dscumkhoi_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_khenthuong;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tieuchuan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong_khenthuong;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dshosokhenthuongcumkhoiController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();            
            $m_donvi = getDonViCK(session('admin')->capdo, null, 'MODEL');
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $inputs['nam'] = $inputs['nam'] ?? 'ALL';
            $m_cumkhoi_chitiet = dscumkhoi_chitiet::where('madonvi',$inputs['madonvi'])->get();
            $model = dscumkhoi::wherein('macumkhoi',array_column($m_cumkhoi_chitiet->toarray(),'macumkhoi'))->get();
            //dd($model);
            return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThongTin')
                ->with('model', $model)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_capdo', getPhamViApDung())
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách phong trào thi đua');
        } else
            return view('errors.notlogin');
    }

    public function DanhSach(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            
            $m_donvi = getDonViCumKhoi($inputs['macumkhoi'],'MODEL');
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(),'madiaban'))->get();            
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $inputs['nam'] = $inputs['nam'] ?? date('Y');
            //nếu đơn vị trưởng cụm thì thấy tất cả hồ sơ
            //nếu đơn vị thành viên chỉ thấy hồ sơ của đơn vị mình
            $model = dshosotdktcumkhoi::where('macumkhoi',$inputs['macumkhoi'])->where('madonvi',$inputs['madonvi'])->get();;
            $m_cumkhoi_chitiet = dscumkhoi_chitiet::where('madonvi',$inputs['madonvi'])->get();
            $m_cumkhoi = dscumkhoi::wherein('macumkhoi',array_column($m_cumkhoi_chitiet->toarray(),'macumkhoi'))->get();
            return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.DanhSach')
                ->with('model', $model)
                ->with('m_cumkhoi', $m_cumkhoi)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_diaban', $m_diaban)
                ->with('a_donviql', getDonViQuanLyCumKhoi($inputs['macumkhoi']))
                ->with('a_donvi', array_column(dsdonvi::all()->toArray(),'tendonvi','madonvi'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(),'tenloaihinhkt','maloaihinhkt'))
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
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            $m_danhhieu = dmdanhhieuthidua::all();

            $inputs = $request->all();
            $inputs['mahosotdkt'] = $inputs['mahosotdkt'] ?? null;
            $inputs['trangthai'] = $inputs['trangthai'] ?? true;
            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();

            if ($model == null) {
                $model = new dshosotdktcumkhoi();
                $model->madonvi = $inputs['madonvi'];
                
                $model->mahosotdkt = (string)getdate()[0];
                $model->macumkhoi = $inputs['macumkhoi'];
                $model->ngayhoso = date('Y-m-d');
            }
            $model->tendonvi =$m_donvi->where('madonvi',$inputs['madonvi'])->first()->tendonvi;
            $model->tencumkhoi = dscumkhoi::where('macumkhoi',$inputs['macumkhoi'])->first()->tencumkhoi;
            $model_khenthuong = dshosotdktcumkhoi_khenthuong::where('mahosotdkt', $model->mahosotdkt)->get();
            $model_tieuchuan = dshosotdktcumkhoi_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->get();
            //dd( $model);
            
            return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThayDoi')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $model_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('pageTitle', 'Hồ sơ khen thưởng');
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

            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if ($model == null) {
                $inputs['trangthai'] = 'CC';
                dshosotdktcumkhoi::create($inputs);
                $trangthai = new trangthaihoso();
                $trangthai->trangthai = $inputs['trangthai'];
                $trangthai->madonvi = $inputs['madonvi'];
                $trangthai->phanloai = 'dshosotdktcumkhoi';
                $trangthai->mahoso = $inputs['mahosotdkt'];
                $trangthai->thoigian = date('Y-m-d H:i:s');
                $trangthai->save();
            } else {
                $model->update($inputs);
            }

            return redirect('CumKhoiThiDua/HoSoKhenThuong/DanhSach?madonvi='.$inputs['madonvi'].'&macumkhoi=' . $inputs['macumkhoi']);
        } else
            return view('errors.notlogin');
    }

    public function Sua(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();            
            $request->merge(['madonvi' => $model->madonvi,'macumkhoi'=>$model->macumkhoi]);
            //dd($request->all());
            return $this->ThayDoi($request);
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
        
        $model = dshosotdktcumkhoi_khenthuong::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if ($model == null) {
            $model = new dshosotdktcumkhoi_khenthuong();
            $model->madoituong = getdate()[0];
            $model->mahosotdkt = $inputs['mahosotdkt'];
            $model->phanloai = 'CANHAN';
            $model->madonvi = $inputs['madonvi'];
            $model->madanhhieutd = $inputs['madanhhieutd'];
            $model->ngaysinh = $inputs['ngaysinh'];
            $model->gioitinh = $inputs['gioitinh'];
            $model->chucvu = $inputs['chucvu'];
            $model->maccvc = $inputs['maccvc'];
            $model->lanhdao = $inputs['lanhdao'];
            $model->tendoituong = $inputs['tendoituong'];
            $model->save();
        } else {
            $model->madanhhieutd = $inputs['madanhhieutd'];
            $model->ngaysinh = $inputs['ngaysinh'];
            $model->gioitinh = $inputs['gioitinh'];
            $model->chucvu = $inputs['chucvu'];
            $model->maccvc = $inputs['maccvc'];
            $model->tendoituong = $inputs['tendoituong'];
            $model->save();
        }

        $modelct = dshosotdktcumkhoi_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])
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
            $a_danhhieu = array_column(dmdanhhieuthidua::all()->toArray(),'tendanhhieutd','madanhhieutd');
            foreach ($modelct as $ct) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tendoituong . '</td>';
                $result['message'] .= '<td>' . getDayVn($ct->ngaysinh) . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->gioitinh . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->chucvu . '</td>';
                $result['message'] .= '<td style="text-align: center">' . ($a_danhhieu[$ct->madanhhieutd] ?? '') . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->madoituong . ',' . $ct->madanhhieutd . ',' . $ct->tendoituong . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-primary"></i></button>' .
                    '<button title="Sửa" type="button" data-target="#modal-edit" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getCaNhan(' . $ct->id . ')"><i class="icon-lg la la fa-edit text-primary"></i></button>' .
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
        $model = dshosotdktcumkhoi_khenthuong::where('matapthe', $inputs['matapthe'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if ($model == null) {
            $model = new dshosotdktcumkhoi_khenthuong();
            $model->matapthe = $inputs['matapthe'];
            $model->mahosotdkt = $inputs['mahosotdkt'];
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

        $modelct = dshosotdktcumkhoi_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])
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
            $a_danhhieu = array_column(dmdanhhieuthidua::all()->toArray(),'tendanhhieutd','madanhhieutd');
            foreach ($modelct as $ct) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentapthe . '</td>';
                $result['message'] .= '<td style="text-align: center">' . ($a_danhhieu[$ct->madanhhieutd] ?? '') . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->matapthe . ',' . $ct->madanhhieutd . ',' . $ct->tentapthe . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-primary"></i></button>' .
                    '<button type="button" data-target="#modal-edit" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getTapThe(' . $ct->id . ')"><i class="icon-lg la fa-edit text-primary"></i></button>' .
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
        $model = dshosotdktcumkhoi_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tieuchuan = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();

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
        $model = dshosotdktcumkhoi_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('matieuchuandhtd', $inputs['matieuchuandhtd'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->first();

        //chưa lấy biến điều kiện đang dùng tạm để demo
        if ($model == null) {
            $model = new dshosotdktcumkhoi_tieuchuan();
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
        $model = dshosotdktcumkhoi_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tieuchuan = dshosotdktcumkhoi_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
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
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        //dd($inputs);

        $result['message'] = '<div class="col-md-12" id="showlido">';
        $result['message'] .= $model->lydo;

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
        $model = dshosokhenthuong_khenthuong::findorfail($inputs['id']);

        $model->delete();

        $modelct = dshosokhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])
            ->where('phanloai', $inputs['phanloai'])
            ->get();
        if ($inputs['phanloai'] == 'CANHAN') {
            dshosotdktcumkhoi_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
                ->where('mahosotdkt', $inputs['mahosotdkt'])
                ->where('madoituong', $model->madoituong)->delete();
            $result = $this->returnHTMLCaNhan($modelct);
        } else {
            dshosotdktcumkhoi_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])
                ->where('mahosotdkt', $inputs['mahosotdkt'])
                ->where('matapthe', $model->matapthe)->delete();
            $result = $this->returnHTMLTapThe($modelct);
        }

        die(json_encode($result));
    }
    
    public function ChuyenHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
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
            $trangthai->phanloai = 'dshosotdktcumkhoi';
            $trangthai->mahoso = $model->mahosotdkt;
            $trangthai->thoigian = $model->thoigian;
            $trangthai->save();

            return redirect('CumKhoiThiDua/HoSoKhenThuong/DanhSach?madonvi='.$model->madonvi.'&macumkhoi=' . $model->macumkhoi);
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
        $model = dshosotdktcumkhoi_khenthuong::findorfail($inputs['id']);        
        die(json_encode($model));
    }

    public function XemHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            $m_danhhieu = dmdanhhieuthidua::all();
            $inputs = $request->all();
            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();            
            $model->tendonvi =$m_donvi->where('madonvi',$model->madonvi)->first()->tendonvi;
            $model->tencumkhoi = dscumkhoi::where('macumkhoi',$model->macumkhoi)->first()->tencumkhoi;
            $model_khenthuong = dshosotdktcumkhoi_khenthuong::where('mahosotdkt', $model->mahosotdkt)->get();
            $model_tieuchuan = dshosotdktcumkhoi_tieuchuan::where('mahosotdkt', $model->mahosotdkt)->get();
            //dd( $model);
            
            return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.Xem')
                ->with('model', $model)
                ->with('model_khenthuong', $model_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $model_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('model_tieuchuan', $model_tieuchuan)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('pageTitle', 'Hồ sơ khen thưởng');
        } else
            return view('errors.notlogin');
    }
}
