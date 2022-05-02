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
        function getTieuChuan(id, madanhhieutd, tendt) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');            
            $('#tendoituong_tc').val(tendt);
            $('#madanhhieutd_tc').val(madanhhieutd).trigger('change');

            $.ajax({
                url: '/KhenThuongCongTrang/QuyetDinhKhenThuong/LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
        }

        function setCaNhan() {
            $('#frm_ThemCaNhan').find("[name='madoituong']").val('NULL');
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
                    form.find("[name='matapthe']").val(data.matapthe).trigger('change');
                    form.find("[name='madanhhieutd_kt']").val(data.madanhhieutd).trigger('change');
                    //filedk: form.find("[name='filedk']").val(data.madoituong),
                }
            })
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::model($model, ['method' => 'POST','url'=>'', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {{ Form::hidden('mahosokt', null) }}
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin hồ sơ khen thưởng</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        
        <div class="card-body">
            <h4 class="form-section" style="color: #0000ff">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-lg-9">
                    <label>Đơn vị khen thưởng</label>
                    {!! Form::text('donvikhenthuong', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('capkhenthuong', getPhamViApDung(), null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Nôi dung khen thưởng</label>
                    {!! Form::textarea('noidung', $model->noidung, ['class' => 'form-control text-bold', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Số quyết định</label>
                    {!! Form::text('soquyetdinh', $model->soquyetdinh, ['class' => 'form-control text-bold']) !!}
                </div>
                <div class="col-md-6">
                    <label style="font-weight: bold">Ngày quyết định</label>
                    {!! Form::input('date', 'ngayhoso', $model->ngayhoso, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Chức vụ người ký</label>
                    {!! Form::text('chucvunguoiky', $model->chucvunguoiky, ['class' => 'form-control text-bold']) !!}
                </div>
                <div class="col-md-6">
                    <label style="font-weight: bold">Họ tên người ký</label>
                    {!! Form::text('hotennguoiky', $model->hotennguoiky, ['class' => 'form-control text-bold']) !!}
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách hồ sơ đề nghị</h4>
            <div class="form-group row">                
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th>Tên đơn vị đăng ký</th>
                                <th width="10%">Khen thưởng</th>
                                <th style="text-align: center" width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($m_chitiet as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>
                                @if ($tt->ketqua == 0)
                                    <td class="text-center"></td>
                                @else
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check text-success"></i></button>
                                    </td>
                                @endif
                                <td style="text-align: center">
                                    
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo cá nhân</h4>
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên đơn vị đăng ký</th>
                                <th>Tên đối tượng</th>
                                <th>Tên danh hiệu</th>
                                <th width="5%">Số chỉ<br>tiêu</th>
                                <th width="5%">Đạt tiêu<br>chuẩn</th>
                                <th width="15%">Hình thức<br>khen thưởng</th>
                                <th style="text-align: center" width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model_canhan as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>
                                <td>{{ $tt->tendoituong }}</td>
                                <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                <td style="text-align: center">{{ $tt->tongdieukien . '/' . $tt->tongtieuchuan }}</td>
                                @if ($tt->ketqua == 0)
                                    <td class="text-center"></td>
                                @else
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check text-success"></i></button>
                                    </td>
                                @endif
                                <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                <td class="text-center">
                                    <button title="Xem thông tin" type="button"
                                        onclick="getCaNhan('{{ $tt->id }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#modal-canhan"
                                        data-toggle="modal">
                                        <i class="icon-lg la fa-eye text-dark"></i></button>
                                    <button title="Danh sách tiêu chuẩn" type="button"
                                        onclick="getTieuChuan('{{ $tt->id }}','{{ $tt->madanhhieutd }}','{{ $tt->tendoituong }}')" class="btn btn-sm btn-clean btn-icon"
                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                        <i class="icon-lg la fa-list text-dark"></i></button>
                                    <a title="In kết quả" href="{{ url('/KhenThuongCongTrang/QuyetDinhKhenThuong/InKetQua?id=' . $tt->id) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-print text-dark"></i></a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="form-group row">
                <h4 class="form-section" style="color: #0000ff">Danh sách khen thưởng theo tập thể</h4>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên đơn vị đăng ký</th>
                                <th>Tên danh hiệu</th>
                                <th width="5%">Số chỉ<br>tiêu</th>
                                <th width="5%">Đạt tiêu<br>chuẩn</th>
                                <th width="15%">Hình thức<br>khen thưởng</th>
                                <th style="text-align: center" width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model_tapthe as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td>{{ $tt->tentapthe }}</td>
                                <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                <td class="text-center">{{ $tt->tongdieukien . '/' . $tt->tongtieuchuan }}</td>
                                @if ($tt->ketqua == 0)
                                    <td class="text-center"></td>
                                @else
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check text-success"></i></button>
                                    </td>
                                @endif
                                <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                <td style="text-align: center">
                                    <button title="Danh sách tiêu chuẩn" type="button"
                                        onclick="getTieuChuan('{{ $tt->id }}','{{ $tt->madanhhieutd }}','{{ $tt->tentapthe }}')" class="btn btn-sm btn-clean btn-icon"
                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                        <i class="icon-lg la fa-eye text-dark"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <h4 class="form-section" style="color: #0000ff">Danh sách tài liệu kèm theo</h4>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tờ trình: </label>
                    @if ($model->totrinh != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/totrinh/' . $model->totrinh) }}"
                                target="_blank">{{ $model->totrinh }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Quyết định khen thưởng: </label>
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
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>
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
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->
    {{-- Hồ sơ  --}}
    <div id="modal-hoso" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => '/KhenThuongCongTrang/QuyetDinhKhenThuong/HoSo', 'id' => 'frm_hoso']) !!}
        <input type="hidden" name="mahosokt" />
        <input type="hidden" name="mahosotdkt" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin hồ sơ thi đua</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đơn vị quyết định khen thưởng</label>
                            {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Khen thưởng</label>
                            {!! Form::select('khenthuong', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], 'T', ['class' => 'form-control']) !!}
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickHoSo()">Đồng ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    {{-- Kết quả --}}
    {!! Form::open(['url' => '/KhenThuongCongTrang/QuyetDinhKhenThuong/KetQua', 'id' => 'frm_KetQua', 'method' => 'post']) !!}
    <div id="modal-ketqua" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <input type="hidden" name="id" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đối tượng</label>
                            {!! Form::textarea('tendoituong', null, ['class' => 'form-control', 'rows' => '2']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đối tượng</label>
                            <div class="checkbox-inline">
                                <div class="col-lg-12">
                                    <label class="checkbox checkbox-rounded">
                                        <input type="checkbox" checked="checked" name="dieukien">
                                        <span></span>Đạt điều kiện khen thưởng</label>
                                </div>                                
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-control-label">Hình thức khen thưởng</label>
                                {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" value="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    
    {{-- Cá nhân --}}
    {!! Form::open(['url' => '', 'id' => 'frm_ThemCaNhan', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="madoituong" id="madoituong" />
    <div class="modal fade bs-modal-lg" id="modal-canhan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" id="ttpthemmoi">
                    <div class="form-group row">
                        <div class="col-lg-11">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-1">
                            <label class="control-label">Chọn</label>
                            <button type="button" class="btn btn-default" data-target="#modal-doituong" data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">Ngày sinh</label>
                            {!! Form::input('date', 'ngaysinh', null, ['id' => 'ngaysinh', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Giới tính</label>
                            {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Chức vụ/Chức danh</label>
                            {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">Lãnh đạo đơn vị</label>
                            {!! Form::select('lanhdao', ['0' => 'Không', '1' => 'Có'], null, ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">Mã CCVC</label>
                            {!! Form::text('maccvc', null, ['id' => 'maccvc', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="control-label">Đăng ký danh hiệu thi đua</label>
                            <select id="madanhhieutd" name="madanhhieutd" class="form-control js-example-basic-single">
                                @foreach ($m_danhhieu->where('phanloai', 'CANHAN') as $nhom)
                                    <option value="{{ $nhom->madanhhieutd }}">{{ $nhom->tendanhhieutd }}</option>
                                @endforeach
                            </select>
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
                            {{-- @if ($model->tailieukhac != '')
                                <span class="form-control" style="border-style: none">
                                    <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                        target="_blank">{{ $model->tailieukhac }}</a>
                                </span>
                            @endif --}}
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
    </div>
    {!! Form::close() !!}

    {{-- tập thể --}}
    {!! Form::open(['url' => '', 'id' => 'frm_ThemTapThe', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <div class="modal fade bs-modal-lg" id="modal-tapthe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="font-weight: bold">Đơn vị</label>
                                <select class="form-control select2me" name="matapthe" id="matapthe">
                                    @foreach ($m_diaban as $diaban)
                                        <optgroup label="{{ $diaban->tendiaban }}">
                                            <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                                            @foreach ($donvi as $ct)
                                                <option value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Đăng ký danh hiệu thi đua</label>
                                <select id="madanhhieutd_kt" name="madanhhieutd_kt"
                                    class="form-control js-example-basic-single">
                                    @foreach ($m_danhhieu->where('phanloai', 'TAPTHE') as $nhom)
                                        <option value="{{ $nhom->madanhhieutd }}">{{ $nhom->tendanhhieutd }}</option>
                                    @endforeach
                                </select>
                            </div>
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
    </div>
    {!! Form::close() !!}

    {{-- Thông tin tiêu chuẩn --}}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <input type="hidden" id="madoituong_tc" name="madoituong_tc" />
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


    <script>
        function setKetQua(id, tendt, mahinhthuckt) {
            $('#frm_KetQua').find("[name='id']").val(id);
            $('#frm_KetQua').find("[name='tendoituong']").val(tendt);
            $('#frm_KetQua').find("[name='mahinhthuckt']").val(mahinhthuckt).trigger('change');
        }

        function clickHoSo() {
            $('#frm_hoso').submit();
        }

        function getHoSo(mahosokt, tendonvi, mahosotdkt) {
            $('#frm_hoso').find("[name='mahosokt']").val(mahosokt);
            $('#frm_hoso').find("[name='tendonvi']").val(tendonvi);
            $('#frm_hoso').find("[name='mahosotdkt']").val(mahosotdkt);
        }
    </script>

@stop
