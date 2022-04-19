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
            $('#frm_modify').find("[name='mahinhthuckt']").attr('readonly',true);
            $('#frm_modify').find("[name='mahinhthuckt']").val(null);
        }

        function edit(mahinhthuckt, tenhinhthuckt){
            $('#frm_modify').find("[name='mahinhthuckt']").attr('readonly',false);
            $('#frm_modify').find("[name='mahinhthuckt']").val(mahinhthuckt);
            $('#frm_modify').find("[name='tenhinhthuckt']").val(tenhinhthuckt);
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh mục hình thức khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dmhinhthuckhenthuong', 'modify'))
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
                                <th width="5%">STT</th>
                                <th width="25%">Phân loại khen thưởng</th>
                                <th>Tên hình thức khen thưởng</th>
                                <th width="15%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{$a_phanloai[$ct->phanloai] ?? '' }}</td>
                                    <td>{{ $ct->tenhinhthuckt }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dmhinhthuckhenthuong', 'modify'))
                                            <button type="button" title="Chỉnh sửa"
                                                onclick="edit('{{ $ct->mahinhthuckt }}','{{ $ct->tenhinhthuckt }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-success"></i></button>

                                            <button title="Xóa thông tin" type="button"
                                                onclick="confirmDelete('{{ $ct->id }}','{{ '/HinhThucKhenThuong/Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash-alt text-danger"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <!--Modal thông tin chi tiết -->
    {!! Form::open(['url' => '/HinhThucKhenThuong/Them', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin hình thức khen thưởng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('mahinhthuckt', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Tên hình thức khen thưởng<span
                                        class="require">*</span></label>
                                {!! Form::text('tenhinhthuckt', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Phân loại</label>
                                {!! Form::select('phanloai', $a_phanloai, null, ['class' => 'form-control select2_modal']) !!}
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
    @include('includes.modal.modal-delete')
@stop
