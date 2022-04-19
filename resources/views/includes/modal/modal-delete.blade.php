{!! Form::open(['url' => '', 'id' => 'frm_delete']) !!}
<div id="delete-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý xoá?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <input type="hidden" name="id" />
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickdelete()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script>
    function confirmDelete(id, url) {
        $('#frm_delete').attr('action', url);
        $('#frm_delete').find("[name='id']").val(id);
    }

    function clickdelete() {
        $('#frm_delete').submit();
    }
</script>
