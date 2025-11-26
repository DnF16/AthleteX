<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AthleteX')</title>
    <!-- Tailwind (CDN fallback) -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="https://cdn.tailwindcss.com" onerror="this.onerror=null;this.src='/js/tailwind.min.js'"></script>

</head>
<body>

    @include('partials.sidebar')

    

    @stack('scripts')
</body>
</html>
