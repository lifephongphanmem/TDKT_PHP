{{-- Modal tra lại --}}
<div id="tralai-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    {!! Form::open(['url'=>'','id' => 'frm_tralai'])!!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">                   
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin hồ sơ bị trả lại</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true"
                class="close">&times;</button>                  
            </div>
            <div class="modal-body">                   
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Lý do trả lại</label>
                            {!! Form::textarea('lydo', null, array('id' => 'lydo','class' => 'form-control', 'rows'=>'3','required'=>'required')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function viewLyDo(mahs, madv, url) {
        $('#btn_tralai').hide();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //alert(id);
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                _token: CSRF_TOKEN,
                mahosotdkt: mahs,
                madonvi: madv
            },
            dataType: 'JSON',
            success: function (data) {
                $('#frm_tralai').find("[id='lydo']").val(data.lydo);
            }
        })
    }
</script>
