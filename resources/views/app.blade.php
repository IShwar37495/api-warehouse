<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Api Warehouse.">
    @if (app()->environment('production'))
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif


    <title inertia>{{ config('app.name', 'Api-Warehouse') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    <div
        style="
                padding: 0;
                margin: 0;
                overflow: hidden;
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-weight: bold;
                width: 180px;
                height: 150px;
                display: block;
                position: relative;
                color: black !important;
                background-color: black !important;
            ">
        <a target="_blank" href="https://jetdate.in/male-escorts-in-chandigarh" title="Ansh - Male Escort in Chandigarh"
            style="
                    padding: 0;
                    margin: 0;
                    overflow: hidden;
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                "><img
                src="https://jetdate.in/banners/jd-square_v2.jpg" alt="Male Escorts in Chandigarh - JetDate"
                style="
                        padding: 0;
                        margin: 0;
                        overflow: hidden;
                        display: block;
                        position: relative;
                        background-color: black !important;
                    " /><span
                style="
                        padding: 0;
                        margin: 0;
                        overflow: hidden;
                        font-family: 'Helvetica Neue', Helvetica, Arial,
                            sans-serif;
                        font-weight: bold;
                        display: block;
                        text-align: center;
                        position: absolute;
                        top: 0;
                        left: 0;
                        line-height: 1.1;
                        text-align: left;
                        padding-left: 5px;
                        text-shadow: 0 2px 2px rgba(255, 255, 255, 0.8);
                        color: black !important;
                        font-size: 20px !important;
                    ">Male
                Escort in Chandigarh</span></a>
        <div
            style="
                    padding: 0;
                    margin: 0;
                    overflow: hidden;
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    font-weight: bold;
                    display: flex;
                    align-items: center;
                    position: absolute;
                    left: 5px;
                    top: 122px;
                    width: 170px;
                    height: 26px;
                    color: black !important;
                ">
            <a target="_blank" href="https://jetdate.in/male-escorts-in-chandigarh"
                title="Male Escorts in Chandigarh - JetDate"
                style="
                        padding: 0;
                        margin: 0;
                        font-family: 'Helvetica Neue', Helvetica, Arial,
                            sans-serif;
                        font-weight: bold;
                        text-align: left;
                        text-wrap: balance;
                        text-transform: uppercase;
                        text-decoration: underline;
                        line-height: 1.1;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        -webkit-line-clamp: 2;
                        overflow-wrap: break-word;
                        flex-grow: 1;
                        color: #c49318 !important;
                        font-size: 12px !important;
                    ">GFE
                in Chandigarh</a>
        </div>
    </div>
    @inertia
</body>

</html>
