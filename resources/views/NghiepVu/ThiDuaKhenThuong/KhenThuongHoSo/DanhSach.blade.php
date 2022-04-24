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
            TableManaged3.init();
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
                <h3 class="card-label text-uppercase">Danh sách phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Tên phong trào</label>
                    <textarea class="form-control" readonly>{{ $m_dangky->noidung }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo cá nhân</h4>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover" id="sample_3">
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
                            @foreach($model_canhan as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{$key+1}}</td>
                                    <td>{{$a_donvi[$tt->madonvi] ?? ''}}</td>
                                    <td>{{$tt->tendt}}</td>
                                    <td>{{$a_danhhieu[$tt->madanhhieutd] ?? ''}}</td>
                                    <td style="text-align: center">{{$tt->tongdieukien.'/'.$tt->tongtieuchuan}}</td>
                                    <td style="text-align: center">{{$tt->ketqua}}</td>
                                    <td>{{$a_hinhthuckt[$tt->maloaihinhkt] ?? ''}}</td>
                                    <td style="text-align: center">
                                        <button title="Danh sách tiêu chuẩn" type="button" onclick="getIdBack('{{$tt->id}}')" class="btn btn-default btn-xs mbs" data-target="#modal-tieuchuan" data-toggle="modal">
                                            <i class="fa fa-eye"></i></button>
                                        <a title="In kết quả" href="{{url('/XetDuyetHoSoThiDua/InKetQua?id='.$tt->id)}}" class="btn btn-default btn-xs mbs" target="_blank">
                                            <i class="fa fa-print"></i></a>
                                        @if($m_dangky->trangthai == 'CC')
                                            <button title="Thay đổi" type="button" onclick="setKetQua('{{$tt->id}}','{{$tt->tendt}}')" class="btn btn-default btn-xs mbs" data-target="#modal-ketqua" data-toggle="modal">
                                                <i class="fa fa-check"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                
                <div class="form-group row">
                    <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo tập thể</h4>
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover" id="sample_4">
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
                            @foreach($model_tapthe as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{$key+1}}</td>
                                    <td>{{$a_donvi[$tt->madonvi_kt] ?? ''}}</td>
                                    <td>{{$a_danhhieu[$tt->madanhhieutd] ?? ''}}</td>
                                    <td style="text-align: center">{{$tt->tongdieukien.'/'.$tt->tongtieuchuan}}</td>
                                    <td style="text-align: center">{{$tt->ketqua}}</td>
                                    <td>{{$a_hinhthuckt[$tt->maloaihinhkt] ?? ''}}</td>
                                    <td style="text-align: center">
                                        <button title="Danh sách tiêu chuẩn" type="button" onclick="getIdBack('{{$tt->id}}')" class="btn btn-default btn-xs mbs" data-target="#modal-tieuchuan" data-toggle="modal">
                                            <i class="fa fa-eye"></i></button>
                                        @if($m_dangky->trangthai == 'CC')
                                            <button title="Thay đổi" type="button" onclick="setKetQua('{{$tt->id}}','{{$a_donvi[$tt->madonvi_kt] ?? ''}}')" class="btn btn-default btn-xs mbs" data-target="#modal-ketqua" data-toggle="modal">
                                                <i class="fa fa-check"></i></button>
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
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_unapprove_hs')
@stop
