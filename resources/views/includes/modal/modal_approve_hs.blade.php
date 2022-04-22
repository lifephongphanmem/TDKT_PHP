<!--Modal Chuyển hồ sơ-->
<div id="chuyen-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url'=>'','id' => 'frm_chuyen'])!!}
    <input type="hidden" name="mahoso" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">                
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý hoàn thành hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true"
                class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ đã hoàn thành sẽ được chuyển lên đơn vị tiếp nhận. Bạn cần liên hệ đơn vị tiếp nhận để chỉnh sửa hồ sơ nếu cần!</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Cơ quan tiếp nhận<span class="require">*</span></label>
                            {!! Form::select('madonvi_nhan', $a_donviql, null, ['class' => 'form-control select2_modal']) !!}                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickChuyen()">Đồng ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickChuyen(){
        var str = '';
        var ok = true;
        var madonvi_nhan = $('#frm_chuyen').find("[name='madonvi_nhan']").val();
        if (madonvi_nhan == null) {
            str += '  - Cơ quan tiếp nhận. \n';
            $('#frm_chuyen').find("[name='madonvi_nhan']").parent().addClass('has-error');
            ok = false;
        }

        if (ok == false) {
            //alert('Các trường: \n' + str + 'Không được để trống');
            toastr.error('Thông tin: \n' + str + 'Không hợp lệ','Lỗi!.');
            $("frm_chuyen").submit(function (e) {
                e.preventDefault();
            });
        }
        else {
            $("frm_chuyen").unbind('submit').submit();
            $('#frm_chuyen').submit();
        }
        //$('#frm_chuyen').submit();
    }

    function confirmChuyen(mahs,url) {
        $('#frm_chuyen').attr('action', url);
        $('#frm_chuyen').find("[name='mahoso']").val(mahs);
    }
</script>