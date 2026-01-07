<?php $__env->startSection('title', 'Athlete Lists'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <div class="flex items-center justify-between px-4">
        <a href="<?php echo e(route('student.athlete')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Student Athletes List</h1>
    </div>

    
    <div class="bg-white p-4 rounded-lg shadow-sm border space-y-2">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" placeholder="Search name, ID…" 
                class="border border-gray-300 rounded px-3 py-2 text-sm w-full focus:ring-2 focus:ring-green-500 outline-none">

            <select class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">All Sports</option>
                
            </select>

            <select class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">Status</option>
                <option>Active</option>
                <option>Injured</option>
                <option>Inactive</option>
            </select>

            <select class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">Classification</option>
                <option>Varsity</option>
                <option>Trainee</option>
                <option>Reserve</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden border">
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm whitespace-nowrap">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b text-center">S No</th>
                        <th class="px-4 py-3 border-b text-left">Last Name</th>
                        <th class="px-4 py-3 border-b text-left">First Name, MI</th>
                        <th class="px-4 py-3 border-b text-left">Stud ID</th>
                        <th class="px-4 py-3 border-b text-left">Sports Event</th>
                        <th class="px-4 py-3 border-b text-center">Status</th>
                        <th class="px-4 py-3 border-b text-center">Approval</th>
                        <th class="px-4 py-3 border-b text-left">Classification</th>
                        <th class="px-4 py-3 border-b text-left">Gender</th>
                        <th class="px-4 py-3 border-b text-left">Birthdate</th>
                        <th class="px-4 py-3 border-b text-center">Age</th>
                        <th class="px-4 py-3 border-b text-center">Blood Type</th>
                        <th class="px-4 py-3 border-b text-left">Course</th>
                        <th class="px-4 py-3 border-b text-center">Year / Level</th>
                        <th class="px-4 py-3 border-b text-left">Email</th>
                        <th class="px-4 py-3 border-b text-left">FB Link</th>
                        <th class="px-4 py-3 border-b text-left">Marital Status</th>
                        <th class="px-4 py-3 border-b text-left">Contact #</th>
                        <th class="px-4 py-3 border-b text-left">Address</th>
                        <th class="px-4 py-3 border-b text-left">City</th>
                        <th class="px-4 py-3 border-b text-left">Province</th>
                        <th class="px-4 py-3 border-b text-left">Zip Code</th>
                        <th class="px-4 py-3 border-b text-left">Emergency Contact</th>
                        <th class="px-4 py-3 border-b text-left">Emergency #</th>
                        <th class="px-4 py-3 border-b text-left text-center sticky right-0 bg-gray-100 z-10 shadow-l">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $athletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center text-gray-500"><?php echo e($index + 1); ?></td>
                            <td class="px-4 py-3 font-semibold text-gray-900"><?php echo e($athlete->last_name); ?></td>
                            <td class="px-4 py-3"><?php echo e($athlete->first_name); ?> <?php echo e(substr($athlete->middle_name, 0, 1)); ?></td>
                            <td class="px-4 py-3 text-gray-600"><?php echo e($athlete->student_id); ?></td>
                            <td class="px-4 py-3"><?php echo e(str_replace('_', ' ', $athlete->sport_event)); ?></td> 
                            <td class="px-4 py-3 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($athlete->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($athlete->status); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e($athlete->approval_status == 'approved' ? 'bg-blue-100 text-blue-800' : ($athlete->approval_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                                    <?php echo e(ucfirst($athlete->approval_status)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3"><?php echo e($athlete->classification); ?></td>
                            
                            
                            <td class="px-4 py-3"><?php echo e($athlete->gender); ?></td> 
                            
                            <td class="px-4 py-3"><?php echo e($athlete->birthdate ? $athlete->birthdate->format('M d, Y') : '-'); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($athlete->age); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($athlete->blood_type); ?></td>
                            <td class="px-4 py-3"><?php echo e($athlete->course); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo e($athlete->year_level); ?></td> 
                            <td class="px-4 py-3"><?php echo e($athlete->email); ?></td>
                            <td class="px-4 py-3"><a href="<?php echo e($athlete->facebook); ?>" target="_blank" class="text-blue-600 hover:underline">Link</a></td> 
                            
                            
                            <td class="px-4 py-3"><?php echo e($athlete->marital_status); ?></td> 
                            
                            <td class="px-4 py-3"><?php echo e($athlete->contact_number); ?></td>
                            <td class="px-4 py-3 truncate max-w-xs"><?php echo e($athlete->address); ?></td>
                            <td class="px-4 py-3"><?php echo e($athlete->city_municipality); ?></td> 
                            <td class="px-4 py-3"><?php echo e($athlete->province_state); ?></td>
                            <td class="px-4 py-3"><?php echo e($athlete->zip_code); ?></td>
                            <td class="px-4 py-3"><?php echo e($athlete->emergency_person); ?></td> 
                            <td class="px-4 py-3"><?php echo e($athlete->emergency_contact); ?></td> 
                            
                            <td class="px-4 py-3 text-center sticky right-0 bg-white z-10 shadow-l">
                                <a href="<?php echo e(route('athletes.show', $athlete->id)); ?>" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/athlete_lists.blade.php ENDPATH**/ ?>