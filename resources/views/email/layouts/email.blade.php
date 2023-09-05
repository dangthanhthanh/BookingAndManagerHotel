<!DOCTYPE html>
<html>
<head>
    <title>Booking for HOTEL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #dad5d5;
            border: 2px solid gray;
        }
        .thumbnail {
            width: 100%;
            height: 300px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #dbd8d8;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .content {
            margin: 0 auto;
            display: block;
            text-align: center;
        }

        .button {
            display: inline-block;
            background-color: #dbd8d8;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .footer {
            background-color: #dbd8d8;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="thumbnail" style="background-image: url('https://truongcaodangnauan.edu.vn/test_disk/photos/shares/hotel-la-gi.jpg')"></div>
        <div class="header">
            <h1>@yield('title')</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            @yield('footer')
        </div>
    </div>
</body>
</html>
