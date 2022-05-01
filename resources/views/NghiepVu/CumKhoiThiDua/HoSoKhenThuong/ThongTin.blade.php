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
                window.location.href = '/CumKhoiThiDua/HoSoKhenThuong/ThongTin?madonvi=' + $('#madonvi').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách cụm khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($m_diaban as $diaban)
                            <optgroup label="{{ $diaban->tendiaban }}">
                                <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên cụm, khối thi đua</th>
                                <th width="15%">Cấp độ</th>
                                <th width="8%">Số</br>hồ sơ</th>
                                <th width="30%">Đơn vị quản lý cụm, khối</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td class="active">{{ $tt->tencumkhoi }}</td>
                                <td>{{ $a_capdo[$tt->capdo] ?? '' }}</td>
                                <td class=" text-center">{{ $tt->sohoso }}</td>
                                <td>{{ $a_donvi[$tt->madonviql] ?? '' }}</td>
                                <td class=" text-center">
                                    @if (chkPhanQuyen('dscumkhoi', 'modify'))
                                        <a title="Danh sách chi tiết"
                                            href="{{ url('/CumKhoiThiDua/HoSoKhenThuong/DanhSach/?macumkhoi=' . $tt->macumkhoi.'&madonvi='.$inputs['madonvi']) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la la-clipboard-list text-dark"></i></a>                                        
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
@stop
