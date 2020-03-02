<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('main/main.css') }}">
    <script type="text/javascript" src="{{ asset('plupload/js/plupload.full.min.js') }}"></script>
</head>
<body>

<div id="app"></div>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

</body>
</html>
