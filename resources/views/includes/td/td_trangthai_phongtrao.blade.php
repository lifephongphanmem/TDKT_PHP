@if ($tt->trangthai == 'CC')
    <td align="center"><span class="badge badge-success">Đang nhận hồ sơ</span></td>
@elseif ($tt->trangthai == 'CXKT')
    <td align="center"><span class="badge badge-info">Chờ xét khen thưởng</span></td>
@elseif ($tt->trangthai == 'DXKT')
    <td align="center"><span class="badge badge-primary">Đang xét khen thưởng</span></td>
@else
    <td align="center">
        <span class="badge badge-success">Đã kết thúc</span>
    </td>
@endif
