<aside class="fixed top-0 left-0 w-64 h-screen bg-[#2e4e1f] text-white flex flex-col p-6 z-50">
    <a href="#" class="flex items-center mb-6 text-lg font-bold no-underline text-white">
        SPORTS OFFICE
    </a>

   <?php if(auth()->check()): ?>
    <div class="flex items-center mb-6 p-2 bg-[#3b5d28] rounded">
        <i class="bi bi-person-circle mr-2 text-2xl"></i>
        <span class="font-semibold text-sm">
            <?php if(auth()->user()->role === 'coach'): ?>
                Coach: <?php echo e(auth()->user()->coach ? auth()->user()->coach->coach_first_name . ' ' . auth()->user()->coach->coach_last_name : auth()->user()->name); ?>

            <?php elseif(auth()->user()->role === 'admin'): ?>
                Admin: <?php echo e(auth()->user()->name); ?>

            <?php else: ?>
                <?php echo e(auth()->user()->name); ?>

            <?php endif; ?>
        </span>
    </div>
   <?php endif; ?>

    <!-- Added flex and flex-col here so mt-auto on Logout works perfectly -->
    <nav class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden pr-2"> 
        
        <!-- CHANGED w-max to w-full so it stays inside the sidebar! -->
        <ul class="space-y-2 w-full"> 

            <li>
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('student.athlete')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-person-walking mr-2"></i> Student–Athletes
                </a>
            </li>
            <?php
                $attendanceRoute = auth()->user()->role === 'admin'
                    ? route('admin.attendance')
                    : route('coach.attendance.index');
            ?>

            <li>
                <a href="<?php echo e($attendanceRoute); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-calendar2-week mr-2"></i> Attendance
                </a>
            </li>
            <?php
                $reportsRoute = auth()->user()->role === 'admin'
                    ? route('admin.reports')
                    : route('coach.reports.index');
            ?>

            <li>
                <a href="<?php echo e($reportsRoute); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-journal-text mr-2"></i> Reports
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('coach')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-people-fill mr-2"></i> Coaches
                </a>
            </li>
            
            
            <!-- <li>
                <a href="<?php echo e(route('schedule')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-calendar2-week mr-2"></i> Schedule
                </a>
            </li> -->
            <!-- <li>
                <a href="#" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-trophy-fill mr-2 text-yellow-400"></i> Achievements
                </a>
            </li> -->
            <!-- <li>
                <a href="#" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-clipboard-check mr-2"></i> Exams
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-cash-stack mr-2"></i> Transactions
                </a>
            </li> -->

            
            <?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
                <li>
                    <a href="<?php echo e(route('admin.approvals')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-bell-fill mr-2"></i> Athlete Approvals
                        
                        <!-- 🚀 THE NOTIFICATION BADGE -->
                        <?php
                            $pendingCount = \App\Models\Athlete::where('approval_status', 'pending')->count();
                        ?>

                        <?php if($pendingCount > 0): ?>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full ml-auto">
                                <?php echo e($pendingCount); ?>

                            </span>
                        <?php endif; ?>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo e(route('admin.tryouts.index')); ?>" class="flex items-center px-3 py-2 rounded <?php echo e(request()->routeIs('admin.tryouts.index') ? 'bg-[#446634]' : 'bg-[#3b5d28]'); ?> font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-calendar-event mr-2"></i> Manage Tryouts
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('admin.blockchain')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-shield-lock-fill mr-2 text-green-400"></i> Security Ledger
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('admin.general')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-person-gear mr-2"></i> Admin
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('sports')); ?>" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-trophy mr-2"></i> Sports 
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <div class="mt-auto pt-4">
            <a href="<?php echo e(route('login')); ?>" class="w-full block text-center px-4 py-2 rounded bg-red-600 hover:bg-red-700 transition text-white no-underline font-bold">
                Logout
            </a>
        </div>
    </nav>
</aside><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>