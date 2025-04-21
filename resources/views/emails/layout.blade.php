<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            color: #111827;
        }

        .section {
            margin-top: 20px;
        }

        .section h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product {
            border-top: 1px solid #e5e7eb;
            padding: 15px 0;
            display: flex;
            gap: 10px;
            width: 100%;
        }

        .product img {
            float: left;
            margin-right: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .product-details {
            display: table-cell;
            vertical-align: top;
        }

        p {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .footer {
            font-size: 14px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            margin-top: 30px;
            padding-top: 20px;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-primary {
            color: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center;">
            <img src="https://nyshchyi-nazar.pp.ua/img/svg/logo.svg" alt="Dressiety Logo" width="150">
        </div>

        <h2 style="text-align: center;">
            @yield('title')
        </h2>

        <div class="section">
            @yield('content')
        </div>

        <div class="footer">
            Дякуємо, що користуєтесь Dressiety!
        </div>
    </div>
</body>
</html>
