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

                    <table class="table table-striped table-bordered table-hover" id="sample_4">
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
                        @foreach($model as $key => $tt)
                            <tr class="{{$tt->nhanhoso == 'DANGNHAN' ? 'text-success' : ''}}">
                                <td style="text-align: center">{{$key+1}}</td>
                                <td>{{$tt->tendonvi}}</td>
                                <td>{{$tt->noidung}}</td>
                                <td>{{getDayVn($tt->tungay)}}</td>
                                <td>{{getDayVn($tt->denngay)}}</td>
                                <td style="text-align: center">{{$a_trangthaihoso[$tt->nhanhoso]}}</td>
                                <td style="text-align: center">{{chkDbl($tt->sohoso)}}</td>
                                <td>{{$a_phamvi[$tt->phamviapdung] ?? ''}}</td>

                                <td style="text-align: center">
                                    <a title="Thông tin phong trào" href="{{url('/PhongTraoThiDua/Sua?maphongtraotd='.$tt->maphongtraotd.'&trangthai=false')}}" class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark"></i></a>

                                    <a title="Danh sách hồ sơ chi tiết" href="{{url('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd='.$tt->maphongtraotd.'&madonvi='.$inputs['madonvi'].'&trangthai=false')}}" class="btn btn-sm btn-clean btn-icon">
                                        <i class="icon-lg la la-clipboard-list text-dark"></i></a>

                                        <button title="Tạo hồ sơ khen thưởng" type="button" onclick="confirmKhenThuong('{{$tt->maphongtraotd}}','{{$inputs['madonvi']}}')" class="btn btn-sm btn-clean btn-icon" data-target="#khenthuong-modal" data-toggle="modal">
                                            <i class="icon-lg la fa-list text-success"></i></button>

                                </td>
                            </tr>
                        @endforeach
                    </table>                    
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <!--Modal Nhận hồ sơ-->
<div id="khenthuong-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url'=>'/KhenThuongHoSoThiDua/KhenThuong','id' => 'frm_khenthuong'])!!}
    <input type="hidden" name="maphongtraotd" />
    <input type="hidden" name="madonvi" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">                
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ khen thưởng?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true"
                class="close">&times;</button>

            </div>
            <div class="modal-body">
                ĐƠn vị khen thưởng
                Cấp khen thưởng
                Nagày tháng
                Người ký
                Chức vụ
                <p style="color: #0000FF">Hồ sơ đã tiếp nhận và chờ xét duyệt khen thưởng. Bạn cần liên hệ đơn vị tiếp nhận để chỉnh sửa hồ sơ nếu cần!</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickKhenThuong()">Đồng ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickKhenThuong(){
        $('#frm_khenthuong').submit();
    }

    function confirmKhenThuong(maphongtraotd,madonvi) {
        $('#frm_khenthuong').find("[name='maphongtraotd']").val(maphongtraotd);
        $('#frm_khenthuong').find("[name='madonvi']").val(madonvi);
    }
</script>
@stop
