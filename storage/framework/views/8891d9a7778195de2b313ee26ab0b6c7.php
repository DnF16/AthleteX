<?php $__env->startSection('title', 'Attendance'); ?>

<?php $__env->startSection('content'); ?>
<div id="tab-content" class="bg-[#c5e0b4] p-6 rounded w-full  min-h-screen">
    <div class="bg-white border-[12px] border-[#d1e9f0] p-1 shadow-sm">

        <!-- Page Header -->
        <div class="bg-[#5bc0de] p-3 flex items-center justify-between mb-6">
            <div class="flex-1 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-0">Attendance</h1>
                <?php if(isset($today)): ?>
                    <p class="text-sm text-gray-600">Today: <?php echo e(\Carbon\Carbon::parse($today)->format('l, F j, Y')); ?></p>
                <?php endif; ?>
            </div>
            <div>
                <a href="<?php echo e(route('attendance.history')); ?>" 
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    📊 Attendance History
                </a>
            </div>
        </div>

        <!-- Admin Filter -->
        <?php if(auth()->user()->role === 'admin'): ?>
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <!-- Sport Filter -->
            <select name="sport" onchange="this.form.submit()" class="border rounded px-3 py-2">
                <option value="">All Sports</option>
                <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sport->id); ?>" <?php echo e(request('sport') == $sport->id ? 'selected' : ''); ?>>
                        <?php echo e($sport->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <!-- Month Filter -->
            <select name="month" onchange="this.form.submit()" class="border rounded px-3 py-2">
                <option value="">All Months</option>
                <?php
                    $months = [
                        '01' => 'January', '02' => 'February', '03' => 'March',
                        '04' => 'April', '05' => 'May', '06' => 'June',
                        '07' => 'July', '08' => 'August', '09' => 'September',
                        '10' => 'October', '11' => 'November', '12' => 'December'
                    ];
                ?>
                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($num); ?>" <?php echo e(request('month') == $num ? 'selected' : ''); ?>>
                        <?php echo e($name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <!-- Date Filter -->
            <input type="date" name="date" value="<?php echo e(request('date')); ?>" onchange="this.form.submit()"
                class="border rounded px-3 py-2" />
        </form>
        <?php endif; ?>

        <!-- Coach Attendance Checking -->
        <?php if(auth()->user()->role === 'coach'): ?>
        <div class="flex justify-start mt-4 mb-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                <i class="bi bi-clipboard-check me-1"></i>
                Check Attendance
            </button>
        </div>
        <?php endif; ?>

        <!-- Attendance Table -->
        <div class="bg-[#f8f9fa] rounded shadow p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#d1e9f0]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Athlete</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sport</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(auth()->user()->role === 'coach' && isset($athletesWithStatus)): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $athletesWithStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($index + 1); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($athlete['first_name']); ?> <?php echo e($athlete['last_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($athlete['sport_event']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($athlete['status'] === 'present'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Present</span>
                                    <?php elseif($athlete['status'] === 'absent'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                    <?php elseif($athlete['status'] === 'late'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                    <?php elseif($athlete['status'] === 'excused'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Excused</span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Not Marked</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($athlete['remarks'] ?? '—'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($athlete['attendance_date']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($athlete['isEditable'] && $athlete['attendance_date'] === $today): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">✏️ Today</span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">📋 History</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No athletes assigned yet.</td>
                            </tr>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($index + 1); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($attendance->athlete->first_name); ?> <?php echo e($attendance->athlete->last_name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($attendance->athlete->sport_event); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($attendance->status === 'present'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Present</span>
                                    <?php elseif($attendance->status === 'absent'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                    <?php elseif($attendance->status === 'late'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                    <?php elseif($attendance->status === 'excused'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Excused</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($attendance->remarks ?? '—'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e(is_string($attendance->date) ? \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') : $attendance->date->format('Y-m-d')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No attendance records found.</td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- attendance modal -->
        <div class="modal fade" id="attendanceModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Mark Attendance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form method="POST" action="<?php echo e(route('coach.attendance.store')); ?>">
                            <?php echo csrf_field(); ?>

                    <!-- Date Picker -->
                    <div class="mb-3">
                        <label class="form-label font-bold">Date (Today Only)</label>
                        <input type="date" name="attendance_date" class="form-control" value="<?php echo e(isset($today) ? $today : now()->toDateString()); ?>" readonly>
                        <small class="text-muted">Attendance can only be recorded for today.</small>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info mb-3 text-sm" role="alert">
                        <strong>📋 How it works:</strong> Mark attendance today using the status buttons below. Tomorrow, new attendance records for that date will automatically become available. Past records remain in the <strong>Attendance History</strong>.
                    </div>

                            <!-- Athlete Attendance Table -->
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Athlete</th>
                                            <th>Sports</th>
                                            <th>Status</th>
                                            <th>Remarks (Optional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $athletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td><?php echo e($athlete->first_name); ?> <?php echo e($athlete->last_name); ?></td>
                                            <td><?php echo e($athlete->sport_event); ?></td>
                                            <td>
                                                <input type="hidden" name="attendance[<?php echo e($athlete->id); ?>][status]" value="present" class="attendance-hidden">
                                                <button type="button" class="btn btn-sm btn-outline-success attendance-toggle" title="Click to cycle through statuses">
                                                    Present
                                                </button>
                                            </td>
                                            <td>
                                                <input type="text" name="attendance[<?php echo e($athlete->id); ?>][remarks]" class="form-control form-control-sm" placeholder="e.g., Injured, Early dismissal">
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Attendance</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statuses = ['present', 'absent', 'late', 'excused'];
    const statusLabels = {
        'present': 'Present',
        'absent': 'Absent',
        'late': 'Late',
        'excused': 'Excused'
    };
    const statusClasses = {
        'present': 'btn-outline-success',
        'absent': 'btn-outline-danger',
        'late': 'btn-outline-warning',
        'excused': 'btn-outline-info'
    };

    document.querySelectorAll('.attendance-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const hiddenInput = this.previousElementSibling; // hidden input
            let currentStatus = hiddenInput.value;
            let currentIndex = statuses.indexOf(currentStatus);
            let nextIndex = (currentIndex + 1) % statuses.length;
            let nextStatus = statuses[nextIndex];

            // Update hidden input
            hiddenInput.value = nextStatus;

            // Update button text
            this.textContent = statusLabels[nextStatus];

            // Update button color
            this.className = 'btn btn-sm ' + statusClasses[nextStatus] + ' attendance-toggle';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AthleteX\resources\views/features/attendance.blade.php ENDPATH**/ ?>