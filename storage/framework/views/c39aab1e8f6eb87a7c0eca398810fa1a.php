<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'AthleteX'); ?></title>
    
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
</head>
<body class="bg-gray-50">

    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="ml-64 flex-1 p-0 overflow-y-auto min-h-screen"> 
        <div class="content-area-wrapper">
             <?php echo $__env->yieldContent('content'); ?> 
        </div>
    </main>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/layouts/app.blade.php ENDPATH**/ ?>