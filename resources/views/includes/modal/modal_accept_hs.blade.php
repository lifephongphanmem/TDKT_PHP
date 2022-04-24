<!--Modal Nhận hồ sơ-->
<div id="nhan-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url'=>'','id' => 'frm_nhan'])!!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi_nhan" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">                
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tiếp nhận hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true"
                class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ đã tiếp nhận và chờ xét duyệt khen thưởng. Bạn cần liên hệ đơn vị tiếp nhận để chỉnh sửa hồ sơ nếu cần!</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickNhan()">Đồng ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickNhan(){
        $('#frm_nhan').submit();
    }

    function confirmNhan(mahs,url,madonvi) {
        $('#frm_nhan').attr('action', url);
        $('#frm_nhan').find("[name='mahoso']").val(mahs);
        $('#frm_nhan').find("[name='madonvi_nhan']").val(madonvi);
    }
</script>