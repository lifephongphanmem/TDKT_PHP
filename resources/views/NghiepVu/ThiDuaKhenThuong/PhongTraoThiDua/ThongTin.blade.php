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
                window.location.href = '/PhongTraoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                '&nam=' + $('#nam').val() +'&phanloai=' + $('#phanloai').val();
            });
            $('#nam').change(function() {
                window.location.href = '/PhongTraoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                '&nam=' + $('#nam').val() +'&phanloai=' + $('#phanloai').val();
            });
            $('#phanloai').change(function() {
                window.location.href = '/PhongTraoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() +'&phanloai=' + $('#phanloai').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsphongtraothidua', 'modify'))
                    <a href="{{ url('/PhongTraoThiDua/Them?madonvi=' . $inputs['madonvi']) }}"
                        class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-5">
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
                <div class="col-md-5">
                    <label style="font-weight: bold">Hình thức tổ chức</label>
                    {!! Form::select('phanloai', $a_phanloai, $inputs['phanloai'], ['id' => 'phanloai', 'class' => 'form-control select2basic']) !!}
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Nội dung phong trào</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                <th width="10%">Ngày quyết định</th>
                                <th width="15%">Phạm vi phát động</th>
                                <th width="10%">Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td class="active">{{ $tt->noidung }}</td>
                                <td>{{$a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayqd) }}</td>
                                <td class="text-center">{{$a_phamvi[$tt->phamviapdung] }}</td>
                                @include('includes.td.td_trangthai_phongtrao')
                                <td class=" text-center">
                                    <a title="Xem chi tiết" href="{{ url('/PhongTraoThiDua/Xem?maphongtraotd=' . $tt->maphongtraotd) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark"></i></a>
                                    @if (chkPhanQuyen('dsphongtraothidua', 'modify'))
                                        {{-- @if ($tt->trangthai == 'CC' || $tt->trangthai == 'BTL')
                                            <a title="Chỉnh sửa" href="{{ url('/PhongTraoThiDua/Sua?maphongtraotd=' . $tt->maphongtraotd) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-edit text-success"></i></a>
                                            <button title="Chuyển hồ sơ" type="button" onclick="getIdTr('{{ $tt->id }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#trans-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-forward text-secondary"></i></button>
                                        @endif
                                        @if ($tt->trangthai == 'BTL')
                                            <button title="Lý do trả lại" type="button" onclick="viewLiDo('{{ $tt->id }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#lydo-show"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-archive text-secondary"></i></button>
                                        @endif --}}
                                        @if ($tt->trangthai == 'CC')
                                            <a title="Chỉnh sửa"
                                                href="{{ url('/PhongTraoThiDua/Sua?maphongtraotd=' . $tt->maphongtraotd) }}"
                                                class="btn btn-sm btn-clean btn-icon"><i
                                                    class="icon-lg la fa-edit text-success"></i></a>
                                                    
                                            <button title="Xóa hồ sơ" type="button" onclick="confirmDelete('{{ $tt->id }}','/PhongTraoThiDua/Xoa')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash-alt text-danger"></i></button>
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
    @include('includes.modal.modal-delete')
@stop
