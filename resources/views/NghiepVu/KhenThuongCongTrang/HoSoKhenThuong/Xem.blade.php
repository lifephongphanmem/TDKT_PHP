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
            TableManaged4.init();
        });

        function getTieuChuan(madoituong, madanhhieutd, tendt) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#madoituong_tc').val(madoituong);
            $('#tendoituong_tc').val(tendt);
            $('#madanhhieutd_tc').val(madanhhieutd).trigger('change');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: madoituong,
                    madanhhieutd: madanhhieutd,
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
        }

        function ThayDoiTieuChuan(matieuchuandhtd, tentieuchuandhtd) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#tentieuchuandhtd_ltc').val(tentieuchuandhtd);
            $('#matieuchuandhtd_ltc').val(matieuchuandhtd);
        }

        function LuuTieuChuan() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LuuTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: $('#madoituong_tc').val(),
                    madanhhieutd: $('#madanhhieutd_tc').val(),
                    matieuchuandhtd: $('#matieuchuandhtd_ltc').val(),
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
            $('#modal-luutieuchuan').modal("hide");
        }

        function delKhenThuong(id, phanloai) {
            document.getElementById("iddelete").value = id;
            document.getElementById("phanloaixoa").value = phanloai;
        }

        function deleteRow() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/XoaDoiTuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: $('#iddelete').val(),
                    phanloai: $('#phanloaixoa').val(),
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {

                    toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                    if ($('#phanloaixoa').val() == 'CANHAN') {
                        $('#dskhenthuong').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });
                    } else {
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                    }
                    $('#modal-delete-khenthuong').modal("hide");
                }
            })

        }

        function setCaNhan() {
            $('#frm_ThemCaNhan').find("[name='madoituong']").val('NULL');
        }

        function setTapThe() {
            $('#frm_ThemTapThe').find("[name='matapthe']").val('NULL');
        }

        function getCaNhan(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayDoiTuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemCaNhan');
                    form.find("[name='madoituong']").val(data.madoituong);
                    form.find("[name='tendoituong']").val(data.tendoituong);
                    form.find("[name='ngaysinh']").val(data.ngaysinh);
                    form.find("[name='gioitinh']").val(data.gioitinh).trigger('change');;
                    form.find("[name='chucvu']").val(data.chucvu);
                    form.find("[name='maccvc']").val(data.maccvc);
                    form.find("[name='lanhdao']").val(data.lanhdao).trigger('change');
                    form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');;
                    form.find("[name='tensangkien']").val(data.tensangkien);
                    form.find("[name='donvicongnhan']").val(data.donvicongnhan);
                    form.find("[name='thoigiancongnhan']").val(data.thoigiancongnhan);
                    form.find("[name='thanhtichdatduoc']").val(data.thanhtichdatduoc);
                    if(data.filedk != ''){
                        document.getElementById('filedk_canhan').style.visibility = "visible";
                        $('#filedk_canhan').attr("href", "/data/sangkien/" + data.filedk);
                    }
                    else
                    document.getElementById('filedk_canhan').style.visibility = "hidden";
                    
                    //filedk: form.find("[name='filedk']").val(data.madoituong),
                }
            })
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayDoiTuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='matapthe']").val(data.matapthe);
                    form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='tentapthe']").val(data.tentapthe);
                    //filedk: form.find("[name='filedk']").val(data.madoituong),
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
                <h3 class="card-label text-uppercase">Thông tin hồ sơ đề nghị khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['method' => 'POST', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosotdkt', null, ['id' => 'mahosotdkt']) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Tên đơn vị</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Ngày tạo hồ sơ<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Báo cáo thành tích: </label>
                    @if ($model->baocao != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/baocao/' . $model->baocao) }}"
                                target="_blank">{{ $model->baocao }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Biên bản cuộc họp: </label>
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tài liệu khác: </label>
                    @if ($model->tailieukhac != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                target="_blank">{{ $model->tailieukhac }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách khen thưởng cá nhân</h4>          
            <div class="row" id="dskhenthuong">
                <div class="col-md-12">
                    <table id="sample_3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Tên đối tượng</th>
                                <th width="10%">Ngày sinh</th>
                                <th>Giới</br>tính</th>
                                <th>Chức vụ</th>
                                <th>Tên danh hiệu<br>đăng ký</th>
                                <th>Hình thức<br>khen thưởng</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_canhan as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $tt->tendoituong }}</td>
                                    <td>{{ getDayVn($tt->ngaysinh) }}</td>
                                    <td>{{ $tt->gioitinh }}</td>
                                    <td class="text-center">{{ $tt->chucvu }}</td>
                                    <td class="text-center">{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                    <td class="text-center">{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                    <td class="text-center">
                                        <button title="Tiêu chuẩn" type="button"
                                            onclick="getTieuChuan('{{ $tt->madoituong }}','{{ $tt->madanhhieutd }}','{{ $tt->tendoituong }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-list text-primary"></i></button>

                                        <button title="Sửa thông tin" type="button"
                                            onclick="getCaNhan('{{ $tt->id }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-create"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-edit text-primary"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách khen thưởng tập thể</h4>
            <div class="row" id="dskhenthuongtapthe">
                <div class="col-md-12">
                    <table id="sample_4" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên đối tượng</th>
                                <th width="20%">Tên danh hiệu<br>đăng ký</th>
                                <th>Hình thức<br>khen thưởng</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_tapthe as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $tt->tentapthe }}</td>
                                    <td class="text-center">{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                    <td class="text-center">{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                    <td class="text-center">
                                        <button title="Tiêu chuẩn" type="button"
                                            onclick="getTieuChuan('{{ $tt->matapthe }}','{{ $tt->madanhhieutd }}','{{ $tt->tentapthe }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-list text-primary"></i></button>

                                        <button title="Sửa thông tin" type="button"
                                            onclick="getTapThe('{{ $tt->id }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-create-tapthe"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-edit text-primary"></i></button>
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
                
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

    {{-- Cá nhân --}}
    {!! Form::open(['url' => '', 'id' => 'frm_ThemCaNhan', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="madoituong" id="madoituong" />
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" id="ttpthemmoi">
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-1">
                            <label class="control-label">Chọn</label>
                            <button type="button" class="btn btn-default" data-target="#modal-doituong" data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label">Ngày sinh</label>
                            {!! Form::input('date', 'ngaysinh', null, ['id' => 'ngaysinh', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Giới tính</label>
                            {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">Chức vụ/Chức danh</label>
                            {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                        </div>
                    
                        <div class="col-md-4">
                            <label class="form-control-label">Lãnh đạo đơn vị</label>
                            {!! Form::select('lanhdao', ['0' => 'Không', '1' => 'Có'], null, ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">Mã CCVC</label>
                            {!! Form::text('maccvc', null, ['id' => 'maccvc', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Đăng ký danh hiệu thi đua</label>
                            <select id="madanhhieutd" name="madanhhieutd" class="form-control">
                                @foreach ($m_danhhieu->where('phanloai', 'CANHAN') as $nhom)
                                    <option value="{{ $nhom->madanhhieutd }}">{{ $nhom->tendanhhieutd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Hình thức khen thưởng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Tên đề tài, sáng kiến</label>
                            {!! Form::text('tensangkien', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8">
                            <label class="form-control-label">Đơn vị công nhận</label>
                            {!! Form::text('donvicongnhan', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Ngày công nhận</label>
                            {!! Form::input('date', 'thoigiancongnhan', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Thành tích đạt được</label>
                            {!! Form::textarea('thanhtichdatduoc', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tài liệu đính kèm: </label>
                            {!! Form::file('filedk', null, ['id' => 'filedk', 'class' => 'form-control']) !!}                            
                                <span class="form-control" style="border-style: none;visibility: hidden;">
                                    <a id="filedk_canhan" href="" target="_blank">Tải file</a>
                                </span>                            
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- tập thể --}}
    {!! Form::open(['url' => '', 'id' => 'frm_ThemTapThe', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="matapthe" />
    <div class="modal fade bs-modal-lg" id="modal-create-tapthe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Tên tập thể</label>
                            {!! Form::text('tentapthe', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Đăng ký danh hiệu thi đua</label>
                            <select name="madanhhieutd" class="form-control">
                                @foreach ($m_danhhieu->where('phanloai', 'TAPTHE') as $nhom)
                                    <option value="{{ $nhom->madanhhieutd }}">{{ $nhom->tendanhhieutd }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Hình thức khen thưởng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Thông tin tiêu chuẩn --}}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <input type="hidden" id="madoituong_tc" name="madoituong_tc" />
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin tiêu chuẩn của đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong_tc', null, ['id' => 'tendoituong_tc', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label">Danh hiệu đăng ký</label>
                            {!! Form::select('madanhhieutd_tc', $a_danhhieu, null, ['id' => 'madanhhieutd_tc', 'class' => 'form-control']) !!}
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

    {{-- Thong tin đối tượng --}}
    <div id="modal-doituong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Thay đổi tiêu chuẩn --}}
    <div id="modal-luutieuchuan" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <input type="hidden" id="matieuchuandhtd_ltc" name="matieuchuandhtd_ltc" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Tên tiêu chuẩn</label>
                                {!! Form::textarea('tentieuchuandhtd_ltc', null, ['id' => 'tentieuchuandhtd_ltc', 'class' => 'form-control', 'rows' => '3']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-3">
                                <div class="md-checkbox">
                                    <input type="checkbox" id="dieukien_ltc" name="dieukien_ltc" class="md-check">
                                    <label for="dieukien_ltc">
                                        <span></span><span class="check"></span><span
                                            class="box"></span>Đủ điều kiện</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTieuChuan()">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Xóa khen thưởng ca nhân --}}
    <div class="modal fade" id="modal-delete-khenthuong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa thông tin đối tượng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" id="iddelete" name="iddelete">
                <input type="hidden" id="phanloaixoa" name="phanloaixoa">
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="deleteRow()">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        function adddvt() {
            $('#modal-doituong').modal('hide');
        }
    </script>
@stop
