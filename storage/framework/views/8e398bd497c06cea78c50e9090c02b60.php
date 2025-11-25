<?php $__env->startSection('title', 'Schedule'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 w-full">

    <!-- Page Header -->
    <div class="bg-white p-6 flex items-center justify-between shadow rounded">
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Schedule</h1>
        </div>
        <div>
            <a href="#"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Add New Schedule
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white p-6 rounded shadow flex flex-wrap gap-4">

        <div class="flex flex-col">
            <label class="text-gray-700 font-medium mb-1">Select Sport</label>
            <select class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                <option>All Sports</option>
                <option>Basketball</option>
                <option>Volleyball</option>
                <option>Swimming</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-gray-700 font-medium mb-1">Select Athlete</label>
            <select class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                <option>All Athletes</option>
                <option>John Doe</option>
                <option>Jane Smith</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-gray-700 font-medium mb-1">Week</label>
            <input type="week" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>

        <div class="flex items-end">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Filter
            </button>
        </div>
    </div>

        <?php
    // Get the current month and year, you can replace these with request values
    $month = request('month') ? date('m', strtotime(request('month'))) : date('m');
    $year = request('month') ? date('Y', strtotime(request('month'))) : date('Y');

    $firstDayOfMonth = strtotime("$year-$month-01");
    $daysInMonth = date('t', $firstDayOfMonth);
    $startDayOfWeek = date('w', $firstDayOfMonth); // 0=Sunday, 6=Saturday

    // Array of weekdays
    $weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
?>

<div class="space-y-6 w-full">
    <!-- Calendar Grid -->
    <div class="bg-white rounded shadow p-6 overflow-x-auto">
        <!-- Weekday Headers -->
        <div class="grid grid-cols-7 gap-2 text-center font-medium text-gray-700 mb-2">
            <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($day); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Calendar Days -->
        <div class="grid grid-cols-7 gap-2">
            
            <?php for($i = 0; $i < $startDayOfWeek; $i++): ?>
                <div class="border border-gray-200 rounded p-2 h-32 bg-gray-50"></div>
            <?php endfor; ?>

            
            <?php for($day = 1; $day <= $daysInMonth; $day++): ?>
                <?php
                    $currentDate = date('Y-m-d', strtotime("$year-$month-$day"));
                    // Example events (replace with real data)
                    $events = [
                        '2025-10-03' => [
                            ['title'=>'Basketball Practice','color'=>'green'],
                            ['title'=>'Swimming Training','color'=>'blue']
                        ],
                        '2025-10-04' => [
                            ['title'=>'Volleyball Match','color'=>'yellow']
                        ]
                    ];
                ?>
                <div class="border border-gray-200 rounded p-2 h-32 flex flex-col justify-start">
                    <span class="text-xs font-medium text-gray-500"><?php echo e($day); ?></span>

                    <?php if(isset($events[$currentDate])): ?>
                        <?php $__currentLoopData = $events[$currentDate]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $bgColor = match($event['color']){
                                    'green'=>'bg-green-100 text-green-800',
                                    'blue'=>'bg-blue-100 text-blue-800',
                                    'yellow'=>'bg-yellow-100 text-yellow-800',
                                    default=>'bg-gray-100 text-gray-800'
                                };
                            ?>
                            <div class="mt-1 <?php echo e($bgColor); ?> text-xs rounded px-1 py-0.5">
                                <?php echo e($event['title']); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>

</div>

    <!-- Detailed Schedule Table -->
    <div class="bg-white rounded shadow p-6 overflow-x-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Detailed Schedule</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Time</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Athlete</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Sport</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Activity</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Coach</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-800">Oct 7, 2025</td>
                    <td class="px-4 py-2 text-sm text-gray-800">10:00 AM - 12:00 PM</td>
                    <td class="px-4 py-2 text-sm text-gray-800">John Doe</td>
                    <td class="px-4 py-2 text-sm text-gray-800">Basketball</td>
                    <td class="px-4 py-2 text-sm text-gray-800">Practice</td>
                    <td class="px-4 py-2 text-sm text-gray-800">Coach Smith</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-800">Oct 9, 2025</td>
                    <td class="px-4 py-2 text-sm text-gray-800">2:00 PM - 4:00 PM</td>
                    <td class="px-4 py-2 text-sm text-gray-800">Jane Smith</td>
                    <td class="px-4 py-2 text-sm text-gray-800">Swimming</td>
                    <td class="px-4 py-2 text-sm text-gray-800">Training</td>
                    <td class="px-4 py-2 text-sm text-gray-800">Coach Lee</td>
                </tr>
                <!-- More rows -->
            </tbody>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/features/schedule.blade.php ENDPATH**/ ?>