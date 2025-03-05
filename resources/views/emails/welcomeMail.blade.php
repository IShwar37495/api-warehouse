<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to APIWarehouse!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #FE4D01;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

    <div class="container">
        <img src="{{ url(asset('images/image.png')) }}" alt="APIWarehouse Logo" class="logo">

        <h1>Welcome, {{ $user->name }}!</h1>
        <p class="content">
            Thank you for signing up with **APIWarehouse**. We’re thrilled to have you on board!
            Get started by exploring our APIs and features.
        </p>
        <a href="{{ url('/') }}" class="button">Explore APIWarehouse</a>
        <p class="footer">If you did not sign up, please ignore this email.</p>
    </div>

</body>
</html>
