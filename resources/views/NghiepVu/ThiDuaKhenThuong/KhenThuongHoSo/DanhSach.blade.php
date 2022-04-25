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

            <div class="form-group row">
                <h4 class="form-section" style="color: #0000ff">Danh sách hồ sơ đăng ký</h4>
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

            <div class="form-group row">
                <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo cá nhân</h4>
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
        </div>
    </div>
    <!--end::Card-->

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
