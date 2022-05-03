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
            TableManagedclass.init();
        });        

        
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin kết quả tìm kiếm</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['url' => '', 'class' => 'form', 'id' => 'frm_ThayDoi']) !!}
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-10">Danh sách danh hiệu thi đua</h4>
            <div class="form-group row">                
                <div class="col-lg-12">
                    <label>Tên đơn vị</label>
                    {!! Form::text('tentapthe', null, ['class' => 'form-control']) !!}
                </div>
            </div> 

            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách danh hiệu thi đua</h4>
            
            <div class="row" id="dskhenthuong">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>                               
                                <th>Tên danh hiệu thi đua</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($khenthuong as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>                                  
                                    <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách khen thưởng</h4>

            <div class="row" id="dskhenthuongtapthe">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th>Hình thức khen thưởng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($khenthuong as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách đề tài, sáng kiến</h4>

            <div class="row" id="dskhenthuongtapthe">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th>Tên đề tài, sang kiến</th>
                                <th>Thành tích đạt được</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($detai as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $tt->tensangkien}}</td>
                                    <td>{{ $tt->thanhtichdatduoc}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/TraCuu/CaNhan/ThongTin') }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->
@stop
