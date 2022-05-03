@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    <script src="/assets/js/pages/table-lifesc.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-1">
            <div class="card-title">
                <h3 class="card-label text-uppercase">DANH SÁCH BÁO CÁO TỔNG HỢP</h3>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="separator separator-dashed my-5"></div> --}}
            <div class="form-group row">
                <div class="col-lg-12">
                    <ol>
                        <li>
                            <a href="#" data-target="#modal-phongtrao" data-toggle="modal">Phong trào thi đua trên địa bàn</a>
                        </li>

                        <li>
                            <a href="#" data-target="#modal-hosotdkt" data-toggle="modal">Hồ sơ đăng ký thi đua, khen thưởng</a>
                        </li>

                        <li>
                            <a href="#" data-target="#modal-danhhieutd" data-toggle="modal">Danh hiệu thi đua trên địa bàn</a>
                        </li>

                        <li>
                            <a href="#" data-target="#modal-khenthuong" data-toggle="modal">Hình thức khen thưởng trên địa bàn</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <div id="modal-phongtrao" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => 'BaoCao/TongHop/PhongTrao', 'target' => '_blank', 'method' => 'post', 'id' => 'thoai_phongtrao', 'class' => 'form-horizontal form-validate']) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>
                
                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@stop
