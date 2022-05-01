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
                window.location.href = '/CumKhoiThiDua/XetDuyetHoSoKhenThuong/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&macumkhoi=' + $('#macumkhoi').val() + '&nam=' + $('#nam').val();
            });
            $('#nam').change(function() {
                window.location.href = '/CumKhoiThiDua/XetDuyetHoSoKhenThuong/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&macumkhoi=' + $('#macumkhoi').val() + '&nam=' + $('#nam').val();
            });
            $('#macumkhoi').change(function() {
                window.location.href = '/CumKhoiThiDua/XetDuyetHoSoKhenThuong/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&macumkhoi=' + $('#macumkhoi').val() + '&nam=' + $('#nam').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ thi đua từ đơn vị cấp dưới</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-9">
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
                <div class="col-md-9">
                    <label style="font-weight: bold">Cụm, khối thi đua</label>
                    <select class="form-control select2basic" id="macumkhoi">
                        @foreach ($m_cumkhoi as $cumkhoi)
                            <option {{ $cumkhoi->macumkhoi == $inputs['macumkhoi'] ? 'selected' : '' }}
                                value="{{ $cumkhoi->macumkhoi }}">{{ $cumkhoi->tencumkhoi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th width="15%">Tên đơn vị</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                <th width="8%">Ngày tạo</th>
                                <th width="8%">Trạng thái</th>
                                <th width="15%">Đơn vị tiếp nhận</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    <a title="Thông tin hồ sơ"
                                        href="{{ url('/CumKhoiThiDua/HoSoKhenThuong/Xem?mahosotdkt=' . $tt->mahosotdkt) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark"></i></a>

                                    @if (in_array($tt->trangthai_hoso, ['CD']))
                                        <button title="Trả lại hồ sơ" type="button"
                                            onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '/CumKhoiThiDua/XetDuyetHoSoKhenThuong/TraLai')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai"
                                            data-toggle="modal">
                                            <i class="icon-lg la la-reply text-danger"></i></button>

                                        <button title="Nhận hồ sơ đăng ký" type="button"
                                            onclick="confirmNhan('{{ $tt->mahosotdkt }}','/CumKhoiThiDua/XetDuyetHoSoKhenThuong/NhanHoSo','{{ $inputs['madonvi'] }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-share-square text-success"></i></button>
                                    @endif

                                    @if (in_array($tt->trangthai_hoso, ['CNXKT']))
                                        <button title="Chuyển hồ sơ đăng ký" type="button"
                                            onclick="confirmChuyen('{{ $tt->mahosotdkt }}','/XetDuyetHoSoThiDua/ChuyenHoSo')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#chuyen-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-share-square text-success"></i></button>
                                    @endif
                                    @if ($tt->trangthai == 'DKT')
                                        <a title="Thông tin hồ sơ khen thưởng"
                                            href="{{ url('/CumKhoiThiDua/KhenThuongHoSoKhenThuong/Xem?mahosokt=' . $tt->mahosokt) }}"
                                            class="btn btn-sm btn-clean btn-icon" target="_blank">
                                            <i class="icon-lg la fa-user-check text-dark"></i></a>
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

    @include('includes.modal.modal_unapprove_hs')
    {{-- @include('includes.modal.modal_approve_hs') --}}
    @include('includes.modal.modal_accept_hs')
@stop
