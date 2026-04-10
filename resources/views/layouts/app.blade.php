<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AthleteX')</title>
    
    {{-- Vite CSS - Compiled Tailwind + Custom Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Local Bootstrap CSS (Offline) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        
        @include('partials.sidebar')

        <div class="flex-1 ml-64">
            @yield('content')
        </div>

    </div>

    {{-- Local Bootstrap JS (Offline) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</body>
</html>