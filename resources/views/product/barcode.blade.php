<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-spacing: 0;
            /* Atur jarak antar sel tabel */
        }

        td {
            text-align: center;
            border: 1px solid #333;
            /* Pastikan setiap td memiliki border */
            padding: 10px;
            vertical-align: top;
            width: 33%;
            /* Setiap kolom mengambil 33% dari lebar tabel */
        }

        .barcode-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .barcode-container img {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .product-name {
            font-weight: bold;
        }

        .product-price {
            margin: 5px 0;
        }

        .product-code {
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            @foreach ($data_product as $key => $product)
                <td>
                    <div class="barcode-container">
                        <p class="product-name">{{ $product->name }}</p>
                        <p class="product-price">Rp {{ indonesia_money_format($product->sell_price) }}</p>
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->code, 'C39') }}"
                            alt="{{ $product->code }}" width="100" height="50">
                        <p class="product-code">{{ $product->code }}</p>
                    </div>
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
