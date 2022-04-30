@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    <script src="/assets/plugins/custom/ckeditor/ckeditor.js"></script>
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    <script src="/assets/js/pages/table-lifesc.js"></script>

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
    {!! Form::model($model, ['method' => 'POST','url' => '/KhenThuongHoSoThiDua/InQuyetDinh', 'class' => 'form', 'id' => 'frm_KhenThuong', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {{ Form::hidden('mahosokt', null) }}
    {{ Form::hidden('thongtinquyetdinh', null) }}
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">In quyết định123</h3>
            </div>
            <div class="card-toolbar"></div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <div id="kt-ckeditor-1-toolbar"></div>
                    {{-- <textarea name="thongtinquyetdinh" id="thongtinquyetdinh" rows="20" cols="150"> --}}
                        <div id="kt-ckeditor-1">
                            <p><br></p><table class="table table-bordered">
                            <tbody><tr><td>Chương trình</td><td>Tiểu đề</td></tr></tbody></table><p><br></p>
                        </div>
                    {{-- </textarea>                     --}}
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/KhenThuongHoSoThiDua/ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành123</button>
                    <button type="submit" onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {!! Form::close() !!}
    <script>
        function setGiaTri(){
            var myHTML = document.getElementById('kt-ckeditor-1').innerHTML;
            alert(myHTML);
            document.getElementById("thongtinquyetdinh").value = 123;
            
        }
        </script>
@stop
