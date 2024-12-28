<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Barcode</title>
</head>

<body>
    <table width="100%">
        <tr>
            @foreach ($data_product as $key => $product)
                <td class="text-center" style="text-align: center;border:1px solid #333;">
                    <p>{{ $product->name }}</p>
                    <p>Rp {{ indonesia_money_format($product->sell_price) }}</p>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->code, 'C39') }}"
                        alt="{{ $product->code }}" width="100" height="50">
                    <br><br>
                    {{ $product->code }}
                </td>
                @if (($key + 1) % 3 == 0)
        </tr>
        <tr>
            @endif
            @endforeach
        </tr>
    </table>
</body>

</html>
