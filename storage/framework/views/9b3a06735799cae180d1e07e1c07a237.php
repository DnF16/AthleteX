

<?php $__env->startSection('title', 'Coach Reports'); ?>

<?php $__env->startSection('content'); ?>
<div id="tab-content" class="bg-white p-6 rounded w-full">
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Coach Reports</h1>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded shadow p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coach</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($report->coach->coach_first_name); ?> <?php echo e($report->coach->coach_last_name); ?></td>
                            <td class="px-6 py-4"><?php echo e($report->title); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                <?php echo e($report->file_name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($report->status === 'pending'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                <?php elseif($report->status === 'received'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                <?php elseif($report->status === 'rejected'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($report->created_at->format('M d, Y H:i')); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <!-- Download Button -->
                                <a href="<?php echo e(route('reports.download', $report->id)); ?>" class="text-blue-600 hover:text-blue-800" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>

                                <?php if($report->status === 'pending'): ?>
                                    <!-- Mark as Received -->
                                    <form method="POST" action="<?php echo e(route('reports.mark-received', $report->id)); ?>" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-800" title="Mark as Received" onclick="return confirm('Mark this report as received?')">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>

                                    <!-- Mark as Rejected -->
                                    <form method="POST" action="<?php echo e(route('reports.mark-rejected', $report->id)); ?>" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Mark as Rejected" onclick="return confirm('Mark this report as rejected?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No reports submitted yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AthleteX\resources\views/features/reports/admin_reports.blade.php ENDPATH**/ ?>