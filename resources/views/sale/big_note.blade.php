<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Big Note</title>

    <style>
        table.data th,
        table.data td {
            border: 1px solid #d8d6d6;
            padding: 5px;
        }

        table.data {
            border-collapse: collapse;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td rowspan="4" width="50%">
                <img src="{{ public_path($setting->path_logo) }}" alt="Logo" width="120">
                <br>
                <p>{{ $setting->address }}</p><br><br>
            </td>
            <td>Tanggal</td>
            <td>: {{ indonesia_date(date('Y-m-d')) ?? '' }}</td>
        </tr>
        <tr>
            <td>Kode</td>
            <td>: {{ $sale->member->member_code ?? '' }}</td>
        </tr>
    </table>

    <table class="data" width="100%">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga Satuan (Rp)</th>
                <th>Jumlah</th>
                <th>Diskon (%)</th>
                <th>Sub Total (Rp)</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($details as $key => $detail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $detail->product->code }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ indonesia_money_format($detail->sale_price) }}</td>
                    <td>{{ $detail->amount }}</td>
                    <td>{{ $detail->discount }}</td>
                    <td class="text-right">{{ indonesia_money_format($detail->sub_total) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center"><b>Total Harga (Rp)</b></td>
                <td class="text-right"><b>{{ indonesia_money_format($sale->total_price) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-center"><b>Diskon (Rp)</b></td>
                <td class="text-right"><b>{{ $sale->discount }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-center"><b>Total Bayar (Rp)</b></td>
                <td class="text-right"><b>{{ indonesia_money_format($sale->pay) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-center"><b>Diterima (Rp)</b></td>
                <td class="text-right"><b>{{ indonesia_money_format($sale->accepted) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-center"><b>Kembali (Rp)</b></td>
                <td class="text-right"><b>{{ indonesia_money_format($sale->accepted - $sale->pay) }}</b></td>
            </tr>
        </tfoot>
    </table>

    <table width="100%" style="margin-top: 5px;">
        <tr>
            <td>
                <b>*** TERIMA KASIH ***</b>
            </td>
            <td class="text-center">
                Kasir <br><br>
                {{ Auth::user()->name }}
            </td>
        </tr>
    </table>
</body>

</html>
