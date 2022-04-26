<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $pageTitle }}</title>
    <style type="text/css">
        body {
            font: normal 12px/16px time, serif;
        }

        table
        {   height: 21cm;
            width: 30cm;
            margin: auto;
        }

        table tr td:first-child {
            text-align: center;
        }

        td,
        th {
            padding: 2px;
        }

    </style>
</head>

<body>
    <table cellspacing="0" cellpadding="0" border="0" background="{{url('/assets/media/Phoi/BangKhen.jpg')}}" style="background-repeat: no-repeat;background-size: 100% 100%;">
        <tr style="height: 10.5cm">
            <td colspan="2" style="text-align: center; font-size: 30px; text-transform: uppercase;vertical-align: bottom">
                <b>Ông/Bà: {{$model->tendoituong}}</b>
            </td>
        </tr>
        <tr style="height: 2cm">
            <td colspan="2" style="text-align: center; font-size: 25px;">
                Đã đạt danh hiệu: {{$model->tendanhhieutd}} <span> trong phong trào</span>
            </td>
        </tr>
        <tr style="height: 2cm">
            <td style="width: 50%;">
                
            </td>
            <td style="text-align: center; font-size: 20px; vertical-align: bottom;font-style: italic">
               ..., Ngày ... tháng ... năm
            </td>
        </tr>
        <tr style="height: 1cm">
            <td style="width: 50%;">
                
            </td>
            <td style="text-align: center; font-size: 20px; vertical-align: top">
               Chức vụ người ký
            </td>
        </tr>
        <tr>
            <td style="width: 50%;">
                
            </td>
            <td style="text-align: center; font-size: 20px;">
               Họ tên người ký
            </td>
        </tr>    
    </table>
    
</body>

</html>
