@if ($tt->trangthai == 'CC')
    <td align="center"><span class="badge badge-success">Đang nhận hồ sơ</span></td>
@elseif ($tt->trangthai == 'CKT')
    <td align="center"><span class="badge badge-info">Chờ xét khen thưởng</span></td>
@else
    <td align="center">
        <span class="badge badge-success">Đã kết thúc</span>
    </td>
@endif