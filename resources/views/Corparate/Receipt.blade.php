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
        
                    .woterMarkDiv {
  
 text-align:center;
 background-color:grey;
 width:100%
}
.woterMark {

    position: absolute;
    top: 50%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
    
  
}
.woterMarkText {
  margin:0!important;
  color:red;
  font-size:80px;
    -webkit-transform: rotate(-60deg); 
   -moz-transform: rotate(-60deg);    
}

    </style>
</head>

<body style="  text-align:center!important; ">
    
    @if($reservation->ReservationStatus === 'Cancelled')
     <div class="woterMarkDiv">
       <div class="woterMark" >
          <h1 class="woterMarkText">Iptal Edildi</h1>
       </div>
    </div>
    @endif

<div class="invoice-box" style="position:relative;top:10px;">
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

                                <td  style="border:2px solid rgb(131, 130, 130);text-align:center;font-size: 13px;font-weight: bold;" >Tutar: {{$invoice->UnitPrice}} {{$reservation->CurrencySymbol}}</td>
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
                                    @switch($reservation->PaymentMethod)
                                       
                                        @case('CashOnOffice')
                                        Nakit 
                                        @break
                                        @case('CreditCartOnOffice')
                                        Kredi Kartı
                                        @break
                                        @case('CurrentSales')
                                        Cari Satışı
                                        @break
                                        @case('EftTransfer')
                                        @case('CreditCartOnTerminal')
                                        Kredi Kartı Terminal
                                        @break
                                        Havale
                                        @break
                                    @endswitch
                                
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
<div class="invoice-box" style="position:absolute;bottom:10px;width:100%!important; text-align:center!important;">
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

                                <td  style="border:2px solid rgb(131, 130, 130);text-align:center;font-size: 13px;font-weight: bold;" >Tutar: {{$invoice->UnitPrice}} {{$reservation->CurrencySymbol}}</td>
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
                                    @switch($reservation->PaymentMethod)
                                       
                                        @case('CashOnOffice')
                                        Nakit 
                                        @break
                                        @case('CreditCartOnOffice')
                                        Kredi Kartı
                                        @break
                                        @case('CurrentSales')
                                        Cari Satışı
                                        @break
                                        @case('EftTransfer')
                                        @case('CreditCartOnTerminal')
                                        Kredi Kartı Terminal
                                        @break
                                        Havale
                                        @break
                                    @endswitch
                                
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
