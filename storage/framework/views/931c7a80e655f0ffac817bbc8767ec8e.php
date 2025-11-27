<aside class="fixed top-0 left-0 w-64 h-screen bg-[#2e4e1f] text-white flex flex-col p-4 z-50">
    <a href="#" class="flex items-center mb-6 text-lg font-bold no-underline text-white">
        SPORTS OFFICE
    </a>

    <nav class="flex-1">
        <ul class="space-y-2">
            <li>
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('student.athlete')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-person-walking mr-2"></i> Student–Athletes
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('coach')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-people-fill mr-2"></i> Coaches
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('schedule')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-calendar2-week mr-2"></i> Schedule
                </a>
            </li>
            
            </li>
            <li>
                <a href="<?php echo e(route('admin.general')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-person-gear mr-2"></i> Admin
                </a>
            </li>
        </ul>

        <div class="mt-auto pt-4">
            <a href="<?php echo e(route('log.login')); ?>" class="w-full block text-center px-4 py-2 rounded bg-red-600 hover:bg-red-700 transition text-white no-underline font-bold">
                Logout
            </a>
        </div>
    </nav>
</aside><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>