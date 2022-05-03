<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $pageTitle }}</title>
    <style type="text/css">
        body {
            font: normal 14px/16px time, serif;
        }

        table,
        p {
            width: 98%;
            /*margin: auto;*/
        }

        td,
        th {
            padding: 5px;
        }

        p {
            padding: 5px;
        }

        span {
            text-transform: uppercase;
            font-weight: bold;
        }

    </style>
</head>

<body style="font:normal 14px Times, serif;">
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td style="text-align: left;width: 60%">
                <b>Đơn vị: {{ $m_donvi['tendonvi'] }}</b>
            </td>
            <td style="text-align: center; font-style: italic">

            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                <b>Mã đơn vị SDNS: {{ $m_donvi->maqhns }}</b>
            </td>

            <td style="text-align: center; font-style: italic">

            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px;text-transform: uppercase">
                DANH SÁCH phong trào thi đua khen thưởng 
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{ getDayVn($inputs['ngaytu']) }} đến ngày: {{ getDayVn($inputs['ngayden']) }}
            </td>
        </tr>

    </table>
    
    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <tr>
            <th style="width: 5%">STT</th>
            <th>Tên phong trào thi đua</th>
            <th>Loại hình khen thưởng</th>
            <th>Phạm vi phát động</th>
            <th style="width: 10%">Ngày bắt đầu</th>
            <th style="width: 10%">Ngày kết thúc</th>
        </tr>
        <?php $i = 1; ?>
        @foreach ($a_diaban as $k_diaban => $v_diaban)
            <tr>
                <td style="text-align: center">{{IntToRoman($i++) }}</td>
                <td colspan="5">{{ $v_diaban }}</td>

            </tr>
            <?php
            $chitiet = $model->where('madiaban', $k_diaban);
            $k = 1;
            ?>
            @foreach ($chitiet as $ct)
                <tr>
                    <td style="text-align: center">{{ $k++ }}</td>
                    <td>{{ $ct->noidung }}</td>
                    <td>{{ $a_loaihinhkt[$ct->maloaihinhkt] ?? '' }}</td>
                    <td class="text-center">{{ $a_phamvi[$ct->phamviapdung] }}</td>
                    <td style="text-align: center">{{ getDayVn($ct->tungay) }}</td>
                    <td style="text-align: center">{{ getDayVn($ct->denngay) }}</td>
                </tr>
            @endforeach
        @endforeach

    </table>

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%">…………, Ngày…...tháng……năm……</td>
        </tr>
        <tr>
            <td>{{ $m_donvi->cdketoan }}</td>
            <td>{{ $m_donvi->cdlanhdao }}</td>
        </tr>

        <tr>
            <td style="height: 100px">
                
            </td>
        <tr>            
            <td>{{ $m_donvi->ketoan }}</td>
            <td>{{ $m_donvi->lanhdao }}</td>
        </tr>
    </table>
</body>

</html>
