<?php $__env->startSection('title', 'Athlete Lists'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between px-4">
        <a href="<?php echo e(route('student.athlete')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            back
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Student Athletes Lists</h1>
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
                    <th class="px-4 py-3 border">S No</th>
                    <th class="px-4 py-3 border">Last Name</th>
                    <th class="px-4 py-3 border">First Name, MI</th>
                    <th class="px-4 py-3 border">Stud ID</th>
                    <th class="px-4 py-3 border">Sports Event</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Approval</th>
                    <th class="px-4 py-3 border">Classification</th>
                    <th class="px-4 py-3 border">Gender</th>
                    <th class="px-4 py-3 border">Birthdate</th>
                    <th class="px-4 py-3 border">Age</th>
                    <th class="px-4 py-3 border">Blood Type</th>
                    <th class="px-4 py-3 border">Course</th>
                    <th class="px-4 py-3 border">Year / Level</th>
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
                    <th class="px-4 py-3 border">Coach Name</th>
                    <th class="px-4 py-3 border">Date Joined</th>
                    <th class="px-4 py-3 border">Term Graduated</th>
                    <th class="px-4 py-3 border">Asst Coach</th>
                    <th class="px-4 py-3 border">Units Enrolled</th>
                    <th class="px-4 py-3 border">Year Graduated</th>
                    <th class="px-4 py-3 border">Tuition Fee</th>
                    <th class="px-4 py-3 border">Misc Fee</th>
                    <th class="px-4 py-3 border">Other Charges</th>
                    <th class="px-4 py-3 border">Total Assessment</th>
                    <th class="px-4 py-3 border">Total Discount</th>
                    <th class="px-4 py-3 border">Balance</th>
                    <th class="px-4 py-3 border">Current Work</th>
                    <th class="px-4 py-3 border">Company</th>
                    <th class="px-4 py-3 border">Picture</th>
                    <th class="px-4 py-3 border">Notes</th>
                    <th class="px-4 py-3 border">Inactive Date</th>
                    <th class="px-4 py-3 border">Full Name</th>
                    <!-- <th class="px-4 py-3 border">Actions</th> -->
                </tr>
            </thead>

            <tbody>
                <?php $__currentLoopData = $athletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center"><?php echo e($index + 1); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->last_name); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->first_name); ?> <?php echo e($athlete->middle_initial); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->student_id); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->sport_event); ?></td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 rounded text-white <?php echo e($athlete->status == 'Active' ? 'bg-green-600' : 'bg-gray-500'); ?> text-xs">
                                <?php echo e($athlete->status); ?>

                            </span>
                        </td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                <?php echo e($athlete->approval_status == 'approved' ? 'bg-green-600' : ($athlete->approval_status == 'pending' ? 'bg-yellow-600' : 'bg-red-600')); ?>">
                                <?php echo e(ucfirst($athlete->approval_status)); ?>

                            </span>
                        </td>
                        <td class="border px-4 py-2"><?php echo e($athlete->classification); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->gender); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->birthdate); ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo e($athlete->age); ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo e($athlete->blood_type); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->course); ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo e($athlete->year); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->email); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->fb_link); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->marital_status); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->contact_number); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->address); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->city); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->province); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->zip_code); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->emergency_contact_person); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->emergency_number); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->coach_name); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->date_joined); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->term_graduated); ?></td>
                        <td class="border px-4 py-2"><?php echo e($athlete->asst_coach); ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo e($athlete->units_enrolled); ?></td>
                        <td class="border px-4 py-2 text-center"><?php echo e($athlete->year_graduated); ?></td>
                        <td class="border px-4 py-2 text-right"><?php echo e($athlete->tuition_fee); ?></td>
                        <td class="border px-4 py-2 text-right"><?php echo e($athlete->misc_fee); ?></td>
                        <td class="border px-4 py-2 text-right"><?php echo e($athlete->other_charges); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>

        </table>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/athlete_lists/athlete_lists.blade.php ENDPATH**/ ?>