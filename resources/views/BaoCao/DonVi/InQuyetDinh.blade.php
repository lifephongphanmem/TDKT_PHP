@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script')

@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <script src="/assets/plugins/custom/ckeditor/ckeditor-document.bundle.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="/assets/js/pages/crud/forms/editors/ckeditor-document.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->

    <!-- END PAGE LEVEL PLUGINS -->

@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">In quyết định</h3>
            </div>
            <div class="card-toolbar">
                <button onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
            </div>
        </div>
        {!! Form::model($model, ['method' => 'POST', 'url' => '/KhenThuongHoSoThiDua/InQuyetDinh', 'class' => 'form', 'id' => 'frm_KhenThuong', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('mahosokt', null) }}
        {{ Form::hidden('thongtinquyetdinh', null) }}
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Decoupled Document Demo</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt-ckeditor-1-toolbar"></div>
                        <div id="kt-ckeditor-1">
                            {!! html_entity_decode($model->thongtinquyetdinh) !!}                            
                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/KhenThuongHoSoThiDua/ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    {{-- <button onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành123</button> --}}
                    {{-- <button type="submit" onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button> --}}
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {!! Form::close() !!}
    <script>
        function setGiaTri() {            

            
                //var myHTML = myEditor.getdata;
           
            alert(myEditor.getData());
            document.getElementById("thongtinquyetdinh").value = '123';

        }
    </script>
@stop
