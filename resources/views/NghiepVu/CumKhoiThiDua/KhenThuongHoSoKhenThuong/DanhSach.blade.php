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
        jQuery(document).ready(function() {
            TableManagedclass.init();
            $('#madonvi').change(function() {
                window.location.href = '/XetDuyetHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
            $('#nam').change(function() {
                window.location.href = '/XetDuyetHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::model($model, ['method' => 'POST', '/CumKhoiThiDua/HoSoKhenThuong/Them', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin hồ sơ khen thưởng</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        
        <div class="card-body">
            <h4 class="form-section" style="color: #0000ff">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-lg-9">
                    <label>Đơn vị khen thưởng</label>
                    {!! Form::text('donvikhenthuong', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('capkhenthuong', getPhamViApDung(), null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Chức vụ người ký</label>
                    {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Họ tên người ký</label>
                    {!! Form::text('hotennguoiky', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách hồ sơ đề nghị</h4>
            <div class="form-group row">                
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th>Tên đơn vị đăng ký</th>
                                <th width="10%">Khen thưởng</th>
                                <th style="text-align: center" width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($m_chitiet as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>
                                <td class="text-center">{{ $tt->ketqua }}</td>
                                <td style="text-align: center">
                                    <button title="Sửa trạng thái" type="button"
                                        onclick="getHoSo('{{ $tt->mahosokt }}', '{{ $a_donvi[$tt->madonvi_kt] ?? '' }}','{{ $tt->mahosotdkt }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#modal-hoso" data-toggle="modal">
                                        <i class="icon-lg la fa-edit text-dark"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo cá nhân</h4>
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên đơn vị đăng ký</th>
                                <th>Tên đối tượng</th>
                                <th>Tên danh hiệu</th>
                                <th width="5%">Số chỉ<br>tiêu</th>
                                <th width="5%">Đạt tiêu<br>chuẩn</th>
                                <th width="15%">Hình thức<br>khen thưởng</th>
                                <th style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model_canhan as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>
                                <td>{{ $tt->tendoituong }}</td>
                                <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                <td style="text-align: center">{{ $tt->tongdieukien . '/' . $tt->tongtieuchuan }}</td>
                                <td class="text-center">{{ $tt->ketqua }}</td>
                                <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                <td class="text-center">
                                    <button title="Danh sách tiêu chuẩn" type="button"
                                        onclick="getIdBack('{{ $tt->id }}')" class="btn btn-sm btn-clean btn-icon"
                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                        <i class="icon-lg la fa-eye text-dark"></i></button>
                                    <a title="In kết quả" href="{{ url('/XetDuyetHoSoThiDua/InKetQua?id=' . $tt->id) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-print text-dark"></i></a>
                                        <button title="Thay đổi" type="button"
                                        onclick="setKetQua('{{ $tt->id }}','{{ $a_donvi[$tt->madonvi_kt] ?? '' }}', '{{ $tt->mahinhthuckt }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#modal-ketqua"
                                        data-toggle="modal">
                                        <i class="icon-lg la fa-check text-dark"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="form-group row">
                <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo tập thể</h4>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên đơn vị đăng ký</th>
                                <th>Tên danh hiệu</th>
                                <th width="5%">Số chỉ<br>tiêu</th>
                                <th width="5%">Đạt tiêu<br>chuẩn</th>
                                <th width="15%">Hình thức<br>khen thưởng</th>
                                <th style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model_tapthe as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>
                                <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                <td class="text-center">{{ $tt->tongdieukien . '/' . $tt->tongtieuchuan }}</td>
                                <td class="text-center">{{ $tt->ketqua }}</td>
                                <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                <td style="text-align: center">
                                    <button title="Danh sách tiêu chuẩn" type="button"
                                        onclick="getIdBack('{{ $tt->id }}')" class="btn btn-sm btn-clean btn-icon"
                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                        <i class="icon-lg la fa-eye text-dark"></i></button>

                                    <button title="Thay đổi" type="button"
                                        onclick="setKetQua('{{ $tt->id }}','{{ $a_donvi[$tt->madonvi_kt] ?? '' }}', '{{ $tt->mahinhthuckt }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#modal-ketqua"
                                        data-toggle="modal">
                                        <i class="icon-lg la fa-check text-dark"></i></button>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/CumKhoiThiDua/KhenThuongHoSoKhenThuong/ThongTin?madonvi='.$model->madonvi.'&macumkhoi=' . $model->macumkhoi) }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    {{-- @if ($inputs['trangthai'] == 'true')
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                    @endif --}}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->
    {{-- Hồ sơ  --}}
    <div id="modal-hoso" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => '/CumKhoiThiDua/KhenThuongHoSoKhenThuong/HoSo', 'id' => 'frm_hoso']) !!}
        <input type="hidden" name="mahosokt" />
        <input type="hidden" name="mahosotdkt" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin hồ sơ thi đua</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đơn vị quyết định khen thưởng</label>
                            {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Khen thưởng</label>
                            {!! Form::select('khenthuong', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], 'T', ['class' => 'form-control']) !!}
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickHoSo()">Đồng ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    {{-- Kết quả --}}
    {!! Form::open(['url' => '/CumKhoiThiDua/KhenThuongHoSoKhenThuong/KetQua', 'id' => 'frm_KetQua', 'method' => 'post']) !!}
    <div id="modal-ketqua" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <input type="hidden" name="id" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đối tượng</label>
                            {!! Form::textarea('tendoituong', null, ['class' => 'form-control', 'rows' => '2']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đối tượng</label>
                            <div class="checkbox-inline">
                                <div class="col-lg-12">
                                    <label class="checkbox checkbox-rounded">
                                        <input type="checkbox" checked="checked" name="dieukien">
                                        <span></span>Đạt điều kiện khen thưởng</label>
                                </div>                                
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-control-label">Hình thức khen thưởng</label>
                                {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" value="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <script>
        function setKetQua(id, tendt, mahinhthuckt) {
            $('#frm_KetQua').find("[name='id']").val(id);
            $('#frm_KetQua').find("[name='tendoituong']").val(tendt);
            $('#frm_KetQua').find("[name='mahinhthuckt']").val(mahinhthuckt).trigger('change');
        }

        function clickHoSo() {
            $('#frm_hoso').submit();
        }

        function getHoSo(mahosokt, tendonvi, mahosotdkt) {
            $('#frm_hoso').find("[name='mahosokt']").val(mahosokt);
            $('#frm_hoso').find("[name='tendonvi']").val(tendonvi);
            $('#frm_hoso').find("[name='mahosotdkt']").val(mahosotdkt);
        }
    </script>

@stop
