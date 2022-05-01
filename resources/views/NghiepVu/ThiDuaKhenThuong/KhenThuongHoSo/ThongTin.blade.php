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
            $('#madonvi').change(function() {
                window.location.href = '/KhenThuongHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
            $('#nam').change(function() {
                window.location.href = '/KhenThuongHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách phong trào thi đua chờ xét khen thưởng trên địa bàn</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($m_diaban as $diaban)
                            <optgroup label="{{ $diaban->tendiaban }}">
                                <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" width="2%">STT</th>
                                <th rowspan="2">Đơn vị phát động</th>
                                <th rowspan="2">Nội dung hồ sơ</th>
                                <th colspan="5">Phong trào</th>
                                <th rowspan="2" style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                            <tr class="text-center">

                                <th width="8%">Ngày<br>bắt đầu</th>
                                <th width="8%">Ngày<br>kết thúc</th>
                                <th width="8%">Trạng thái</th>
                                <th width="5%">Số<br>hồ sơ</th>
                                <th width="15%">Pham vị phát động</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $tt->tendonvi }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ getDayVn($tt->tungay) }}</td>
                                <td>{{ getDayVn($tt->denngay) }}</td>
                                @include('includes.td.td_trangthai_phongtrao')
                                <td style="text-align: center">{{ chkDbl($tt->sohoso) }}</td>
                                <td>{{ $a_phamvi[$tt->phamviapdung] ?? '' }}</td>

                                <td style="text-align: center">
                                    <a title="Thông tin phong trào"
                                        href="{{ url('/PhongTraoThiDua/Xem?maphongtraotd=' . $tt->maphongtraotd) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark"></i></a>

                                    <a title="Danh sách hồ sơ chi tiết"
                                        href="{{ url('/XetDuyetHoSoThiDua/Xem?maphongtraotd=' . $tt->maphongtraotd . '&madonvi=' . $inputs['madonvi']) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la la-clipboard-list text-dark"></i></a>
                                    @if ($tt->nhanhoso == 'DANGNHAN')
                                        <button title="Kết thúc phong trào" type="button"
                                            onclick="setKetQua('{{ $tt->maphongtraotd }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-KetThuc"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-check text-warning"></i></button>
                                    @else
                                        @if ($tt->mahosokt == '-1')
                                            <button title="Tạo hồ sơ khen thưởng" type="button"
                                                onclick="confirmKhenThuong('{{ $tt->maphongtraotd }}','{{ $inputs['madonvi'] }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#khenthuong-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-user-check text-success"></i></button>
                                        @else
                                            @if ($tt->trangthai == 'DXKT')
                                                <a title="Thông tin hồ sơ khen thưởng"
                                                    href="{{ url('/KhenThuongHoSoThiDua/DanhSach?mahosokt=' . $tt->mahosokt) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg la fa-user-check text-primary"></i></a>

                                                <button title="Phê duyệt hồ sơ khen thưởng" type="button"
                                                    onclick="setPheDuyet('{{ $tt->mahosokt }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modal-PheDuyet"
                                                    data-toggle="modal">
                                                    <i class="icon-lg la fa-check text-success"></i></button>
                                            @else
                                                <a title="Thông tin hồ sơ khen thưởng"
                                                    href="{{ url('/KhenThuongHoSoThiDua/Xem?mahosokt=' . $tt->mahosokt) }}"
                                                    class="btn btn-sm btn-clean btn-icon" target="_blank">
                                                    <i class="icon-lg la fa-user-check text-dark"></i></a>
                                            @endif

                                            <a title="In quyết định khen thưởng"
                                                href="{{ url('/KhenThuongHoSoThiDua/InQuyetDinh?mahosokt=' . $tt->mahosokt) }}"
                                                class="btn btn-sm btn-clean btn-icon" target="_blank">
                                                <i class="icon-lg la fa-print text-dark"></i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <!--Modal tạo dự thảo khen thưởng-->
    <div id="khenthuong-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => '/KhenThuongHoSoThiDua/KhenThuong', 'id' => 'frm_khenthuong']) !!}
        <input type="hidden" name="maphongtraotd" />
        <input type="hidden" name="madonvi" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ khen thưởng?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đơn vị quyết định khen thưởng</label>
                            {!! Form::text('donvikhenthuong', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Cấp độ khen thưởng</label>
                            {!! Form::select('capkhenthuong', getPhamViApDung(), 'T', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Ngày ra quyết định</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Chức vụ người ký</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Họ tên người ký</label>
                            {!! Form::text('hotennguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickKhenThuong()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--Modal kết thúc nhận hồ sơ để khen thưởng-->
    <div class="modal fade" id="modal-KetThuc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => '/XetDuyetHoSoThiDua/KetThuc', 'method' => 'post', 'files' => true, 'id' => 'frm_KetThuc', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                <div class="modal-header">

                    <h4 class="modal-title">Đồng ý kết thúc phong trào và xét khen thưởng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="maphongtraotd" id="maphongtraotd">
                <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Bạn đồng ý kết thúc phong trào thi đua để chuyển sang quá trình xét duyệt khen thưởng.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn blue">Đồng ý</button>
                    <button type="button" class="btn default" data-dismiss="modal">Hủy</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Modal phê duyệt hồ sơ khen thưởng-->
    <div class="modal fade" id="modal-PheDuyet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => '/KhenThuongHoSoThiDua/PheDuyet', 'method' => 'post', 'files' => true, 'id' => 'frm_PheDuyet', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                <div class="modal-header">

                    <h4 class="modal-title">Đồng ý phê duyệt hồ sơ khen thưởng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="mahosokt" id="mahosokt">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Bạn đồng ý phê duyệt hồ sơ khen thưởng và gửi kết quả đến các đơn vị tham gia.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn blue">Đồng ý</button>
                    <button type="button" class="btn default" data-dismiss="modal">Hủy</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        function setPheDuyet(mahosokt) {
            $('#frm_PheDuyet').find("[name='mahosokt']").val(mahosokt);
        }

        function setKetQua(maphongtraotd) {
            $('#frm_KetThuc').find("[name='maphongtraotd']").val(maphongtraotd);
        }

        function clickKhenThuong() {
            $('#frm_khenthuong').submit();
        }

        function confirmKhenThuong(maphongtraotd, madonvi) {
            $('#frm_khenthuong').find("[name='maphongtraotd']").val(maphongtraotd);
            $('#frm_khenthuong').find("[name='madonvi']").val(madonvi);
        }
    </script>
@stop
