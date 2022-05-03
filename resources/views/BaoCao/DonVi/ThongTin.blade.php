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

        function add(){
            $('#madanhhieutd').val('');
            $('#madanhhieutd').attr('readonly',true);
        }

        function edit(madanhhieutd, tendanhhieutd, phanloai){
            $('#madanhhieutd').attr('readonly',false);
            $('#madanhhieutd').val(madanhhieutd);
            $('#tendanhhieutd').val(tendanhhieutd);
            $('#phanloai').val(phanloai).trigger('change');
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-1">
            <div class="card-title">
                <h3 class="card-label text-uppercase">DANH SÁCH BÁO CÁO TẠI ĐƠN VỊ</h3>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="separator separator-dashed my-5"></div> --}}
            <div class="form-group row">
                <div class="col-lg-12">
                    <ol>
                        <li>
                            <a href="#" data-target="#modal-canhan" data-toggle="modal"
                               onclick="dutoanluong('{{'don_vi/dutoanluong'}}')">Theo cá nhân</a>
                        </li>

                        <li>
                            <a href="#" data-target="#modal-tapthe" data-toggle="modal" title="Dữ liệu chi trả theo tổng hợp lương tại đơn vị"
                               onclick="chitraluong('{{'don_vi/chitraluong'}}')">Theo tập thể</a>
                        </li>
                        <li>
                            <a href="#" data-target="#modal-phongtrao" data-toggle="modal" title="Dữ liệu chi trả theo tổng hợp lương tại đơn vị"
                               onclick="chitraluong('{{'don_vi/chitratheonkp'}}')">Theo phong trào thi đua khen thưởng</a>

                        </li>

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

@stop
