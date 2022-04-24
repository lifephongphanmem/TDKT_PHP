@if($tt->trangthai == "CC")
        <td align="center"><span class="badge badge-warning">Chờ chuyển</span></td>
@elseif($tt->trangthai == 'CD')
        <td align="center"><span class="badge badge-blue">Chờ duyệt</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->thoigian)}}</b>
        </td>
@elseif($tt->trangthai == 'BTL')
        <td align="center">
                <span class="badge badge-danger">Bị trả lại</span><br>&nbsp;
        </td>
        @elseif($tt->trangthai == 'CNXKT')
        <td align="center"><span class="badge badge-warning">Chờ nhận để xét khen thưởng</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->thoigian)}}</b>
        </td>
        @elseif($tt->trangthai == 'CXKT')
        <td align="center"><span class="badge badge-warning">Chờ xét khen thưởng</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->thoigian)}}</b>
        </td>
@elseif($tt->trangthai == 'CXD')
        <td align="center"><span class="badge badge-warning">Chưa có</span>
        </td>
@else
        <td align="center">
                <span class="badge badge-success">Đã duyệt</span>
                <br>Thời gian chuyển:<br><b>{{getDayVn($tt->thoigian)}}</b>
        </td>
@endif