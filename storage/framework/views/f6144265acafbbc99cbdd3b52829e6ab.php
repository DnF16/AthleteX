<?php $__env->startSection('title', 'Athlete Master List'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <div class="flex items-center justify-between px-4">
        <a href="<?php echo e(route('student.athlete')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition shadow">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Student Athletes Master List</h1>
    </div>

    <form method="GET" action="<?php echo e(url()->current()); ?>" class="bg-white p-4 rounded-lg shadow space-y-4 border-t-4 border-green-600">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            
            <div class="flex">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search name, ID…" 
                    class="border border-gray-300 rounded-l px-3 py-2 text-sm w-full focus:outline-none focus:border-green-500">
                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-r hover:bg-green-700 transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <select name="sport" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-2 text-sm w-full focus:outline-none focus:border-green-500 bg-white">
                <option value="">All Sports</option>
                
                <optgroup label="Ball Games">
                    <option value="Basketball_Men" <?php echo e(request('sport') == 'Basketball_Men' ? 'selected' : ''); ?>>Basketball (Men)</option>
                    <option value="Basketball_Women" <?php echo e(request('sport') == 'Basketball_Women' ? 'selected' : ''); ?>>Basketball (Women)</option>
                    <option value="Volleyball_Men" <?php echo e(request('sport') == 'Volleyball_Men' ? 'selected' : ''); ?>>Volleyball (Men)</option>
                    <option value="Volleyball_Women" <?php echo e(request('sport') == 'Volleyball_Women' ? 'selected' : ''); ?>>Volleyball (Women)</option>
                    <option value="Football" <?php echo e(request('sport') == 'Football' ? 'selected' : ''); ?>>Football</option>
                    <option value="Softball" <?php echo e(request('sport') == 'Softball' ? 'selected' : ''); ?>>Softball</option>
                    <option value="Baseball" <?php echo e(request('sport') == 'Baseball' ? 'selected' : ''); ?>>Baseball</option>
                </optgroup>
                
                <optgroup label="Racket Sports">
                    <option value="Badminton_Men" <?php echo e(request('sport') == 'Badminton_Men' ? 'selected' : ''); ?>>Badminton (Men)</option>
                    <option value="Badminton_Women" <?php echo e(request('sport') == 'Badminton_Women' ? 'selected' : ''); ?>>Badminton (Women)</option>
                    <option value="Table_Tennis_Men" <?php echo e(request('sport') == 'Table_Tennis_Men' ? 'selected' : ''); ?>>Table Tennis (Men)</option>
                    <option value="Table_Tennis_Women" <?php echo e(request('sport') == 'Table_Tennis_Women' ? 'selected' : ''); ?>>Table Tennis (Women)</option>
                    <option value="Tennis_Men" <?php echo e(request('sport') == 'Tennis_Men' ? 'selected' : ''); ?>>Tennis (Men)</option>
                    <option value="Tennis_Women" <?php echo e(request('sport') == 'Tennis_Women' ? 'selected' : ''); ?>>Tennis (Women)</option>
                </optgroup>
                
                <optgroup label="Combat Sports & Others">
                    <option value="Taekwondo_Men" <?php echo e(request('sport') == 'Taekwondo_Men' ? 'selected' : ''); ?>>Taekwondo (Men)</option>
                    <option value="Taekwondo_Women" <?php echo e(request('sport') == 'Taekwondo_Women' ? 'selected' : ''); ?>>Taekwondo (Women)</option>
                    <option value="Arnis_Men" <?php echo e(request('sport') == 'Arnis_Men' ? 'selected' : ''); ?>>Arnis (Men)</option>
                    <option value="Arnis_Women" <?php echo e(request('sport') == 'Arnis_Women' ? 'selected' : ''); ?>>Arnis (Women)</option>
                    <option value="Boxing" <?php echo e(request('sport') == 'Boxing' ? 'selected' : ''); ?>>Boxing</option>
                    <option value="Sepak_Takraw" <?php echo e(request('sport') == 'Sepak_Takraw' ? 'selected' : ''); ?>>Sepak Takraw</option>
                    <option value="Chess" <?php echo e(request('sport') == 'Chess' ? 'selected' : ''); ?>>Chess</option>
                    <option value="Swimming" <?php echo e(request('sport') == 'Swimming' ? 'selected' : ''); ?>>Swimming</option>
                    <option value="Athletics" <?php echo e(request('sport') == 'Athletics' ? 'selected' : ''); ?>>Athletics</option>
                </optgroup>
            </select>

            <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-2 text-sm w-full focus:outline-none focus:border-green-500 bg-white">
                <option value="">All Statuses</option>
                <option value="Active" <?php echo e(request('status') == 'Active' ? 'selected' : ''); ?>>Active</option>
                <option value="Inactive" <?php echo e(request('status') == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                <option value="Transferred" <?php echo e(request('status') == 'Transferred' ? 'selected' : ''); ?>>Transferred</option>
                <option value="Injured" <?php echo e(request('status') == 'Injured' ? 'selected' : ''); ?>>Injured</option>
                <option value="Alumni" <?php echo e(request('status') == 'Alumni' ? 'selected' : ''); ?>>Alumni / Graduate</option>
            </select>

            <a href="<?php echo e(url()->current()); ?>" class="text-center border border-gray-300 bg-gray-50 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 transition text-sm flex items-center justify-center font-semibold">
                <i class="fas fa-times me-2"></i> Clear Filters
            </a>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow overflow-auto">
        <table class="w-full table-auto text-sm">
            <thead class="bg-green-50 text-green-800 border-b-2 border-green-200">
                <tr>
                    <th class="px-4 py-3 text-left">S No</th>
                    <th class="px-4 py-3 text-left">Name (Last, First, MI)</th>
                    <th class="px-4 py-3 text-left">Stud ID</th>
                    <th class="px-4 py-3 text-center">Sports Event</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Course & Year</th>
                    <th class="px-4 py-3 text-left">Contact Info</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $athletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 border-b border-gray-100">
                        <td class="px-4 py-3 text-center text-gray-500"><?php echo e($index + 1); ?></td>
                        <td class="px-4 py-3 font-bold text-gray-800 uppercase"><?php echo e($athlete->last_name); ?>, <?php echo e($athlete->first_name); ?> <?php echo e($athlete->middle_initial); ?></td>
                        <td class="px-4 py-3 text-gray-600 font-mono"><?php echo e($athlete->student_id ?? 'N/A'); ?></td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs whitespace-nowrap font-semibold">
                                <?php echo e(str_replace('_', ' ', $athlete->sport_event)); ?>

                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-center">
                            <?php
                                // 🧠 The Brains: Check classification first! 
                                $badgeText = $athlete->status;
                                $badgeColor = 'bg-blue-500'; // Default Active color
                                $icon = 'fa-check-circle';

                                if ($athlete->classification === 'Alumni') {
                                    $badgeText = 'Alumni';
                                    $badgeColor = 'bg-indigo-600'; // Purple!
                                    $icon = 'fa-graduation-cap';
                                } elseif ($athlete->status === 'Injured') {
                                    $badgeColor = 'bg-red-500';
                                    $icon = 'fa-briefcase-medical';
                                } elseif ($athlete->status === 'Transferred') {
                                    $badgeColor = 'bg-orange-500';
                                    $icon = 'fa-exchange-alt';
                                } elseif ($athlete->status === 'Inactive') {
                                    $badgeColor = 'bg-gray-500';
                                    $icon = 'fa-minus-circle';
                                }
                            ?>

                            <span class="<?php echo e($badgeColor); ?> text-white px-3 py-1 rounded-full text-xs shadow-sm whitespace-nowrap">
                                <i class="fas <?php echo e($icon); ?> me-1"></i> <?php echo e($badgeText); ?>

                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-gray-600 text-xs">
                            <div class="flex flex-col gap-1">
                                <span><i class="fas fa-envelope text-gray-400 w-4"></i> <?php echo e($athlete->email); ?></span>
                                <?php if($athlete->contact_number): ?>
                                    <span><i class="fas fa-phone text-gray-400 w-4"></i> <?php echo e($athlete->contact_number); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-16 text-gray-400">
                            <i class="fas fa-users-slash text-5xl mb-3 text-gray-300"></i>
                            <p class="text-lg">No athletes found matching your filters.</p>
                            <a href="<?php echo e(url()->current()); ?>" class="text-green-600 hover:underline mt-2 inline-block">Clear filters and try again</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/athlete_lists.blade.php ENDPATH**/ ?>