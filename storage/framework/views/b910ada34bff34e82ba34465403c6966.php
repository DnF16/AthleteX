<?php $__env->startSection('title', 'Coach Lists'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between px-4">
        <a href="<?php echo e(route('coaches.create')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Back to Profile
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Coach Lists</h1>
        <div class="w-[150px]"></div> <!-- Spacer -->
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm border space-y-2">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <!-- Search Input -->
            <input type="text" id="coachSearchInput" placeholder="Search name, ID…" 
                class="border border-gray-300 rounded px-3 py-2 text-sm w-full focus:ring-2 focus:ring-green-500 outline-none">

            <!-- Sports Select -->
            <select id="coachSportFilter" class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">All Sports</option>
                <option value="Basketball">Basketball</option>
                <option value="Volleyball">Volleyball</option>
                <option value="Athletics">Athletics</option>
                <option value="Swimming">Swimming</option>
                <option value="Taekwondo">Taekwondo</option>
                <option value="Chess">Chess</option>
                <option value="Football">Football</option>
                <option value="Boxing">Boxing</option>
            </select>

            <!-- Status Select -->
            <select id="coachStatusFilter" class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">All Statuses</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Transfered">Transfered</option>
                <option value="Graduated">Graduated</option>
            </select>

            <!-- Position Select -->
            <select id="coachPositionFilter" class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">All Positions</option>
                <option value="Head Coach">Head Coach</option>
                <option value="Assistant Coach">Assistant Coach</option>
                <option value="Trainer">Trainer</option>
                <option value="Manager">Manager</option>
                <option value="Other">Other</option>
            </select>
        </div>
    </div>

    <!-- 🚀 CLEANED UP TABLE -->
    <div class="bg-white rounded-xl shadow overflow-hidden border">
        <div class="overflow-x-auto">
        <table class="w-full table-auto text-sm whitespace-nowrap" id="coachTable">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border-b text-center">Photo</th>
                    <th class="px-4 py-3 border-b text-left">Coach ID</th>
                    <th class="px-4 py-3 border-b text-left">Full Name</th>
                    <th class="px-4 py-3 border-b text-left">Sports Event</th>
                    <th class="px-4 py-3 border-b text-left">Position</th>
                    <th class="px-4 py-3 border-b text-center">Status</th>
                    <th class="px-4 py-3 border-b text-center sticky right-0 bg-gray-100 z-10 shadow-sm">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php 
                        $statusText = empty($coach->coach_status) ? 'Active' : $coach->coach_status; 
                    ?>
                    <tr class="coach-row hover:bg-gray-50 transition" 
                        data-status="<?php echo e($statusText); ?>"
                        data-sport="<?php echo e($coach->coach_sport_event); ?>"
                        data-position="<?php echo e($coach->position); ?>">
                        
                        <td class="px-4 py-3 text-center">
                            <?php if($coach->coach_picture): ?>
                                <img src="<?php echo e(asset('storage/' . $coach->coach_picture)); ?>" class="w-10 h-10 object-cover rounded-full mx-auto border border-gray-300 shadow-sm">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-gray-200 rounded-full mx-auto flex items-center justify-center text-gray-500 border border-gray-300 shadow-sm">
                                    <i class="bi bi-person"></i>
                                </div>
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-3 text-gray-600 searchable-id font-medium"><?php echo e($coach->id); ?></td>
                        
                        <!-- Combined Name Column -->
                        <td class="px-4 py-3 font-semibold text-gray-900 searchable-name">
                            <?php echo e($coach->coach_last_name); ?>, <?php echo e($coach->coach_first_name); ?> <?php echo e($coach->coach_middle_initial); ?>.
                        </td>
                        
                        <td class="px-4 py-3 text-gray-700"><?php echo e($coach->coach_sport_event); ?></td>
                        <td class="px-4 py-3 text-gray-700"><?php echo e($coach->position ?: 'Coach'); ?></td>
                        
                        <td class="px-4 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold <?php echo e($statusText === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800'); ?>">
                                <?php echo e($statusText); ?>

                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-center sticky right-0 bg-white z-10 shadow-sm border-l">
                            <a href="<?php echo e(route('coaches.create', ['coach_id' => $coach->id])); ?>" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded text-xs font-semibold transition flex items-center justify-center gap-1">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            No coaches found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<script>
    function applyCoachFilters() {
        const searchInput = document.getElementById('coachSearchInput').value.toLowerCase();
        const sportFilter = document.getElementById('coachSportFilter').value.toLowerCase();
        const statusFilter = document.getElementById('coachStatusFilter').value.toLowerCase();
        const positionFilter = document.getElementById('coachPositionFilter').value.toLowerCase();
        
        const rows = document.querySelectorAll('.coach-row');

        rows.forEach(row => {
            const rowSport = (row.getAttribute('data-sport') || '').toLowerCase();
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
            const rowPosition = (row.getAttribute('data-position') || '').toLowerCase();
            
            const names = Array.from(row.querySelectorAll('.searchable-name')).map(td => td.textContent.toLowerCase()).join(' ');
            const id = row.querySelector('.searchable-id').textContent.toLowerCase();
            const matchesSearch = names.includes(searchInput) || id.includes(searchInput);

            if (matchesSearch &&
                (sportFilter === "" || rowSport.includes(sportFilter)) &&
                (statusFilter === "" || rowStatus === statusFilter) &&
                (positionFilter === "" || rowPosition === positionFilter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('coachSearchInput').addEventListener('input', applyCoachFilters);
    document.getElementById('coachSportFilter').addEventListener('change', applyCoachFilters);
    document.getElementById('coachStatusFilter').addEventListener('change', applyCoachFilters);
    document.getElementById('coachPositionFilter').addEventListener('change', applyCoachFilters);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/c_lists/coach_lists.blade.php ENDPATH**/ ?>