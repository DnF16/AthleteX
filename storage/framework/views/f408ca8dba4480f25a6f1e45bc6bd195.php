<?php $__env->startSection('title', 'Coach Lists'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between px-4">
        <a href="<?php echo e(route('coaches.create')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            + New Coach
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Coach Lists</h1>
    </div>

    <!-- Filters -->
    <div class="bg-white p-2 rounded-lg shadow space-y-2">
        <div class="md:grid-cols-4 gap-2">
            <!-- Search Input -->
            <input type="text" placeholder="Search name, ID…" 
                class="border rounded px-2 py-1 text-sm w-full max-w-xs">

            <!-- Sports Select -->
            <select class="border rounded px-2 py-1 text-sm w-full max-w-xs">
                <option value="">All Sports</option>
                <!-- loop sports -->
            </select>

            <!-- Status Select -->
            <select class="border rounded px-2 py-1 text-sm w-full max-w-xs">
                <option value="">Status</option>
                <option>Active</option>
                <option>Injured</option>
                <option>Inactive</option>
            </select>

            <!-- Classification Select -->
            <select class="border rounded px-2 py-1 text-sm w-full max-w-xs">
                <option value="">Classification</option>
                <option>Varsity</option>
                <option>Trainee</option>
                <option>Reserve</option>
            </select>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow overflow-auto">
        <table class="w-full table-auto text-sm">
            <thead class="bg-gray-100 text-gray-700 top-0">
                <tr>
                    <th class="px-4 py-3 border">Last Name</th>
                    <th class="px-4 py-3 border">First Name, MI</th>
                    <th class="px-4 py-3 border">Full Name</th>
                    <th class="px-4 py-3 border">Coach ID</th>
                    <th class="px-4 py-3 border">Sports Event</th>
                    <th class="px-4 py-3 border">Position</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Gender</th>
                    <th class="px-4 py-3 border">Birthdate</th>
                    <th class="px-4 py-3 border">Age</th>
                    <th class="px-4 py-3 border">Blood Type</th>
                    <th class="px-4 py-3 border">Email</th>
                    <th class="px-4 py-3 border">FB Link</th>
                    <th class="px-4 py-3 border">Marital Status</th>
                    <th class="px-4 py-3 border">Contact #</th>
                    <th class="px-4 py-3 border">Address</th>
                    <th class="px-4 py-3 border">City</th>
                    <th class="px-4 py-3 border">Province</th>
                    <th class="px-4 py-3 border">Zip Code</th>
                    <th class="px-4 py-3 border">Emergency Contact Person</th>
                    <th class="px-4 py-3 border">Emergency #</th>
                    <th class="px-4 py-3 border">Date Hired</th>
                    <th class="px-4 py-3 border">Honorarium Payment</th>
                    <th class="px-4 py-3 border">Date Resigned</th>
                    <th class="px-4 py-3 border">Occupation</th>
                    <th class="px-4 py-3 border">Current Company</th>
                    <th class="px-4 py-3 border">Picture</th>
                    <th class="px-4 py-3 border">Notes</th>
                    <th class="px-4 py-3 border">Inactive Date</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='<?php echo e(route('coaches.show', $coach->id)); ?>'">
                        <td class="border px-4 py-2"><?php echo e($coach->coach_last_name); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_first_name); ?> <?php echo e($coach->coach_middle_initial); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_first_name); ?> <?php echo e($coach->coach_middle_initial); ?> <?php echo e($coach->coach_last_name); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->id); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_sport_event); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->position); ?></td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 rounded text-white <?php echo e($coach->coach_status === 'Active' ? 'bg-green-600' : 'bg-gray-500'); ?> text-xs">
                                <?php echo e($coach->coach_status ?? 'N/A'); ?>

                            </span>
                        </td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_gender); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_birthdate); ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo e($coach->coach_age); ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo e($coach->coach_blood_type); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_email); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_facebook); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_marital_status); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_contact_number); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_address); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_city_municipality); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_province_state); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_zip_code); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_emergency_person); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_emergency_contact); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->date_hired); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->honorarium_payment); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->date_resigned); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->occupation); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_current_company); ?></td>
                        <td class="border px-4 py-2">
                            <?php if($coach->coach_picture): ?>
                                <img src="<?php echo e(asset('storage/' . $coach->coach_picture)); ?>" class="w-16 h-16 object-cover rounded">
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">No Picture</span>
                            <?php endif; ?>
                        </td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_notes); ?></td>
                        <td class="border px-4 py-2"><?php echo e($coach->coach_inactive_date); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="29" class="border px-4 py-4 text-center text-gray-500">
                            No coaches found. <a href="<?php echo e(route('coaches.create')); ?>" class="text-green-600 hover:underline">Create one</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/c_lists/coach_lists.blade.php ENDPATH**/ ?>