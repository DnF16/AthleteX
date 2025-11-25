<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATHLETIX Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen" style="background-image: url('<?php echo e(asset('images/bg.jpg')); ?>');">

    <div class="bg-[#2e4e1f] p-8 rounded-xl shadow-md w-full max-w-md text-center">
        <!-- Logo -->
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="UC Logo" class="mx-auto mb-6 w-24 h-24">

        <h2 class="text-2xl font-bold mb-6 text-white">ATHLETIX Login</h2>

        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-4 text-left">
                <label for="email" class="block text-white font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded px-3 py-2" required autofocus>
            </div>

            <div class="mb-4 text-left">
                <label for="password" class="block text-white font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded hover:bg-green-800 transition">
                Login
            </button>
        </form>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views\log\login.blade.php ENDPATH**/ ?>