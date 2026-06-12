<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title> @yield('title') </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />




    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->






    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            unicode-bidi: embed;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
            margin: 20px;
            color: #333;
        }



        .header h2 {
            margin: 0;
            color: #2c3e50;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th {
            background: #2c3e50;
            color: #fff;
            padding: 10px;
            font-size: 14px;
        }

        .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .total {
            margin-top: 20px;
            text-align: left;
        }

        .total p {
            font-size: 16px;
            margin: 5px 0;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: gray;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

</head>

<body>

    <div class="header">
        <h2 class="mb-2 text-[#2c3e50] text-center">@yield('header')</h2>
        <p class="mb-2">اسم الشركة:{{ Auth::guard('admin')->user()->company_name }} </p>
        <p>رقم الشركة:{{ Auth::guard('admin')->user()->phoneNumber }} </p>

    </div>

    <div class="info">
        @yield('info custemer')
    </div>

    @yield('table')



    <div class="info mt-4">
        @yield('sum')
    </div>

    <div class="footer">
        @yield('footer')
    </div>

</body>

</html>
