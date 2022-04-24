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
                window.location.href = '/HoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
            $('#nam').change(function() {
                window.location.href = '/HoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
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
                <h3 class="card-label text-uppercase">Danh sách hồ sơ thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dshosothidua', 'modify'))
                    <a href="{{ url('/HoSoThiDua/Them?madonvi=' . $inputs['madonvi']) }}" class="btn btn-success btn-xs">
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
                                <th rowspan="2" width="2%">STT</th>
                                <th rowspan="2">Đơn vị phát động</th>
                                <th rowspan="2">Nội dung hồ sơ</th>
                                <th colspan="4">Phong trào</th>
                                <th colspan="2">Hồ sơ của đơn vị</th>
                                <th rowspan="2" style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                            <tr>

                                <th width="8%">Ngày<br>bắt đầu</th>
                                <th width="8%">Ngày<br>kết thúc</th>
                                <th width="8%">Trạng thái</th>
                                <th style="text-align: center" width="8%">Tổng số<br>hồ sơ</th>

                                <th width="8%">Trạng thái</th>
                                <th style="text-align: center" width="8%">Số lượng</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr class="{{ $tt->nhanhoso == 'DANGNHAN' ? 'text-success' : '' }}">
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $tt->tendonvi }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ getDayVn($tt->tungay) }}</td>
                                <td>{{ getDayVn($tt->denngay) }}</td>
                                <td style="text-align: center">{{ $a_trangthaihoso[$tt->nhanhoso] }}</td>
                                <td style="text-align: center">{{ chkDbl($tt->sohoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td style="text-align: center">{{ chkDbl($tt->hosodonvi) }}</td>

                                <td style="text-align: center">
                                    <a title="Thông tin phong trào"
                                        href="{{ url('PhongTraoThiDua/Sua?maphongtraotd=' . $tt->maphongtraotd . '&trangthai=false') }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-success"></i></a>
                                    @if ($tt->nhanhoso == 'DANGNHAN')
                                        @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                            <a title="Hồ sơ đăng ký phong trào"
                                                href="{{ url('/HoSoThiDua/Them?mahosotdkt=' .$tt->mahosotdkt .'&madonvi=' .$inputs['madonvi'] .'&maphongtraotd=' .$tt->maphongtraotd .'&trangthai=true') }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-check-square text-primary"></i></a>
                                        @else
                                            <a title="Hồ sơ đăng ký phong trào"
                                                href="{{ url('/HoSoThiDua/Them?mahosotdkt=' .$tt->mahosotdkt .'&madonvi=' .$inputs['madonvi'] .'&maphongtraotd=' .$tt->maphongtraotd .'&trangthai=false') }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-check-square text-primary"></i></a>
                                        @endif
                                        @if ($tt->hosodonvi > 0 && in_array($tt->trangthai, ['CC', 'BTL']))
                                            <button title="Trình hồ sơ đăng ký" type="button"
                                                onclick="confirmChuyen('{{ $tt->mahosotdkt }}','/HoSoThiDua/ChuyenHoSo')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#chuyen-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-share-square text-dark"></i></button>
                                        @endif
                                    @else
                                        <a title="Hồ sơ đăng ký phong trào"
                                            href="{{ url('/HoSoThiDua/Them?mahosotdkt=' .$tt->mahosotdkt .'&madonvi=' .$inputs['madonvi'] .'&maphongtraotd=' .$tt->maphongtraotd .'&trangthai=false') }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check-square text-primary"></i></a>
                                    @endif

                                    @if ($tt->trangthai == 'BTL')
                                        <button title="Lý do hồ sơ bị trả lại" type="button"
                                            onclick="viewLiDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#lydo-show"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-archive text-info"></i></button>
                                    @endif

                                    @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']) && $tt->hosodonvi > 0)
                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','/HoSoThiDua/Xoa')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i></button>
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
