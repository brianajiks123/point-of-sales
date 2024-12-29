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
            /* Adds space between cards */
            justify-content: flex-start;
            /* Align items from left to right */
            overflow-x: auto;
            /* Allow horizontal scrolling if necessary */
        }

        /* Member card styling */
        .card {
            width: 50%;
            /* Adjust width as per design requirements */
            height: 54mm;
            background-image: url('{{ public_path('admin/images/member.png') }}');
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
            right: 5mm;
            top: 5mm;
            text-align: center;
            color: #fff;
        }

        .logo img {
            width: 50px;
            height: 50px;
        }

        .logo p {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 5px;
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
            @foreach ($data_member as $data)
                @foreach ($data as $member)
                    <div class="card">
                        <!-- Logo Section -->
                        <div class="logo">
                            <img src="{{ public_path('admin/images/logo.png') }}" alt="Logo">
                            <p>{{ config('app.name') }}</p>
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
            @endforeach
        </div>
    </section>
</body>

</html>
