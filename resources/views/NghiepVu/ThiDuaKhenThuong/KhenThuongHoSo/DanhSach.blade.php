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
        });
    </script>
@stop

@section('content')
    {!! Form::model($model, ['method' => 'POST','url' => '/KhenThuongHoSoThiDua/LuuHoSo', 'class' => 'form', 'id' => 'frm_KhenThuong', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {{ Form::hidden('mahosokt', null) }}
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách khen thưởng theo phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Tên phong trào</label>
                    <textarea class="form-control" readonly>{{ $m_phongtrao->noidung }}</textarea>
                </div>
            </div>
            <h4 class="form-section" style="color: #0000ff">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-md-8">
                    <label style="font-weight: bold">Đơn vị khen thưởng</label>
                    {!! Form::text('tendonvi', $model->donvikhenthuong, ['class' => 'form-control text-bold']) !!}
                </div>
                <div class="col-md-4">
                    <label style="font-weight: bold">Cấp độ khen thưởng</label>
                    {!! Form::text('tendonvi', $model->capdokhenthuong, ['class' => 'form-control text-bold']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Nôi dung khen thưởng</label>
                    {!! Form::textarea('noidung', $model->noidung, ['class' => 'form-control text-bold', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Số quyết định</label>
                    {!! Form::text('soquyetdinh', $model->soquyetdinh, ['class' => 'form-control text-bold']) !!}
                </div>
                <div class="col-md-6">
                    <label style="font-weight: bold">Ngày quyết định</label>
                    {!! Form::input('date', 'ngayhoso', $model->ngayhoso, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Chức vụ người ký</label>
                    {!! Form::text('chucvunguoiky', $model->chucvunguoiky, ['class' => 'form-control text-bold']) !!}
                </div>
                <div class="col-md-6">
                    <label style="font-weight: bold">Họ tên người ký</label>
                    {!! Form::text('hotennguoiky', $model->hotennguoiky, ['class' => 'form-control text-bold']) !!}
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách hồ sơ đăng ký</h4>
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
                                @if ($tt->ketqua == 0)
                                    <td class="text-center"></td>
                                @else
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check text-success"></i></button>
                                    </td>
                                @endif
                                <td style="text-align: center">
                                    <button title="Danh sách tiêu chuẩn" type="button"
                                        onclick="getHoSo('{{ $tt->mahosokt }}','{{ $tt->mahosotdkt }}', '{{ $a_donvi[$tt->madonvi_kt] ?? '' }}')"
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
                                @if ($tt->ketqua == 0)
                                    <td class="text-center"></td>
                                @else
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check text-dark"></i></button>
                                    </td>
                                @endif
                                <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                <td class="text-center">
                                    <button title="Danh sách tiêu chuẩn" type="button"
                                        onclick="getIdBack('{{ $tt->id }}')" class="btn btn-sm btn-clean btn-icon"
                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                        <i class="icon-lg la fa-eye text-dark"></i></button>
                                    <a title="In kết quả"
                                        href="{{ url('/KhenThuongHoSoThiDua/InKetQua?id=' . $tt->id) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-print text-dark"></i></a>
                                    {{-- @if ($m_phongtrao->trangthai == 'CC')
                                        <button title="Thay đổi" type="button"
                                            onclick="setKetQua('{{ $tt->id }}','{{ $tt->tendt }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-ketqua"
                                            data-toggle="modal">
                                            <i class="fa fa-check"></i></button>
                                    @endif --}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo tập thể</h4>
            <div class="form-group row">
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
                                    @if ($m_phongtrao->trangthai == 'CC')
                                        <button title="Thay đổi" type="button"
                                            onclick="setKetQua('{{ $tt->id }}','{{ $a_donvi[$tt->madonvi_kt] ?? '' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-ketqua"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-check text-dark"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách tài liệu kèm theo</h4>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tờ trình: </label>
                    {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                    @if ($model->totrinh != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/totrinh/' . $model->totrinh) }}"
                                target="_blank">{{ $model->totrinh }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Quyết định khen thưởng: </label>
                    {!! Form::file('qdkt', null, ['id' => 'qdkt', 'class' => 'form-control']) !!}
                    @if ($model->qdkt != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/qdkt/' . $model->qdkt) }}" target="_blank">{{ $model->qdkt }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Biên bản: </label>
                    {!! Form::file('bienban', null, ['id' => 'bienban', 'class' => 'form-control']) !!}
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Tài liệu khác: </label>
                    {!! Form::file('tailieukhac', null, ['id' => 'tailieukhac', 'class' => 'form-control']) !!}
                    @if ($model->tailieukhac != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                target="_blank">{{ $model->tailieukhac }}</a>
                        </span>
                    @endif
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/KhenThuongHoSoThiDua/ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {!! Form::close() !!}
    <div id="modal-hoso" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => '/KhenThuongHoSoThiDua/HoSo', 'id' => 'frm_hoso']) !!}
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

    <script>
        function clickHoSo() {
            $('#frm_hoso').submit();
        }

        function getHoSo(mahosokt, mahosotdkt, tendonvi, ) {
            $('#frm_hoso').find("[name='mahosokt']").val(mahosokt);
            $('#frm_hoso').find("[name='mahosotdkt']").val(mahosotdkt);
            $('#frm_hoso').find("[name='tendonvi']").val(tendonvi);
        }
    </script>

@stop
