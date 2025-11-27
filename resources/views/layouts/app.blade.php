<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AthleteX')</title>
<<<<<<< HEAD
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Ensures the main content wrapper has the correct background */
        .content-area-wrapper {
            background-color: #f3f4f6; /* Tailwind gray-100 equivalent */
            min-height: 100vh;
        }
    </style>
=======
    <!-- Tailwind (CDN fallback) -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="https://cdn.tailwindcss.com" onerror="this.onerror=null;this.src='/js/tailwind.min.js'"></script>

>>>>>>> af7ac3879a49a4a8dd05e88da8fbdfe72905d477
</head>
<body class="bg-gray-50">

    @include('partials.sidebar')

    <main class="ml-64 flex-1 p-0 overflow-y-auto min-h-screen"> 
        <div class="content-area-wrapper">
             @yield('content') 
        </div>
    </main>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>