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

        function getId(id) {
            document.getElementById("iddelete").value = id;
        }

        function ClickDelete() {
            $('#frm_delete').submit();
        }

        function add() {
            $('#madiaban').val('');
            $('#madiaban').attr('readonly', true);
        }

        function edit(madiaban, tendiaban, capdo) {
            $('#madiaban').attr('readonly', false);
            $('#madiaban').val(madiaban);
            $('#tendiaban').val(tendiaban);
            $('#capdo').val(capdo).trigger('change');
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách địa bàn quản lý</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsdiaban', 'modify'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#modify-modal"
                        data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
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
                                <th rowspan="2" >Tên địa bàn</th>
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
                                $model_t= $model->where('capdo', 'T');
                            ?>
                            @foreach($model_t as $ct_t)
                                <tr class="success">
                                    <td style="text-align: center">{{$i++}}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-dark"><b>{{$ct_t->tendiaban}}</b></td>
                                    <td></td>
                                    <td style="text-align: center">
                                        @if(chkPhanQuyen('dsdonvi', 'modify'))
                                            <a href="" class="btn btn-sm btn-clean btn-icon" title="Thay đổi đơn vị quản lý địa bàn">
                                                <i class="icon-lg la fa-edit text-dark"></i></a>

                                            <a href="{{'/DonVi/DanhSach?madiaban='.$ct_t->madiaban}}" class="btn btn-sm btn-clean btn-icon" title="Danh sách đơn vị">
                                                <i class="icon-lg la fa-list-ol text-info"></i></a>
                                        @endif

                                    </td>
                                </tr>
                                <?php
                                    $j = 1;
                                    $model_h= $model->where('madiabanQL', $ct_t->madiaban);
                                ?>
                                @foreach($model_h as $ct_h)
                                    <tr class="info">
                                        <td></td>
                                        <td style="text-align: center">{{$j++}}</td>
                                        <td></td>
                                        <td class="text-info"><b>{{$ct_h->tendiaban}}</b></td>
                                        <td></td>
                                        <td style="text-align: center">
                                            @if(chkPhanQuyen('dsdonvi', 'modify'))
                                                <a href="" class="btn btn-sm btn-clean btn-icon" title="Thay đổi đơn vị quản lý địa bàn">
                                                    <i class="icon-lg la fa-edit text-dark"></i></a>

                                                <a href="{{'/DonVi/DanhSach?madiaban='.$ct_h->madiaban}}" class="btn btn-sm btn-clean btn-icon" title="Danh sách đơn vị">
                                                    <i class="icon-lg la fa-list-ol text-info"></i></a>
                                            @endif

                                        </td>
                                    </tr>
                                    <?php
                                    $k = 1;
                                    $model_x= $model->where('madiabanQL', $ct_h->madiaban);
                                    ?>
                                    @foreach($model_x as $ct_x)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center">{{$k++}}</td>
                                            <td class="em"style="font-style: italic;">{{$ct_x->tendiaban}}</td>
                                            <td></td>
                                            <td style="text-align: center">
                                                @if(chkPhanQuyen('dsdonvi', 'modify'))
                                                    <a href="" class="btn btn-sm btn-clean btn-icon" title="Thay đổi đơn vị quản lý địa bàn">
                                                        <i class="icon-lg la fa-edit text-dark"></i></a>

                                                    <a href="{{'/DonVi/DanhSach?madiaban='.$ct_x->madiaban}}" class="btn btn-sm btn-clean btn-icon" title="Danh sách đơn vị">
                                                        <i class="icon-lg la fa-list-ol text-info"></i></a>
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
    <!--Modal thông tin chi tiết -->
    {!! Form::open(['url' => 'DiaBan/Sua', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin địa bàn quản lý</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('madiaban', null, ['id' => 'madiaban', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Tên địa bàn<span class="require">*</span></label>
                                {!! Form::text('tendiaban', null, ['id' => 'tendiaban', 'class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Phân loại</label>
                                {!! Form::select('capdo', getPhanLoaiDonVi_DiaBan(), null, ['id' => 'capdo', 'class' => 'form-control select2_modal']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Trực thuộc địa bàn</label>
                                {!! Form::select('madiabanQL', $a_diaban, null, ['id' => 'madiabanQL', 'class' => 'form-control select2_modal']) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => 'diaban/delete', 'id' => 'frm_delete']) !!}
                <div class="modal-header">                    
                    <h4 class="modal-title">Đồng ý xóa?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <input type="hidden" name="iddelete" id="iddelete">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="ClickDelete()">Đồng ý</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




@stop
