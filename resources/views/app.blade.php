<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Wedding Invitation | Andrea & Kasilda</title>

    <!-- SEO Meta -->
    <meta name="description"
        content="Undangan pernikahan Andrea & Kasilda. Kami mengundang Anda untuk hadir dan memberikan doa restu pada hari bahagia kami." />
    <meta name="keywords" content="wedding invitation, undangan pernikahan, Andrea Kasilda, wedding online invitation" />
    <meta name="author" content="Andrea & Kasilda" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Wedding Invitation | Andrea & Kasilda" />
    <meta property="og:description"
        content="Undangan pernikahan Andrea & Kasilda. Klik untuk melihat detail acara dan lokasi pernikahan." />
    <meta property="og:image" content="{{ asset('images/image.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Andrea & Kasilda Wedding" />

    <!-- Twitter Card (optional tapi bagus) -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Wedding Invitation | Andrea & Kasilda" />
    <meta name="twitter:description" content="Undangan pernikahan Andrea & Kasilda." />
    <meta name="twitter:image" content="{{ asset('images/wedding-cover.jpg') }}" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" />

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @inertiaHead
</head>

<body class="bg-gray-100">
    @inertia
</body>

</html>
