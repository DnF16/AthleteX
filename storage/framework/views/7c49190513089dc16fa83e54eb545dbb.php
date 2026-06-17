<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'AthleteX'); ?></title>
    
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">

</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        
        <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="flex-1 ml-64">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </div>

    
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>

</body>
</html><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/layouts/app.blade.php ENDPATH**/ ?>