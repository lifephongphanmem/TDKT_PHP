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
                window.location.href = '/KhenThuongCongTrang/QuyetDinhKhenThuong/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
            $('#maloaihinhkt').change(function() {
                window.location.href = '/KhenThuongCongTrang/QuyetDinhKhenThuong/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
            $('#nam').change(function() {
                window.location.href = '/KhenThuongCongTrang/QuyetDinhKhenThuong/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('qdhosokhenthuongcongtrang', 'modify'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
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
                    <label style="font-weight: bold">Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', setArrayAll($a_loaihinhkt), $inputs['maloaihinhkt'], ['id' => 'maloaihinhkt', 'class' => 'form-control select2basic']) !!}
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
                                <th width="15%">Tên đơn vị đề nghị</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                <th width="8%">Ngày tạo</th>
                                <th width="8%">Trạng thái</th>
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

                                <td style="text-align: center">
                                    <a title="Thông tin hồ sơ"
                                        href="{{ url('/KhenThuongCongTrang/HoSoKhenThuong/Xem?mahosotdkt=' . $tt->mahosotdkt) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark"></i></a>
                                    @if ($tt->trangthai == 'CXKT')
                                        <button title="Tạo hồ sơ khen thưởng" type="button"
                                            onclick="confirmKhenThuong('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#khenthuong-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-user-check text-success"></i></button>
                                    @endif

                                    @if ($tt->trangthai == 'DXKT')
                                        <a title="Thông tin hồ sơ khen thưởng"
                                            href="{{ url('/KhenThuongCongTrang/QuyetDinhKhenThuong/DanhSach?mahosokt=' . $tt->mahosokt) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-user-check text-dark"></i></a>
                                        <button title="Phê duyệt hồ sơ khen thưởng" type="button"
                                            onclick="setPheDuyet('{{ $tt->mahosokt }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-PheDuyet"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-check text-success"></i></button>
                                    @endif

                                    @if ($tt->trangthai == 'DKT')
                                        <a title="Thông tin hồ sơ khen thưởng"
                                            href="{{ url('/KhenThuongCongTrang/QuyetDinhKhenThuong/Xem?mahosokt=' . $tt->mahosokt) }}"
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

     <!--Modal phê duyệt hồ sơ khen thưởng-->
     <div class="modal fade" id="modal-PheDuyet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             {!! Form::open(['url' => '/KhenThuongCongTrang/QuyetDinhKhenThuong/PheDuyet', 'method' => 'post', 'files' => true, 'id' => 'frm_PheDuyet', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
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
                 <button type="submit" class="btn btn-success">Đồng ý</button>
                 <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
             </div>
             {!! Form::close() !!}
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>

 <!--Modal tạo hồ sơ-->
 <div id="khenthuong-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
     {!! Form::open(['url' => '/KhenThuongCongTrang/QuyetDinhKhenThuong/KhenThuong', 'id' => 'frm_khenthuong']) !!}
     <input type="hidden" name="mahosotdkt" />
     <input type="hidden" name="madonvi" />
     <div class="modal-dialog modal-lg">
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
                     <div class="col-lg-6">
                         <label>Cấp độ khen thưởng</label>
                         {!! Form::select('capkhenthuong', getPhamViApDung(), 'T', ['class' => 'form-control']) !!}
                     </div>

                     <div class="col-lg-6">
                         <label>Ngày ra quyết định</label>
                         {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                     </div>
                 </div>

                 <div class="form-group row">
                     <div class="col-lg-12">
                         <label>Nội dung khen thưởng</label>
                         {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '2']) !!}
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

                 {{-- <div class="form-group row">
                     <div class="col-lg-12">
                         <label>Quyết định khen thưởng</label>
                         {!! Form::select('chucvunguoiky', ['0'=>'Không khen thưởng','1'=>'Khen thưởng'], null, ['class' => 'form-control']) !!}
                     </div>                        
                 </div>

                 <div class="form-group row">
                     <div class="col-lg-12">
                         <label>Lý do (không khen thưởng)</label>
                         {!! Form::textarea('lydo', null, ['class' => 'form-control', 'rows' => '2']) !!}
                     </div>
                 </div> --}}
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

 <script>
     function setPheDuyet(mahosokt) {
         $('#frm_PheDuyet').find("[name='mahosokt']").val(mahosokt);
     }

     function clickKhenThuong() {
         $('#frm_khenthuong').submit();
     }

     function confirmKhenThuong(mahosotdkt, madonvi) {
         $('#frm_khenthuong').find("[name='mahosotdkt']").val(mahosotdkt);
         $('#frm_khenthuong').find("[name='madonvi']").val(madonvi);
     }
 </script>

@stop
