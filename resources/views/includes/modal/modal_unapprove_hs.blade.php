<!--Modal Chuyển hồ sơ-->
<div id="modal-tralai" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    {!! Form::open(['url'=>'','id' => 'frm_tralai'])!!}
    <input type="hidden" name="mahoso" id="mahoso">
                <input type="hidden" name="madonvi" id="madonvi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý hủy hoàn thành hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true"
                        class="close">&times;</button>                
            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ Bị hủy sẽ chuyển lại cho cơ quan nhập liệu để có thể chỉnh sửa thông tin hồ sơ!</p>
                <div class="row">
                    <div class="col-md-12">
                        <label class=" control-label">Lí do trả lại<span class="require">*</span></label>
                        {!! Form::textarea('lydo', null, ['id' => 'lydo', 'rows' => 3, 'cols' => 10, 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickTraLai()">Đồng ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickTraLai(){
        $('#frm_tralai').submit();
    }

    function confirmTraLai(mahoso, madonvi, url) {
        $('#frm_tralai').attr('action', url);
        $('#frm_tralai').find("[id='madonvi']").val(madonvi);
        $('#frm_tralai').find("[id='mahoso']").val(mahoso);
    }
</script>