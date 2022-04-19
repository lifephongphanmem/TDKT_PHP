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
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">danh sách&nbsp;đơn vị - {{$inputs['tendiaban']}}</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsdonvi', 'modify'))
                    <a href="{{url('DonVi/Them?madiaban='.$inputs['madiaban'])}}" class="btn btn-info btn-sm">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Địa bàn</label>
                    {!! Form::select('madiaban', getDiaBan_All(), $inputs['madiaban'], ['id' => 'madiaban', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover table-responsive" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th width="75%">Tên đơn vị</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($model as $key=>$tt)
                            <tr class="odd gradeX">
                                <td class="text-center">{{$key + 1}}</td>
                                <td class="active">{{$tt->tendonvi}}</td>
                                <td class="text-center">
                                    <a title="Sửa thông tin" href="{{url('/DonVi/Sua?madonvi='.$tt->madonvi)}}" class="btn btn-sm btn-clean btn-icon">
                                        <i class="icon-lg la fa-edit text-primary"></i></a>

                                    <button title="Xóa thông tin" type="button" onclick="confirmDelete('{{$tt->id}}','{{$inputs['url'].'/Xoa'}}')" class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm" data-toggle="modal">
                                        <i class="icon-lg la fa-trash-alt text-danger"></i></button>
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
    @include('includes.modal.modal-delete')
@stop
