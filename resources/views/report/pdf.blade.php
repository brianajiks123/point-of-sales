<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Income Report</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .text-center {
            text-align: center;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            font-size: 12px;
            border-collapse: collapse;
            background-color: #fff;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table-striped tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .table-striped tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .table th:last-child,
        .table td:last-child {
            text-align: right;
        }

        .table td:first-child {
            font-weight: bold;
        }

        h4 {
            color: #555;
            margin-top: 15px;
            font-size: 16px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>
    <h3 class="text-center">Laporan Pendapatan</h3>
    <h4 class="text-center">
        Tanggal : {{ indonesia_date($first_date, false) }} s/d {{ indonesia_date($last_date, false) }}
    </h4>

    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="20%">Tanggal</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Pengeluaran</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $items)
                <tr>
                    @foreach ($items as $item)
                        <td>{{ $item }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
