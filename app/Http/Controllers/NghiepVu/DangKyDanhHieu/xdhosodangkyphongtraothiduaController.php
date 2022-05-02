<?php

namespace App\Http\Controllers\NghiepVu\DangKyDanhHieu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class xdhosodangkyphongtraothiduaController extends Controller
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
            //$donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
            //$capdo = $donvi->capdo ?? '';           

            $model = dshosodangkyphongtraothidua::wherein('mahosodk', function ($qr) use ($inputs) {
                $qr->select('mahosodk')->from('dshosodangkyphongtraothidua')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
            });

            if ($inputs['nam'] != 'ALL')
                $model = $model->where('namdangky', $inputs['nam']);

            $model = $model->orderby('ngayhoso')->get();
            foreach ($model as $hoso) {
                getDonViChuyen($inputs['madonvi'], $hoso);
            }
            return view('NghiepVu.DangKyDanhHieu.XetDuyet.ThongTin')
                ->with('model', $model)
                ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_capdo', getPhamViApDung())
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_donviql', getDonViQuanLyTinh())
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách hồ sơ đăng ký');
        } else
            return view('errors.notlogin');
    }

    public function TraLai(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $thoigian = date('Y-m-d H:i:s');
            $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
            $m_nhatky = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
            //lấy thông tin lưu nhật ký
            getDonViChuyen($inputs['madonvi'],$m_nhatky);
            trangthaihoso::create([
                'mahoso'=> $inputs['mahoso'],'trangthai' => 'BTL', 
                'thoigian' => $thoigian, 'lydo' => $inputs['lydo'],'phanloai'=>'dshosodangkyphongtraothidua',
                'madonvi_nhan' => $m_nhatky->madonvi_hoso,'madonvi' => $m_nhatky->madonvi_nhan_hoso
            ]);
            //Gán lại trạng thái cho hồ sơ
            setNhanHoSo($inputs['madonvi'], $model, ['trangthai' => 'BTL', 'thoigian' => $thoigian, 'lydo' => $inputs['lydo'], 'madonvi_nhan' => '']);
            setTrangThaiHoSo($inputs['madonvi'], $model, ['trangthai' => '', 'thoigian' => '', 'lydo' => '', 'madonvi_nhan' => '','madonvi' => '']);           
            $model->save();

            return redirect('/DangKyDanhHieu/XetDuyet/ThongTin?madonvi=' . $inputs['madonvi']);
        } else
            return view('errors.notlogin');
    }

    public function ChuyenHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();

            $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
            $model->trangthai_h = 'DD';
            $model->madonvi_nhan_h = $inputs['madonvi_nhan'];
            $model->thoigian_h = date('Y-m-d H:i:s');

            setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'DD']);
            //dd($model);
            $model->save();

            return redirect('/DangKyDanhHieu/XetDuye/ThongTin?madonvi=' . $model->madonvi_h);
        } else
        return view('errors.notlogin');
    }

    //Chưa hoàn thiện
    public function NhanHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $thoigian = date('Y-m-d H:i:s');
            $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();

            setNhanHoSo($inputs['madonvi_nhan'], $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'DD']);
            setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'DD']);
            //dd($model);
            $model->save();

            return redirect('/DangKyDanhHieu/XetDuyet/ThongTin?madonvi=' . $inputs['madonvi_nhan']);
        } else
            return view('errors.notlogin');
    }
}
