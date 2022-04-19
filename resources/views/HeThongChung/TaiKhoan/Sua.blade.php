@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::model($model, ['method' => 'POST', '/TaiKhoan/Sua', 'class' => 'horizontal-form', 'id' => 'update_dmdonvi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {{-- {{ Form::hidden('id', null) }} --}}
    {{ Form::hidden('madonvi', null) }}
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin chi tiết tài khoản</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Đơn vị quản lý</label>
                    {!! Form::select('madonvi', $a_donvi, null, ['class' => 'form-control select2basic', 'disabled']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Tên tài khoản<span class="require">*</span></label>
                    {!! Form::text('tentaikhoan', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Trạng thái</label>
                    {!! Form::select('trangthai', ['1' => 'Kích hoạt', '0' => 'Vô hiệu'], null, ['id' => 'trangthai', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-6">
                    <label>Chức năng tài khoản</label>
                    <div class="checkbox-inline">
                        <div class="col-lg-3">
                            <label class="checkbox checkbox-rounded">
                                <input type="checkbox" checked="checked" name="nhaplieu">
                                <span></span>Nhập liệu</label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox checkbox-rounded">
                                <input type="checkbox" name="tonghop">
                                <span></span>Tổng hợp</label>
                        </div>
                        <div class="col-lg-3">
                            <label class="checkbox checkbox-rounded">
                                <input type="checkbox" name="hethong">
                                <span></span>Quản trị</label>
                        </div>
                    </div>
                    <span class="form-text text-muted">Tài khoản không đồng thời có chức năng: Quản trị và Tổng hợp/Nhập
                        liệu</span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Tài khoản truy cập<span class="require">*</span></label>
                    {!! Form::text('tendangnhap', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-4">
                    <label>Mật khẩu<span class="require">*</span></label>
                    {!! Form::text('matkhau', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/TaiKhoan/ThongTin?madonvi=' . $model->madonvi) }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->
@stop
