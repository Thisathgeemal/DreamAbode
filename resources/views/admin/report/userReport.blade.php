<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>DreamAbode</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .page-container {
            padding: 20px 30px;
            border: 2px solid #0a3d62;
            border-radius: 8px;
            min-height: 900px;
        }

        header {
            background-color: #0a3d62;
            color: white;
            padding: 20px 30px;
            border-radius: 6px 6px 0 0;
        }

        .header-center {
            text-align: center;
        }

        .header-center h1 {
            font-size: 22px;
            margin: 0;
        }

        .header-left {
            margin-bottom: 5px;
            text-align: left;
        }

        .report-title {
            text-align: center;
            margin: 20px 0 15px;
            font-size: 20px;
            font-weight: bold;
            color: #0a3d62;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f0f4f7;
            color: #0a3d62;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <header>
            <div class="header-center">
                <h1>DreamAbode</h1>
            </div>
        </header>

        <h2 class="report-title">{{ ucfirst($role) }} Management Report</h2>

        <div class="header-left">
            <strong>Date:</strong> {{ $formattedDate }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile_number ?? '-' }}</td>
                        <td>{{ $user->address ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>© {{ date('Y') }} DreamAbode. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
