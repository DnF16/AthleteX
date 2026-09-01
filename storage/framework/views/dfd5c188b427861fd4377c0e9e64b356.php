 

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="bg-light min-vh-100 p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="fw-bold text-success">
            Tryouts Management
        </h2>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <ul class="nav nav-tabs mb-4" id="tryoutTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-success border-bottom-0" id="schedules-tab" data-bs-toggle="tab" data-bs-target="#schedules" type="button" role="tab">
                Tryout Schedules
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-secondary border-bottom-0 relative" id="recruits-tab" data-bs-toggle="tab" data-bs-target="#recruits" type="button" role="tab">
                Passed Recruits
                <?php if(isset($recruits) && $recruits->count() > 0): ?>
                    <span class="absolute top-0 right-0 -mt-1 -mr-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo e($recruits->count()); ?></span>
                <?php endif; ?>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="tryoutTabsContent">

        <div class="tab-pane fade show active" id="schedules" role="tabpanel">
            <div class="row">
                
                <!-- ADD SCHEDULE FORM -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 border-top border-success border-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold text-secondary">Add New Schedule</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.tryouts.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Sport Event <span class="text-danger">*</span></label>
                                    <select name="sport_event" class="form-select" required>
                                        <option value="">Select Sport...</option>
                                        <!-- DYNAMICALLY LOADED FROM YOUR 'sports' DATABASE TABLE -->
                                        <?php $__currentLoopData = \App\Models\Sport::orderBy('name', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(str_replace(' ', '_', $sport->name)); ?>">
                                                <?php echo e($sport->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="tryout_date" class="form-control" min="<?php echo e(date('Y-m-d')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Time <span class="text-danger">*</span></label>
                                    <input type="time" name="tryout_time" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Venue <span class="text-danger">*</span></label>
                                    <select name="venue" class="form-select" required>
                                        <option value="">Select Venue...</option>
                                        <option value="UC Main Gym">UC Main Gym</option>
                                        <option value="UC Court B">UC Court B</option>
                                        <option value="Athletic Bowl">Athletic Bowl</option>
                                        <option value="Baguio City National High School">Baguio City National High School</option>
                                        <option value="Other">Other (Specify in Notes)</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-secondary">Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Bring own equipment or water"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                    Save Schedule
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- SCHEDULES LIST -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-secondary">Tryout Schedules List</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 w-100">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th class="ps-4">Sport Event & Status</th>
                                            <th>Date & Time</th>
                                            <th>Venue & Notes</th>
                                            <th class="text-center" style="min-width: 180px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php
                                                $tryoutDateTime = \Carbon\Carbon::parse($schedule->tryout_date . ' ' . $schedule->tryout_time);
                                                $isExpired = $tryoutDateTime->isPast();
                                            ?>

                                            <tr class="<?php echo e($isExpired ? 'bg-light opacity-75' : 'hover:bg-gray-50'); ?>">
                                                <td class="ps-4 fw-bold <?php echo e($isExpired ? 'text-secondary' : 'text-success'); ?>">
                                                    <?php echo e(str_replace('_', ' ', $schedule->sport_event)); ?>

                                                    <br>
                                                    <?php if($isExpired): ?>
                                                        <span class="badge bg-secondary mt-1">Expired</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success mt-1">Active</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold <?php echo e($isExpired ? 'text-secondary' : 'text-dark'); ?>">
                                                        <?php echo e(\Carbon\Carbon::parse($schedule->tryout_date)->format('M d, Y')); ?>

                                                    </span><br>
                                                    <small class="text-muted">
                                                        <?php echo e(\Carbon\Carbon::parse($schedule->tryout_time)->format('h:i A')); ?>

                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold <?php echo e($isExpired ? 'text-secondary' : 'text-dark'); ?>"><?php echo e($schedule->venue); ?></span><br>
                                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 150px;">
                                                        <?php echo e($schedule->notes ?? 'No notes'); ?>

                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <!-- VIEW DETAILS BUTTON -->
                                                        <button type="button" class="btn btn-sm btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#viewScheduleModal<?php echo e($schedule->id); ?>">
                                                            View
                                                        </button>

                                                        <!-- EDIT BUTTON -->
                                                        <button type="button" class="btn btn-sm btn-warning fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#editScheduleModal<?php echo e($schedule->id); ?>">
                                                            Edit
                                                        </button>

                                                        <!-- DELETE BUTTON -->
                                                        <form action="<?php echo e(route('admin.tryouts.destroy', $schedule->id)); ?>" method="POST" class="m-0 p-0">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('Are you sure you want to remove this schedule?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <p class="text-muted fs-5 mb-0">No tryout schedules have been posted yet.</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 

        <!-- Passed Recruits Tab Content -->
        <div class="tab-pane fade" id="recruits" role="tabpanel">
            <div class="alert alert-info border-info mb-4 flex items-center">
                <div>
                    <strong>Action Required:</strong> These students passed their tryouts but are still classified as "Recruits." 
                    Once they submit their paperwork, edit their profile and change their Classification to "Class A, B, or C" to move them to the Master Roster.
                </div>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden border border-yellow-300">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-sm whitespace-nowrap">
                        <thead class="bg-yellow-500 text-gray-900 text-center">
                            <tr>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Applicant Name</th>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Sport Tryout</th>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Contact Details</th>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Date Passed</th>
                                <th class="px-4 py-3 font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <?php if(isset($recruits) && $recruits->count() > 0): ?>
                                <?php $__currentLoopData = $recruits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recruit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-yellow-50 border-b">
                                        <td class="px-4 py-3 border-r font-bold text-gray-900"><?php echo e($recruit->last_name); ?>, <?php echo e($recruit->first_name); ?></td>
                                        <td class="px-4 py-3 border-r text-center"><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-semibold"><?php echo e(str_replace('_', ' ', $recruit->sport_event)); ?></span></td>
                                        <td class="px-4 py-3 border-r text-center">
                                            <?php echo e($recruit->contact_number ?? 'No Phone'); ?> <br>
                                            <span class="text-xs text-gray-500"><?php echo e($recruit->email); ?></span>
                                        </td>
                                        <td class="px-4 py-3 border-r text-center text-gray-500"><?php echo e($recruit->updated_at->format('M d, Y')); ?></td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="<?php echo e(route('student.athlete', ['id' => $recruit->id])); ?>" class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-2 rounded text-xs font-bold transition">
                                                Update to Official Athlete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-8 text-gray-500 italic">No recruits waiting for paperwork.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 

    </div> 
</div> 

<!-- ========================================== -->
<!-- MODALS (100% CLICKABLE FIX) -->
<!-- ========================================== -->
<?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- VIEW MODAL -->
    <div class="modal fade" id="viewScheduleModal<?php echo e($schedule->id); ?>" tabindex="-1" data-bs-backdrop="false" style="background-color: rgba(0,0,0,0.6);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Tryout Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <h3 class="fw-bold text-center text-dark mb-4"><?php echo e(str_replace('_', ' ', $schedule->sport_event)); ?></h3>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted fw-bold">Date</span>
                            <span class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($schedule->tryout_date)->format('l, F d, Y')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted fw-bold">Time</span>
                            <span class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($schedule->tryout_time)->format('h:i A')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted fw-bold">Venue</span>
                            <span class="fw-semibold"><?php echo e($schedule->venue); ?></span>
                        </li>
                    </ul>
                    
                    <div class="mt-4 p-3 bg-light rounded border border-warning">
                        <h6 class="fw-bold text-warning-emphasis mb-2">Special Instructions / Notes</h6>
                        <p class="mb-0 text-dark"><?php echo e($schedule->notes ?? 'None provided.'); ?></p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editScheduleModal<?php echo e($schedule->id); ?>" tabindex="-1" data-bs-backdrop="false" style="background-color: rgba(0,0,0,0.6);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold text-dark">Edit Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('admin.tryouts.update', $schedule->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Sport Event <span class="text-danger">*</span></label>
                            <select name="sport_event" class="form-select" required>
                                <!-- DYNAMICALLY LOADED FROM YOUR 'sports' DATABASE TABLE -->
                                <?php $__currentLoopData = \App\Models\Sport::orderBy('name', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        // Format the database name to match how it's stored in the tryouts table
                                        $formattedSport = str_replace(' ', '_', $sport->name);
                                    ?>
                                    <option value="<?php echo e($formattedSport); ?>" <?php echo e($schedule->sport_event == $formattedSport ? 'selected' : ''); ?>>
                                        <?php echo e($sport->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Date <span class="text-danger">*</span></label>
                            <input type="date" name="tryout_date" class="form-control" value="<?php echo e(\Carbon\Carbon::parse($schedule->tryout_date)->format('Y-m-d')); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Time <span class="text-danger">*</span></label>
                            <input type="time" name="tryout_time" class="form-control" value="<?php echo e(\Carbon\Carbon::parse($schedule->tryout_time)->format('H:i')); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Venue <span class="text-danger">*</span></label>
                            <select name="venue" class="form-select" required>
                                <option value="UC Main Gym" <?php echo e($schedule->venue == 'UC Main Gym' ? 'selected' : ''); ?>>UC Main Gym</option>
                                <option value="UC Court B" <?php echo e($schedule->venue == 'UC Court B' ? 'selected' : ''); ?>>UC Court B</option>
                                <option value="Athletic Bowl" <?php echo e($schedule->venue == 'Athletic Bowl' ? 'selected' : ''); ?>>Athletic Bowl</option>
                                <option value="Baguio City National High School" <?php echo e($schedule->venue == 'Baguio City National High School' ? 'selected' : ''); ?>>Baguio City National High School</option>
                                <option value="Other" <?php echo e($schedule->venue == 'Other' ? 'selected' : ''); ?>>Other</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Notes</label>
                            <textarea name="notes" class="form-control" rows="3"><?php echo e($schedule->notes); ?></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning fw-bold text-dark">Update Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', event => {
                tabs.forEach(t => { t.classList.remove('text-success'); t.classList.add('text-secondary'); });
                event.target.classList.remove('text-secondary');
                event.target.classList.add('text-success');
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/tryout_schedules.blade.php ENDPATH**/ ?>