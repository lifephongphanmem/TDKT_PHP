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
                window.location.href = '/XetDuyetHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
            $('#nam').change(function() {
                window.location.href = '/XetDuyetHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
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
                <h3 class="card-label text-uppercase">Danh sách hồ sơ thi đua từ đơn vị cấp dưới</h3>
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
                                <th colspan="4">Phong trào</th>
                                <th rowspan="2" style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                            <tr class="text-center">

                                <th width="10%">Thời gian</th>
                                <th width="8%">Trạng thái</th>
                                <th width="6%">Số hồ<br>sơ đã<br>nhận</th>
                                <th width="15%">Pham vị phát động</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $tt->tendonvi }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">Từ {{ getDayVn($tt->tungay) }}</br> đến
                                    {{ getDayVn($tt->denngay) }}</td>
                                <td style="text-align: center">{{ $a_trangthaihoso[$tt->nhanhoso] }}</td>
                                <td style="text-align: center">{{ chkDbl($tt->sohoso) }}</td>
                                <td>{{ $a_phamvi[$tt->phamviapdung] ?? '' }}</td>

                                <td style="text-align: center">
                                    <a title="Thông tin phong trào"
                                        href="{{ url('/PhongTraoThiDua/Xem?maphongtraotd=' . $tt->maphongtraotd ) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-success"></i></a>
                                    @if ($tt->nhanhoso == 'DANGNHAN')
                                        @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                            <a title="Danh sách chi tiết"
                                                href="{{ url('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' .$tt->maphongtraotd .'&madonvi=' .$inputs['madonvi'] .'&trangthai=true') }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la la-clipboard-list text-dark"></i></a>

                                            {{-- <button title="Kết thúc phong trào" type="button"
                                                onclick="setKetQua('{{ $tt->maphongtraotd }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modal-KetThuc"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-check text-warning"></i></button> --}}
                                        @else
                                            <a title="Danh sách chi tiết"
                                                href="{{ url('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' .$tt->maphongtraotd .'&madonvi=' .$inputs['madonvi'] .'&trangthai=false') }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la la-clipboard-list text-dark"></i></a>
                                        @endif
                                    @else
                                        <a title="Danh sách chi tiết"
                                            href="{{ url('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' .$tt->maphongtraotd .'&madonvi=' .$inputs['madonvi'] .'&trangthai=true') }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la la-clipboard-list text-dark"></i></a>
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
    <script>
        function setKetQua(maphongtraotd) {
            $('#frm_KetThuc').find("[name='maphongtraotd']").val(maphongtraotd);
        }
    </script>
    @include('includes.modal.modal-delete')
@stop
