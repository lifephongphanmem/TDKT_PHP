@if($tt->trangthai == "CC")
        <td align="center"><span class="badge badge-warning">Chờ chuyển</span></td>
@elseif($tt->trangthai == 'CD')
        <td align="center"><span class="badge badge-blue">Chờ duyệt</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->ngaychuyen)}}</b>
        </td>
@elseif($tt->trangthai == 'BTL')
        <td align="center">
                <span class="badge badge-danger">Bị trả lại</span><br>&nbsp;
        </td>
@elseif($tt->trangthai == 'CB')
        <td align="center"><span class="badge badge-warning">Công bố</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->ngaychuyen)}}</b>
        </td>
@elseif($tt->trangthai == 'DONGTHOI')
        <td align="center"><span class="badge badge-warning">Gửi đồng thời</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->ngaychuyen)}}</b>
        </td>
@else
        <td align="center">
                <span class="badge badge-success">Đã duyệt</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->ngaychuyen)}}</b>
        </td>
@endif