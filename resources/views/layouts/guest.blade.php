<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    <style>
        .container-form {
            top: 76px;
            left: 357px;
            width: 800px !important;
            height: 812px !important;
            background: #FFFFFF 0% 0% no-repeat padding-box;
            box-shadow: 0px 2px 5px #00000029;
            border-radius: 6px;
            opacity: 1;
        }

        .logo img {
            top: 102px;
            left: 554px;
            margin-left: auto;
            margin-right: auto;
        }

        .buttons {
            background-color: #00D37C;
        }

        .criar-conta-text {
            top: 247px;
            left: 471px;
            width: 89px;
            height: 22px;
            text-align: left;
            font: normal normal bold 16px/22px Open Sans;
            letter-spacing: 0px;
            color: #707070;
            opacity: 1;
            font-size: 24px;
            width: 600px;
        }

        .custom-input-style {
            top: 311px;
            left: 471px;
            width: 372px;
            height: 56px;

            background: #FFFFFF 0% 0% no-repeat padding-box;
            border: 0.5px solid #707070;
            opacity: 1;
        }

        .custom-labels {
            top: 282px;
            left: 471px;
            width: 46px;
            height: 22px;
            text-align: left;
            font: normal normal normal 16px/22px Open Sans;
            letter-spacing: 0px;
            color: #707070;
            opacity: 1;
            margin-top: 20px;
            margin-bottom: 5px;
        }
        input{
            width: 100% !important;
        }
    </style>
</head>
<body>
<div class="font-sans antialiased">
    {{ $slot }}
</div>
</body>
</html>

