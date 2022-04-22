<div id="dinhkem-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    {!! Form::open(['url'=>'approve','id' => 'frm_dinhkem'])!!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" data-dismiss="modal" aria-hidden="true"
                        class="close">&times;</button>
                <h4 id="modal-header-primary-label" class="modal-title">Danh sách tài liệu đính kèm</h4>
            </div>
            <div class="modal-body" id="dinh_kem">

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script>
    function get_attack(mahs){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '{{$inputs['url']}}' + '/dinhkem',
            type: 'GET',
            data: {
                _token: CSRF_TOKEN,
                mahs: mahs
            },
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'success') {
                    $('#dinh_kem').replaceWith(data.message);
                }
            },
            error: function (message) {
                toastr.error(message, 'Lỗi!');
            }
        });
    }
</script>
