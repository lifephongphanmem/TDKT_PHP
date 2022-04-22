<?php

function getHeThongChung()
{
    return  \App\Model\HeThong\hethongchung::all()->first() ?? new \App\Model\HeThong\hethongchung();
}

function getPhanLoaiDonVi_DiaBan()
{
    return array(
        //'ADMIN'=>'Đơn vị tổng hợp toàn Tỉnh',
        'T' => 'Đơn vị hành chính cấp Tỉnh',
        'H' => 'Đơn vị hành chính cấp Thành phố, Huyện',
        'X' => 'Đơn vị hành chính cấp Xã, Phường, Thị trấn',
    );
}

function getPhamViApDung()
{
    return array(
        //'ADMIN'=>'Đơn vị tổng hợp toàn Tỉnh',
        'TW' => 'Cấp Trung ương',
        'T' => 'Cấp Tỉnh',
        'H' => 'Cấp Thành phố, Thị xã, Huyện',
        'X' => 'Cấp Xã, Phường, Thị trấn',
    );
}

function getPhanLoaiDonVi()
{
    return array(
        'TONGHOP' => 'Đơn vị tổng hợp dữ liệu',
        'NHAPLIEU' => 'Đơn vị nhập liệu',
        'QUANTRI' => 'Đơn vị quản trị hệ thống',
    );
}

function getPhanLoaiTDKT()
{
    return array(
        'CANHAN' => 'Danh hiệu thi đua đối với cá nhân',
        'TAPTHE' => 'Danh hiệu thi đua đối với tập thể',
        'HOGIADINH' => 'Danh hiệu thi đua đối với hộ gia đình',
    );
}

function getPhanLoaiHinhThucKT()
{
    return array(
        'HUANCHUONG' => 'Huân chương',
        'HUYCHUONG' => 'Huy chương',
        'DANHHIEUNN' => 'Danh hiệu vinh dự Nhà nước',
        'GIAITHUONG' => 'Giải thưởng Hồ Chí Minh, Giải thưởng Nhà nước',
        'KYNIEMCHUONG' => 'Kỷ niệm chương, Huy hiệu',
        'BANGKHEN' => 'Bằng khen',
        'GIAYKHEN' => 'Giấy khen',
    );
}

function getPhamViPhongTrao()
{
    return array(
        'CUNGCAP' => 'Các đơn vị trong cùng cấp quản lý (cùng địa bàn quản lý)',
        'CAPDUOI' => 'Các đơn vị cấp dưới quản lý trực tiếp',
        'TOANTINH' => 'Toàn bộ các đơn vị trong Tỉnh',
    );
}

function getTrangThaiTDKT()
{
    return array(
        'CHUABATDAU' => 'Chưa bắt đầu nhận hồ sơ',
        'DANGNHAN' => 'Đang nhận hồ sơ',
        'KETTHUC' => 'Đã kết thúc nhận hồ sơ',
    );
}

function getGioiTinh()
{
    return array(
        'NAM' => 'Giới tính Nam',
        'NU' => 'Giới tính Nữ',
        'KHAC' => 'Giới tính khác',
    );
}

function getThang($all = false)
{
    $a_tl = array(
        '01' => '01', '02' => '02', '03' => '03',
        '04' => '04', '05' => '05', '06' => '06',
        '07' => '07', '08' => '08', '09' => '09',
        '10' => '10', '11' => '11', '12' => '12'
    );
    if ($all)
        return array_merge(array('ALL' => '--Tất cả--'), $a_tl);
    else
        return $a_tl;
}

function getNam($all = false)
{
    $a_tl = $all == true ? array('ALL' => 'Tất cả') : array();
    for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++) {
        $a_tl[$i] = $i;
    }
    return $a_tl;
}

function getDiaBan_All($all = false)
{
    $a_diaban = array_column(\App\Model\DanhMuc\dsdiaban::all()->toarray(), 'tendiaban', 'madiaban');
    if ($all) {
        $a_kq = ['null' => '-- Chọn địa bàn --'];
        foreach ($a_diaban as $k => $v) {
            $a_kq[$k] = $v;
        }
        return $a_kq;
    }
    return $a_diaban;
}

function getDonViQuanLyDiaBan($madiaban, $kieudulieu = 'ARRAY')
{
    $m_diaban = \App\Model\DanhMuc\dsdiaban::where('madiaban', $madiaban)->first();
    $model = \App\Model\DanhMuc\dsdonvi::where('madonvi', $m_diaban->madonviQL)->get();
    switch($kieudulieu){
        case 'MODEL': {
            return $model;
            break;
        }
        default: 
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

//lây các đơn vị có chức năng quản lý địa bàn
function getDonViXetDuyetHoSo($capdo, $madiaban = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    $model = \App\Model\View\viewdiabandonvi::wherein('capdo', ['T', 'H'])->get();
    switch($kieudulieu){
        case 'MODEL': {
            return $model;
            break;
        }
        default: 
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}
function getDiaBanXetDuyetHoSo($capdo, $madiaban = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    $model = \App\Model\DanhMuc\dsdiaban::wherein('capdo', ['T', 'H'])->get();
    switch($kieudulieu){
        case 'MODEL': {
            return $model;
            break;
        }
        default: 
            return array_column($model->toarray(), 'tendiaban', 'madiaban');
    }
}

//chưa làm 
function chkPhanQuyen()
{
    return true;
}

function getDonVi($capdo, $chucnang = null, $tenquyen = null)
{
    return App\Model\View\viewdiabandonvi::all();
}
