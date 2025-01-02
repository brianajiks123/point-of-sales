<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Small Note</title>

    <style>
        * {
            font-family: "consolas", sans-serif;
        }

        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }

        table td {
            font-size: 9pt;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm {{ !empty($_COOKIE['innerHeight']) ? $_COOKIE['innerHeight'] . 'mm' : '' }};
            }

            html,
            body {
                width: 80mm;
            }

            .btn_print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <button class="btn_print" style="position: absolute; right: 1rem; top: 1rem;">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($setting->company_name) }}</h3>
        <p>{{ strtoupper($setting->address) }}</p>
    </div><br>
    <div>
        <p style="float: left;">{{ date('d-m-Y') }}</p>
        <p style="float: right;">{{ strtoupper(Auth::user()->name) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>

    <p>Nomor : {{ code_generator($sale->id, 6) }}</p>

    <p style="margin: 0;" class="text-center">==========================================</p><br>

    <table width="100%" style="border: 0;">
        @foreach ($detail as $item)
            <tr>
                <td colspan="2">{{ $item->product->name }}</td>
            </tr>
            <tr>
                <td>{{ $item->amount }} x {{ indonesia_money_format($item->sale_price) }}</td>
                <td></td>
                <td class="text-right">{{ indonesia_money_format($item->amount * $item->sale_price) }}</td>
            </tr>
        @endforeach
    </table>

    <p class="text-center">----------------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga :</td>
            <td class="text-right">{{ indonesia_money_format($sale->total_price) }}</td>
        </tr>
        <tr>
            <td>Total Item :</td>
            <td class="text-right">{{ indonesia_money_format($sale->total_item) }}</td>
        </tr>
        <tr>
            <td>Diskon :</td>
            <td class="text-right">{{ $sale->discount }}</td>
        </tr>
        <tr>
            <td>Total Bayar :</td>
            <td class="text-right">{{ indonesia_money_format($sale->pay) }}</td>
        </tr>
        <tr>
            <td>Diterima :</td>
            <td class="text-right">{{ indonesia_money_format($sale->accepted) }}</td>
        </tr>
        <tr>
            <td>Kembali :</td>
            <td class="text-right">{{ indonesia_money_format($sale->accepted - $sale->pay) }}</td>
        </tr>
    </table>

    <p class="text-center">==========================================</p>

    <p class="text-center">** TERIMA KASIH **</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight,
            body.offsetHeight,
            html.clientHeight,
            html.scrollHeight,
            html.offsetHeight,
        );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583);
    </script>
</body>

</html>
