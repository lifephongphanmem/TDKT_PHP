@if ($tt->trangthai == 'CC')
    <td align="center">
        <span class="badge badge-warning">Chờ chuyển</span>
    </td>
@elseif($tt->trangthai == 'CD')
    <td align="center">
        <span class="badge badge-info">Chờ duyệt</span>        
        <br><span class="text-bold">{{ getDayVn($tt->thoigian) }}</span>
    </td>
@elseif($tt->trangthai == 'BTL')
    <td align="center">
        <span class="badge badge-danger">Bị trả lại</span><br>&nbsp;
    </td>
@elseif($tt->trangthai == 'CNXKT')
    <td align="center"><span class="badge badge-warning">Chờ nhận để xét khen thưởng</span>
        <br>Thời gian chuyển:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@elseif($tt->trangthai == 'CXKT')
    <td align="center"><span class="badge badge-warning">Chờ xét khen thưởng</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@elseif($tt->trangthai == 'CXD')
    <td align="center"><span class="badge badge-warning">Chưa có</span>
    </td>
@elseif($tt->trangthai == 'DKT')
    <td align="center">
        <span class="badge badge-success">Đã khen thưởng</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
    @elseif($tt->trangthai == 'DXKT')
<td align="center"><span class="badge badge-warning">Đang xét khen thưởng</span>
    </td>
@else
    <td align="center">
        <span class="badge badge-success">Đã duyệt</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@endif
