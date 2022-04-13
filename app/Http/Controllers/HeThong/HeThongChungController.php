<?php

namespace App\Http\Controllers\HeThong;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HeThongChungController extends Controller
{
    public function index(){
        if (Session::has('admin')) {
            return view('HeThong.TrangChu')
                ->with('model',getHeThongChung())
                ->with('pageTitle', 'Thông tin hỗ trợ');
        } else {            
            return view('HeThong.welcome');
        }
    }

    public function DangNhap(Request $request)
    {
        $inputs = $request->all();
        return view('HeThong.DangNhap')
            ->with('inputs',$inputs)
            ->with('pageTitle', 'Đăng nhập hệ thống');
    }

    public function XacNhanDangNhap(Request $request)
    {
        $input = $request->all();
        dd($input);
        $ttuser = DSTaiKhoan::where('username', $input['username'])->first();
        //Tài khoản không tồn tại
        if ($ttuser == null) {
            return view('errors.403')
                ->with('message', 'Sai tên tài khoản hoặc sai mật khẩu đăng nhập.');
        }

        //Tài khoản đang bị khóa
        if ($ttuser->trangthai == "0") {
            return view('errors.lockuser');
        }
        $a_HeThongChung = getHeThongChung();
        $solandn = chkDbl($a_HeThongChung->solandn);
        //Sai mật khẩu
        if (md5($input['password']) != $ttuser->password) {
            $ttuser->solandn = $ttuser->solandn + 1;
            if ($ttuser->solandn >= $solandn) {
                $ttuser->status = 'Vô hiệu';
                $ttuser->save();
                return view('errors.lockuser');
            }
            $ttuser->save();
            return view('errors.403')
                ->with('message', 'Sai tên tài khoản hoặc sai mật khẩu đăng nhập.<br>Số lần đăng nhập: ' . $ttuser->solandn . '/' . $solandn . ' lần
                    .<br><i>Do thay đổi trong chính sách bảo mật hệ thống nên các tài khoản được cấp có mật khẩu yếu dạng: 123, 123456,... sẽ bị thay đổi lại</i>');
        }

        $ttuser->solandn = 0;
        $ttuser->save();

        //kiểm tra tài khoản
        //1. level = SSA ->
        if ($ttuser->sadmin != "SSA") {
            //dd($ttuser);
            //2. level != SSA -> lấy thông tin đơn vị, hệ thống để thiết lập lại

            $m_donvi = DSTaiKhoan::where('madonvi', $ttuser->madonvi)->first();

            //dd($ttuser);
            $ttuser->madiaban = $m_donvi->madiaban;
            $ttuser->maqhns = $m_donvi->maqhns;
            $ttuser->tendv = $m_donvi->tendv;
            $ttuser->emailql = $m_donvi->emailql;
            $ttuser->emailqt = $m_donvi->emailqt;
            $ttuser->songaylv = $m_donvi->songaylv;
            $ttuser->tendvhienthi = $m_donvi->tendvhienthi;
            $ttuser->tendvcqhienthi = $m_donvi->tendvcqhienthi;
            $ttuser->chucvuky = $m_donvi->chucvuky;
            $ttuser->chucvukythay = $m_donvi->chucvukythay;
            $ttuser->nguoiky = $m_donvi->nguoiky;
            $ttuser->diadanh = $m_donvi->diadanh;
            $ttuser->chucnang = explode(';', $m_donvi->chucnang);

            //Lấy thông tin địa bàn
            $m_diaban = DSDiaBan::where('madiaban', $ttuser->madiaban)->first();

            $ttuser->tendiaban = $m_diaban->tendiaban;
            $ttuser->level = $m_diaban->level;
        } else {
            $ttuser->chucnang = array('SSA');
            $ttuser->level = "SSA";
        }

        //Lấy setting gán luôn vào phiên đăng nhập
        $ttuser->setting = json_decode($a_HeThongChung->setting, true);
        $ttuser->permission = json_decode($a_HeThongChung->permission, true);
        $ttuser->ipf1 = $a_HeThongChung->ipf1;
        $ttuser->ipf2 = $a_HeThongChung->ipf2;
        $ttuser->ipf3 = $a_HeThongChung->ipf3;
        $ttuser->ipf4 = $a_HeThongChung->ipf4;
        $ttuser->ipf5 = $a_HeThongChung->ipf5;
        //dd($ttuser);
        Session::put('admin', $ttuser);
        //dd(session('admin'));
        return redirect('')
            ->with('pageTitle', 'Tổng quan');
    }

    public function QuenMatKhau(Request $request){
        $input = $request->all();
        $model = DSTaiKhoan::where('username', $input['username'])->first();
        if (isset($model)) {
            if ($model->email == $input['email']) {
                $npass = getRandomPassword();
                $model->password = md5($npass);
                $model->save();

                $data = [];
                $data['tendn'] = $model->name;
                $data['username'] = $model->username;
                $data['npass'] = $npass;
                $maildn = $model->email;
                $tendn = $model->name;

                Mail::send('mail.successnewpassword', $data, function ($message) use ($maildn, $tendn) {
                    $message->to($maildn, $tendn)
                        ->subject('Thông báo thay đổi mật khẩu tài khoản');
                    $message->from('qlgiakhanhhoa@gmail.com', 'Phần mềm CSDL giá');
                });
                return view('errors.forgotpass-success');
            } else
                return view('errors.forgotpass-errors');
        } else
            return view('errors.forgotpass-errors');
    }

}
