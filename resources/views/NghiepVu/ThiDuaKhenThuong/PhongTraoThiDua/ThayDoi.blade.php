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

        function ThemKhenThuong(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/PhongTraoThiDua/ThemKhenThuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    soluong: $('#soluong').val(),
                    madanhhieutd: $('#madanhhieutd').val(),
                    mahinhthuckt: $('#mahinhthuckt').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function (data) {
                    if(data.status == 'success') {
                        toastr.success("Bổ xung thông tin thành công!");
                        $('#dskhenthuong').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });
                        $('#modal-create').modal("hide");

                    }
                }
            })
        }

        function ThemTieuChuan(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var batbuoc = 0;
            if($('#batbuoc').checked)
                batbuoc = 1;
            $.ajax({
                url: '/PhongTraoThiDua/ThemTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    batbuoc: batbuoc,
                    madanhhieutd: $('#madanhhieutd').val(),
                    matieuchuandhtd: $('#matieuchuandhtd').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function (data) {
                    if(data.status == 'success') {
                        toastr.success("Bổ xung thông tin thành công!");
                        $('#dstieuchuan').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                        $('#modal-TieuChuan').modal("hide");

                    }
                }
            })
        }

        function getTieuChuan(madanhhieutd){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#madanhhieutd_tc').val(madanhhieutd).trigger('change');

            $.ajax({
                url: '/PhongTraoThiDua/LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madanhhieutd: madanhhieutd,
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function (data) {
                    if(data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
        }

        function getId(id){
            document.getElementById("iddelete").value=id;
        }
        function deleteRow() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/dangkytddf/delete',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: $('#iddelete').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function (data) {
                    //if(data.status == 'success') {
                    toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                    $('#dsdt').replaceWith(data.message);
                    jQuery(document).ready(function() {
                        TableManaged.init();
                    });

                    $('#modal-delete').modal("hide");

                    //}
                }
            })

        }
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin chi tiết phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['method' => 'POST', '/PhongTraoThiDua/Them', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('madonvi', null) }}
        {{ Form::hidden('maphongtraotd', null) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Phạm vị phát động</label>
                    {!! Form::select('phamviapdung', getPhamViPhongTrao(), null, ['class' => 'form-control select2basic']) !!}
                </div>

                <div class="col-lg-6">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Số quyết định<span class="require">*</span></label>
                    {!! Form::text('soqd', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Ngày ra quyết định<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayqd', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Ngày nhận hồ sơ<span class="require">*</span></label>
                    {!! Form::input('date', 'tungay', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Ngày kết thúc<span class="require">*</span></label>
                    {!! Form::input('date', 'denngay', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Nội dung phong trào</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tờ trình: </label>
                    {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                    @if ($model->totrinh != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/totrinh/' . $model->totrinh) }}"
                                target="_blank">{{ $model->totrinh }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Quyết định khen thưởng: </label>
                    {!! Form::file('qdkt', null, ['id' => 'qdkt', 'class' => 'form-control']) !!}
                    @if ($model->qdkt != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/qdkt/' . $model->qdkt) }}" target="_blank">{{ $model->qdkt }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Biên bản: </label>
                    {!! Form::file('bienban', null, ['id' => 'bienban', 'class' => 'form-control']) !!}
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Tài liệu khác: </label>
                    {!! Form::file('tailieukhac', null, ['id' => 'tailieukhac', 'class' => 'form-control']) !!}
                    @if ($model->tailieukhac != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                target="_blank">{{ $model->tailieukhac }}</a>
                        </span>
                    @endif
                </div>
            </div>
            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách khen thưởng</h4>

            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="button" data-target="#modal-create" data-toggle="modal" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i>&nbsp;Thêm</button>
                </div>
            </div>

            <div class="form-group row" id="dskhenthuong">
                <div class="col-lg-12">
                    <table id="sample_3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center" width="5%">STT</th>
                                <th style="text-align: center" width="25%">Phân loại</th>
                                <th style="text-align: center">Tên danh hiệu</th>
                                <th style="text-align: center">Hình thức khen thưởng</th>
                                <th style="text-align: center" width="8%">Số lượng</th>
                                <th style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_khenthuong as $key => $tt)
                                <tr class="odd gradeX">
                                    <td style="text-align: center">{{ $i++ }}</td>
                                    <td>{{ $tt->phanloai }}</td>
                                    <td>{{ $tt->tendanhhieutd }}</td>
                                    <td>{{ ($a_hinhthuckt[$tt->mahinhthuckt] ?? '') }}</td>
                                    <td style="text-align: center">{{ $tt->soluong }}</td>
                                    <td>
                                        <button title="Tiêu chuẩn" type="button"
                                            onclick="getTieuChuan('{{ $tt->madanhhieutd }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-list text-dark"></i></button>
                                        <button title="Xóa" type="button" onclick="getId('{{ $tt->id }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash-alt text-danger"></i></button>
                                    </td>
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
                    <a href="{{ url('/PhongTraoThiDua/ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>


    {!! Form::open(['url'=>'','files'=>true, 'id' => 'frmThemKhenThuong', 'class'=>'horizontal-form']) !!}
    <div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">                    
                    <h4 class="modal-title">Thêm mới thông tin danh hiệu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" id="ttpthemmoi">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="control-label">Tên danh hiệu thi đua<span class="require">*</span></label>
                                {!!Form::select('madanhhieutd', $a_danhhieu ,null, array('id' => 'madanhhieutd','class' => 'form-control'))!!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Số lượng</label>
                                {!!Form::text('soluong',null, array('id' => 'soluong','class' => 'form-control'))!!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Hình thức khen thưởng</label>
                                {!!Form::select('mahinhthuckt', $a_hinhthuckt ,null, array('id' => 'mahinhthuckt','class' => 'form-control'))!!}
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="ThemKhenThuong()">Hoàn thành</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url'=>'','files'=>true, 'id' => 'frmThemTieuChuan', 'class'=>'horizontal-form']) !!}
    <div class="modal fade bs-modal-lg" id="modal-TieuChuan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới tiêu chuẩn cho danh hiệu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>                    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Tên danh hiệu thi đua<span class="require">*</span></label>
                                {!!Form::select('madanhhieutd', $a_danhhieu ,null, array('id' => 'madanhhieutd','class' => 'form-control'))!!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Tiêu chuẩn</label>
                                {!!Form::select('matieuchuandhtd',$a_tieuchuan ,null, array('id' => 'matieuchuandhtd','class' => 'form-control'))!!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-offset-4 col-md-3">
                            <div class="md-checkbox">
                                <input type="checkbox" id="batbuoc" name="batbuoc" class="md-check">
                                <label for="batbuoc">
                                    <span></span><span class="check"></span><span class="box"></span>Tiêu chuẩn bắt buộc</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="ThemTieuChuan()">Cập nhật</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {{--    Thông tin tiêu chuẩn--}}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Thông tin tiêu chuẩn của đối tượng</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Danh hiệu đăng ký</label>
                            {!!Form::select('madanhhieutd_tc', $a_danhhieu ,null, array('id' => 'madanhhieutd_tc','class' => 'form-control'))!!}
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="dstieuchuan">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--end::Card-->
@stop
