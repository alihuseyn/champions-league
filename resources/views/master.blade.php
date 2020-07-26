<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
    <title>Insider (Formerly SOCIAPlus) Champions League</title>
</head>
<body class="bg-light">
    @yield('body')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
