<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Invoice styling -->
    <style>
        body {
            font-family: DejaVu Sans, serif !important;
            text-align: center;
            color: #050505;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 100%;
            margin: auto;
            padding: 10px;
            padding-left: 0px!important;
           
          /*  border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);*/
            font-size: 13px;
            line-height: 12px;
            font-family: DejaVu Sans, serif !important;
            color: #555;
            margin-top: 80px;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
           /* padding: 5px;*/
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }



        .invoice-box table tr.heading td {


            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>


<div class="invoice-box">
    <table>
        
        <tr>
            <table style="margin-top: 15px;">
                <tr>
                    <td></td>
                    <td style="width: 150px;">
                        <table  >
                            <tr>
                                <td  style="border:2px solid rgb(131, 130, 130);text-align:center;font-size: 13px;font-weight: bold;" >{{date('d.m.Y',strtotime($receipt->created_at))}}</td>
                            </tr>

                        </table>
                        <table style="margin-top: 5px;" >
                            <tr >

                                <td  style="border:2px solid rgb(131, 130, 130);text-align:center;font-size: 13px;font-weight: bold;" >Tutar: {{$invoice->UnitPrice}}  TL</td>
                            </tr>

                        </table>

                    </td>
                </tr>

            </table>
            <table style="margin-top: 10px;">
                <tr>
                    <th></th>
                </tr>
                <tr style="border:2px solid rgb(131, 130, 130);">
                    <td style="font-size: 13px; font-weight: 700;">
                         {{$receipt->MessageContent}}
                    </td>
                </tr>
            </table>
            <table style="margin-top: 15px;">
                <tr>

                    <td style="width: 300px;">
                        <table  >
                            <tr>
                                <th style="border:2px solid rgb(131, 130, 130);text-align:left;font-size: 13px;font-weight: bold;">Ödeme Tipi:</th>
                                <td  style="border:2px solid rgb(131, 130, 130);text-align:left;font-size: 13px;font-weight: bold;" >
                                 Nakit
                                </td>
                            </tr>

                        </table>
                    </td>
                    <td></td>
                </tr>

            </table>


            <table style="margin-top: 30px;">
                <tr>
                    <th></th>
                </tr>
                <tr  >
                    <td style="font-size: 13px;font-weight: bold;text-align: center;"> </td>
                    <td style="font-size: 13px;font-weight: bold; text-align: right;">Yetkili İmza ..............................</td>
                </tr>
            </table>
        </tr>


    </table>
</div>
</body>
</html>
