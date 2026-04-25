<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bellbox</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


    <meta name="description" content="Nikmati Makan Lezat dan Sehat Setiap Hari Bersama Catering Harian BellBox!" />
    <meta name="keywords" content="Nikmati Makan Lezat dan Sehat Setiap Hari Bersama Catering Harian BellBox!" />

    <!-- Facebook Meta Tags -->
    {{-- <meta property="og:url" content="https://willbegraced.com/"> --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="Bellbox">
    <meta property="og:description"
        content="Nikmati Makan Lezat dan Sehat Setiap Hari Bersama Catering Harian BellBox!">
    <meta property="og:image" content="{{ asset('images/logo.jpeg') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <!-- As you can see, we will use vite with jsx syntax for React-->
    @inertiaHead
</head>

<body class="bg-gray-100">
    @inertia
</body>

</html>
