<?php $__env->startSection('title', 'Attendance History'); ?>

<?php $__env->startSection('content'); ?>
<div id="tab-content" class="bg-[#c5e0b4] p-8 rounded-lg w-full min-h-screen">
    <div class="bg-white border-[12px] border-[#d1e9f0] p-1 shadow-sm">

        <!-- Header -->
        <div class="bg-[#5bc0de] text-white px-4 py-2 flex justify-between items-center">
            <a href="<?php echo e($backRoute); ?>" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <h2 class="text-lg font-bold flex-1 text-center">
                📜 Attendance History - <?php echo e($selectedMonth); ?> <?php echo e($selectedYear); ?>

            </h2>
            <div></div>
        </div>

        <!-- Month & Year Filter (Auto-Submitting) -->
        <form method="GET" action="<?php echo e(route('attendance.history')); ?>" class="p-4 flex flex-wrap gap-4 items-center border-b bg-gray-50 rounded-t-lg">
            
            <div class="flex items-center gap-2">
                <label class="font-bold text-sm text-gray-700">Month:</label>
                <select name="month" onchange="this.form.submit()" class="border-gray-300 rounded px-3 py-1.5 shadow-sm focus:border-green-500 focus:ring-green-500 border">
                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($month); ?>" <?php echo e($selectedMonth == $month ? 'selected' : ''); ?>>
                            <?php echo e($month); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="font-bold text-sm text-gray-700">Year:</label>
                <select name="year" onchange="this.form.submit()" class="border-gray-300 rounded px-3 py-1.5 shadow-sm focus:border-green-500 focus:ring-green-500 border">
                    <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                        <option value="<?php echo e($y); ?>" <?php echo e($selectedYear == $y ? 'selected' : ''); ?>>
                            <?php echo e($y); ?>

                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Sports filter (admin only) -->
            <?php if(auth()->user()->role === 'admin'): ?>
            <div class="flex items-center gap-2">
                <label class="font-bold text-sm text-gray-700">Sport:</label>
                <select name="sport_id" onchange="this.form.submit()" class="border-gray-300 rounded px-3 py-1.5 shadow-sm focus:border-green-500 focus:ring-green-500 border">
                    <option value="">All Sports</option>
                    <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sport->name); ?>" <?php echo e(($sportId ?? '') == $sport->name ? 'selected' : ''); ?>>
                            <?php echo e($sport->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>

            <!-- Clear Button (Only shows if a filter is changed from defaults) -->
            <?php if(request()->has('sport_id') || request()->has('month') || request()->has('year')): ?>
            <a href="<?php echo e(route('attendance.history')); ?>" class="bg-gray-500 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-600 transition shadow-sm">
                Clear
            </a>
            <?php endif; ?>
        </form>

        <!-- Color Key -->
        <div class="flex gap-4 px-4 pb-2 text-[10px] font-bold uppercase">
            <span class="text-gray-600">Color Key:</span>
            <div class="flex items-center gap-1"><span class="w-4 h-4 bg-green-500"></span> Present</div>
            <div class="flex items-center gap-1"><span class="w-4 h-4 bg-yellow-400"></span> Late</div>
            <div class="flex items-center gap-1"><span class="w-4 h-4 bg-blue-400"></span> Excused</div>
            <div class="flex items-center gap-1"><span class="w-4 h-4 bg-red-500"></span> Absent</div>
            <div class="flex items-center gap-1"><span class="w-4 h-4 bg-gray-200 border"></span> No Record</div>
        </div>

        <!-- Monthly Attendance Matrix -->
        <div class="overflow-x-auto mt-4">
            <table class="border-collapse text-xs w-full">
                <thead>
                    <tr class="bg-[#d1e9f0] text-[#333]">
                        <th class="border p-2 sticky left-0 bg-[#d1e9f0] z-10 text-left w-36 min-w-[140px]">
                            Athlete
                        </th>

                        <?php for($day = 1; $day <= $daysInMonth; $day++): ?>
                            <th class="border p-1 text-center w-8">
                                <?php echo e($day); ?>

                            </th>
                        <?php endfor; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $athletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <!-- Athlete Name -->
                            <td class="border p-2 sticky left-0 bg-white font-semibold w-36 min-w-[140px]">
                                <?php echo e($athlete->first_name); ?> <?php echo e($athlete->last_name); ?>

                            </td>

                            <!-- Daily Status -->
                            <?php for($day = 1; $day <= $daysInMonth; $day++): ?>
                                <?php
                                    $date = \Carbon\Carbon::create($selectedYear, date('m', strtotime($selectedMonth)), $day)->format('Y-m-d');
                                    $key = $athlete->id . '_' . $date;
                                    $status = strtolower($attendanceMap[$key]->status ?? '');
                                    $bgColor = match($status){
                                        'present' => 'bg-green-500',
                                        'late' => 'bg-yellow-400',
                                        'excused' => 'bg-blue-400',
                                        'absent' => 'bg-red-500',
                                        default => 'bg-gray-200'
                                    };
                                ?>

                                <td class="border w-8 h-8 <?php echo e($bgColor); ?>"></td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="<?php echo e($daysInMonth + 1); ?>" class="text-center text-gray-500 p-4">
                                No attendance records found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/attendance_history.blade.php ENDPATH**/ ?>