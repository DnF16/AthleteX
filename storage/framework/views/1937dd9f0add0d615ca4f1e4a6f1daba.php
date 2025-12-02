<?php $__env->startSection('title', 'Athlete Approvals'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 w-full">
    <!-- Page Header -->
    <div class="bg-white p-6">
        <h1 class="text-3xl font-bold text-gray-800">Athlete Approvals</h1>
        <p class="text-gray-600 mt-2">Review and approve athlete submissions from coaches</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="bg-red-50 border border-red-200 rounded p-4">
            <div class="text-red-800 font-semibold">Errors:</div>
            <ul class="text-red-700 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>• <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 rounded p-4 text-green-800">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Pending Approvals Tab -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <div class="px-6 py-4 bg-yellow-50">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="bi bi-hourglass-split text-yellow-600 mr-2"></i>
                    Pending Approvals (<?php echo e($pendingAthletes->count()); ?>)
                </h2>
            </div>
        </div>

        <?php if($pendingAthletes->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Athlete Name</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Coach</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Sport</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Submitted</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendingAthletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">
                                        <?php echo e($athlete->first_name); ?> <?php echo e($athlete->last_name); ?>

                                    </div>
                                    <div class="text-sm text-gray-500">ID: <?php echo e($athlete->student_id); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700">
                                        <?php echo e($athlete->coach?->coach_first_name); ?> <?php echo e($athlete->coach?->coach_last_name ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        <?php echo e($athlete->coach_sport_event ?? $athlete->sport ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?php echo e($athlete->created_at ? (is_string($athlete->created_at) ? $athlete->created_at : $athlete->created_at->format('M d, Y H:i')) : 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="<?php echo e(route('approvals.show', $athlete)); ?>"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-semibold">
                                            View
                                        </a>
                                        <form action="<?php echo e(route('approvals.approve', $athlete)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-semibold"
                                                onclick="return confirm('Approve this athlete?');">
                                                Approve
                                            </button>
                                        </form>
                                        <button onclick="openDeclineModal(<?php echo e($athlete->id); ?>)"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-semibold">
                                            Decline
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-8 text-center text-gray-500">
                <i class="bi bi-check-circle text-4xl text-green-500 mb-3"></i>
                <p class="font-semibold">No pending approvals!</p>
                <p class="text-sm">All athlete submissions have been reviewed.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recently Approved -->
    <?php if($approvedAthletes->count() > 0): ?>
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200">
                <div class="px-6 py-4 bg-green-50">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="bi bi-check-circle text-green-600 mr-2"></i>
                        Recently Approved
                    </h2>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Athlete Name</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Coach</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Approved By</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Approved Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $approvedAthletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-800">
                                        <?php echo e($athlete->first_name); ?> <?php echo e($athlete->last_name); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <?php echo e($athlete->coach?->coach_first_name); ?> <?php echo e($athlete->coach?->coach_last_name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <?php echo e($athlete->approver?->name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?php echo e($athlete->approved_at?->format('M d, Y H:i') ?? 'N/A'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <!-- Recently Declined -->
    <?php if($declinedAthletes->count() > 0): ?>
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200">
                <div class="px-6 py-4 bg-red-50">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="bi bi-x-circle text-red-600 mr-2"></i>
                        Recently Declined
                    </h2>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Athlete Name</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Coach</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Declined By</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $declinedAthletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-800">
                                        <?php echo e($athlete->first_name); ?> <?php echo e($athlete->last_name); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <?php echo e($athlete->coach?->coach_first_name); ?> <?php echo e($athlete->coach?->coach_last_name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <?php echo e($athlete->approver?->name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <span class="text-xs"><?php echo e($athlete->approval_notes ?? 'No reason provided'); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Decline Modal -->
<div id="declineModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Decline Athlete Submission</h2>
        <form id="declineForm" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label for="approval_notes" class="block text-sm font-semibold text-gray-700 mb-2">Reason for Decline</label>
                <textarea id="approval_notes" name="approval_notes" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                    placeholder="Please provide a reason for declining this athlete..."
                    rows="4"></textarea>
                <p class="text-xs text-gray-500 mt-1">This will be sent to the coach</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeDeclineModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded hover:bg-gray-50 text-gray-800 font-semibold">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">
                    Decline
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeclineModal(athleteId) {
        const form = document.getElementById('declineForm');
        form.action = `/approvals/${athleteId}/decline`;
        document.getElementById('declineModal').classList.remove('hidden');
    }

    function closeDeclineModal() {
        document.getElementById('declineModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('declineModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeclineModal();
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/features/approvals.blade.php ENDPATH**/ ?>