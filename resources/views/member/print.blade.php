<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Member Card</title>

    <style>
        /* Global reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body & general layout */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        /* Container to hold member cards */
        .container {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
            justify-content: flex-start;
            overflow-x: auto;
        }

        /* Member card styling */
        .card {
            width: 50%;
            height: 54mm;
            background-color: #070606;
            background: url("{{ public_path($setting->path_card_member) }}")
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            padding: 10px;
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-bottom: 1%;
        }

        /* Logo styling */
        .logo {
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: calc(100% - 10mm);
        }

        .logo img {
            width: 50px;
            height: 50px;
        }

        .logo p {
            font-size: 14pt;
            font-weight: bold;
            color: #fff;
            text-align: right;
        }

        /* Name and Phone styling */
        .name,
        .phone {
            position: absolute;
            left: 5mm;
            font-size: 14pt;
            font-weight: bold;
            color: #fff;
        }

        .name {
            bottom: 15mm;
        }

        .phone {
            bottom: 5mm;
        }

        /* QR Code styling */
        .barcode {
            position: absolute;
            bottom: 5mm;
            right: 5mm;
            padding: 2mm;
            background-color: #fff;
            border-radius: 4px;
        }

        .barcode img {
            width: 60px;
            height: 60px;
        }
    </style>
</head>

<body>
    <section>
        <div class="container">
            @foreach ($data_member as $member)
                <div class="card">
                    <!-- Logo Section -->
                    <div class="logo">
                        <img src="{{ public_path($setting->path_logo) }}" alt="Logo">
                        <p>{{ $setting->company_name }}</p>
                    </div>

                    <!-- Member Name and Phone Section -->
                    <div class="name">{{ $member->name }}</div>
                    <div class="phone">{{ $member->phone }}</div>

                    <!-- QR Code Section -->
                    <div class="barcode">
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($member->member_code, 'QRCODE') }}"
                            alt="QRCode">
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</body>

</html>
