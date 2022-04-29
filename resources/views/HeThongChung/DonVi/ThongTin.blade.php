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
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách đơn vị</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th colspan="3">STT</th>
                                <th rowspan="2">Tên địa bàn</th>
                                <th rowspan="2" width="50%">Đơn vị quản lý địa bàn</th>
                                <th rowspan="2" width="15%">Thao tác</th>
                            </tr>
                            <tr>
                                <th width="3%">T</th>
                                <th width="3%">H</th>
                                <th width="3%">X</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $model_t = $model->where('capdo', 'T');
                            ?>
                            @foreach ($model_t as $ct_t)
                                <tr class="success">
                                    <td style="text-align: center">{{ $i++ }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="font-weight-bold">{{ $ct_t->tendiaban }}</td>
                                    <td>{{ $a_donvi[$ct_t->madonviQL] ?? '' }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dsdonvi', 'modify'))
                                            <a href={{ '/DonVi/QuanLy?madiaban=' . $ct_t->madiaban }}
                                                class="btn btn-sm btn-clean btn-icon"
                                                title="Thay đổi đơn vị quản lý địa bàn">
                                                <i class="icon-lg la fa-edit text-primary"></i></a>

                                            <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_t->madiaban }}"
                                                class="btn btn-sm btn-clean btn-icon" title="Danh sách đơn vị">
                                                <i class="icon-lg la la-clipboard-list text-dark"></i></a>
                                        @endif

                                    </td>
                                </tr>
                                <?php
                                $j = 1;
                                $model_h = $model->where('madiabanQL', $ct_t->madiaban);
                                ?>
                                @foreach ($model_h as $ct_h)
                                    <tr class="info">
                                        <td></td>
                                        <td style="text-align: center">{{ $j++ }}</td>
                                        <td></td>
                                        <td>{{ $ct_h->tendiaban }}</td>
                                        <td>{{ $a_donvi[$ct_h->madonviQL] ?? '' }}</td>
                                        <td style="text-align: center">
                                            @if (chkPhanQuyen('dsdonvi', 'modify'))
                                                <a href={{ '/DonVi/QuanLy?madiaban=' . $ct_h->madiaban }}
                                                    class="btn btn-sm btn-clean btn-icon"
                                                    title="Thay đổi đơn vị quản lý địa bàn">
                                                    <i class="icon-lg la fa-edit text-primary"></i></a>

                                                <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_h->madiaban }}"
                                                    class="btn btn-sm btn-clean btn-icon" title="Danh sách đơn vị">
                                                    <i class="icon-lg la la-clipboard-list text-dark"></i></a>
                                            @endif

                                        </td>
                                    </tr>
                                    <?php
                                    $k = 1;
                                    $model_x = $model->where('madiabanQL', $ct_h->madiaban);
                                    ?>
                                    @foreach ($model_x as $ct_x)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center">{{ $k++ }}</td>
                                            <td class="em" style="font-style: italic;">{{ $ct_x->tendiaban }}</td>
                                            <td>{{ $a_donvi[$ct_x->madonviQL] ?? '' }}</td>
                                            <td style="text-align: center">
                                                @if (chkPhanQuyen('dsdonvi', 'modify'))
                                                    <a href={{ '/DonVi/QuanLy?madiaban=' . $ct_x->madiaban }}
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        title="Thay đổi đơn vị quản lý địa bàn">
                                                        <i class="icon-lg la fa-edit text-primary"></i></a>

                                                    <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_x->madiaban }}"
                                                        class="btn btn-sm btn-clean btn-icon" title="Danh sách đơn vị">
                                                        <i class="icon-lg la la-clipboard-list text-dark"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
@stop
