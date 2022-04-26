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
                window.location.href = '/CumKhoiThiDua/HoSoKhenThuong/DanhSach?madonvi=' + $('#madonvi')
                    .val() +
                    '&nam=' + $('#nam').val() + '&macumkhoi=' + '{{ $inputs['macumkhoi'] }}';
            });
            $('#nam').change(function() {
                window.location.href = '/CumKhoiThiDua/HoSoKhenThuong/DanhSach?madonvi=' + $('#madonvi')
                    .val() +
                    '&nam=' + $('#nam').val() + '&macumkhoi=' + '{{ $inputs['macumkhoi'] }}';
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dshosotdktcumkhoi', 'modify'))
                    <a href="{{ url('/CumKhoiThiDua/HoSoKhenThuong/Them?madonvi=' . $inputs['madonvi'] . '&macumkhoi=' . $inputs['macumkhoi']) }}"
                        class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
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

                    <table class="table table-striped table-bordered table-hover" id="sample_4">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
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
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                        <a title="Hồ sơ đăng ký phong trào"
                                            href="{{ url('/CumKhoiThiDua/HoSoKhenThuong/Sua?mahosotdkt=' . $tt->mahosotdkt . '&trangthai=true') }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check-square text-primary"></i></a>

                                        <button title="Trình hồ sơ đăng ký" type="button"
                                            onclick="confirmChuyen('{{ $tt->mahosotdkt }}','/CumKhoiThiDua/HoSoKhenThuong/ChuyenHoSo')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#chuyen-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-share text-dark"></i></button>

                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','/CumKhoiThiDua/HoSoKhenThuong/Xoa')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i></button>
                                    @else
                                        <a title="Hồ sơ đăng ký phong trào"
                                            href="{{ url('/CumKhoiThiDua/HoSoKhenThuong/Sua?mahosotdkt=' . $tt->mahosotdkt . '&trangthai=false') }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-eye text-primary"></i></a>
                                    @endif

                                    @if ($tt->trangthai == 'BTL')
                                        <button title="Lý do hồ sơ bị trả lại" type="button"
                                            onclick="viewLiDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#lydo-show"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-archive text-info"></i></button>
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
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_approve_hs')
@stop
