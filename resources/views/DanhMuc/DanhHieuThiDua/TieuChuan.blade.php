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
            $('#madanhhieutd').change(function() {
                window.location.href = '/DanhHieuThiDua/TieuChuan?madanhhieutd=' + $('#madanhhieutd').val();
            });
        }); 
        
        function edit(madanhhieutd, matieuchuandhtd ,tentieuchuandhtd, cancu){
            $('#frm_modify').find("[name='madanhhieutd']").attr('readonly',false);
            $('#frm_modify').find("[name='madanhhieutd']").val(madanhhieutd);
            $('#frm_modify').find("[name='matieuchuandhtd']").val(matieuchuandhtd);
            $('#frm_modify').find("[name='tentieuchuandhtd']").val(tentieuchuandhtd);
            $('#frm_modify').find("[name='cancu']").val(cancu);
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">danh sách tiêu chuẩn thi đua - {{$m_danhhieu->tendanhhieutd}}</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dmdanhhieuthidua', 'modify'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#modify-modal"
                        data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Địa bàn</label>
                    {!! Form::select('madanhhieutd', $a_danhhieu, $m_danhhieu->madanhhieutd, ['id' => 'madanhhieutd', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên tiêu chuẩn</th>
                                <th width="30%">Căn cứ</th>
                                <th width="10%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td style="text-align: center">{{ $i++ }}</td>
                                    <td>{{ $ct->tentieuchuandhtd }}</td>
                                    <td>{{ $ct->cancu }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dmdanhhieuthidua', 'modify'))
                                            <button type="button" title="Chỉnh sửa"
                                                onclick="edit('{{ $ct->madanhhieutd }}', '{{ $ct->matieuchuandhtd }}','{{ $ct->tentieuchuandhtd }}','{{ $ct->cancu }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-success"></i></button>

                                            <button title="Xóa thông tin" type="button"
                                                onclick="confirmDelete('{{ $ct->id }}','/DanhHieuThiDua/Xoa')"
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
    {!! Form::open(['url' => 'DanhHieuThiDua/Them', 'id' => 'frm_modify']) !!}
    <input type="hidden" name="madanhhieutd" value="{{$m_danhhieu->madanhhieutd}}" />
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
                                <label>Mã số</label>
                                {!! Form::text('matieuchuandhtd', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label>Tên tiêu chuẩn<span
                                        class="require">*</span></label>
                                {!! Form::textarea('tentieuchuandhtd', null, ['class' => 'form-control', 'required' => 'required', 'rows'=>'2']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label>Căn cứ</label>
                                {!! Form::textarea('cancu', null, ['class' => 'form-control', 'rows'=>'2']) !!}
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
