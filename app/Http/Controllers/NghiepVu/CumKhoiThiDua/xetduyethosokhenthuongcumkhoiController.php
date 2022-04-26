<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class xetduyethosokhenthuongcumkhoiController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $m_donvi = getDonViXetDuyetHoSoCumKhoi(session('admin')->capdo, null, null, 'MODEL');
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $inputs['nam'] = $inputs['nam'] ?? 'ALL';
            $m_cumkhoi = dscumkhoi::where('madonviql', $inputs['madonvi'])->get();            
            $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? $m_cumkhoi->first()->macumkhoi;
            //Trường hợp chọn lại đơn vị nhưng mã cụm khối vẫn theo đơn vị cũ
            $inputs['macumkhoi'] = $m_cumkhoi->where('macumkhoi',$inputs['macumkhoi'])->first() != null ? $inputs['macumkhoi'] : $m_cumkhoi->first()->macumkhoi;
            //$donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
            //$capdo = $donvi->capdo ?? '';
            //dd($inputs);
            $model = dshosotdktcumkhoi::where('macumkhoi', $inputs['macumkhoi'])
                ->wherein('mahosotdkt', function ($qr) use ($inputs) {
                    $qr->select('mahosotdkt')->from('dshosotdktcumkhoi')
                        ->where('madonvi_nhan', $inputs['madonvi'])
                        ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                        ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
                })->get();

            foreach ($model as $chitiet) {
                getDonViChuyen($inputs['madonvi'], $chitiet);
                //$chitiet->trangthai = $donvi->capdo == 'H' ? $chitiet->trangthai_h : $chitiet->trangthai_t;
            }
            //dd($model);
            return view('NghiepVu.CumKhoiThiDua.XetDuyetHoSoKhenThuong.ThongTin')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_cumkhoi', $m_cumkhoi)
                ->with('a_donvi', array_column(dsdonvi::all()->toArray(),'tendonvi','madonvi'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(),'tenloaihinhkt','maloaihinhkt'))
                ->with('pageTitle', 'Danh sách hồ sơ thi đua');
        } else
            return view('errors.notlogin');
    }
    
    public function TraLai(Request $request)
    {
        // if (Session::has('admin')) {
        //     $inputs = $request->all();
        //     //Xóa trạng thái chuyển (mỗi đơn vị chỉ để 1 bản ghi trên bảng trạng thái)
        //     $m_trangthai = trangthaihoso::where('mahoso', $inputs['mahoso'])
        //         ->where('madonvi_nhan', $inputs['madonvi'])
        //         ->where('phanloai', 'dshosothiduakhenthuong')->first();
        //     $m_trangthai->delete();

        //     $model = trangthaihoso::where('mahoso', $inputs['mahoso'])
        //         ->where('madonvi', $m_trangthai->madonvi)
        //         ->where('phanloai', 'dshosothiduakhenthuong')->first();
        //     $model->trangthai = 'BTL';
        //     $model->lydo = $inputs['lydo'];
        //     $model->thoigian = date('Y-m-d H:i:s');
        //     $model->save();
        //     $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();

        //     return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $m_hoso->maphongtraotd . '&madonvi=' . $inputs['madonvi']);
        // } else
        //     return view('errors.notlogin');
    }
    
    public function ChuyenHoSo(Request $request)
    {
        // if (Session::has('admin')) {
        //     $inputs = $request->all();

        //     $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //     $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        //     $model->trangthai_h = 'DD';
        //     $model->madonvi_nhan_h = $inputs['madonvi_nhan'];
        //     $model->thoigian_h = date('Y-m-d H:i:s');

        //     setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CNXKT']);
        //     //dd($model);
        //     $model->save();

        //     return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $model->madonvi_h);
        // } else
            return view('errors.notlogin');
    }

    //Chưa hoàn thiện
    public function NhanHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $thoigian = date('Y-m-d H:i:s');
            $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();

            setNhanHoSo($inputs['madonvi_nhan'],$model,['madonvi'=>$inputs['madonvi_nhan'],'thoigian'=>$thoigian,'trangthai'=>'CXKT']);
            setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
            //dd($model);
            $model->save();

            return redirect('/CumKhoiThiDua/XetDuyetHoSoKhenThuong/ThongTin?madonvi='. $inputs['madonvi_nhan'].'&macumkhoi=' . $model->macumkhoi);
        } else
            return view('errors.notlogin');
    }
}
