 

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="bg-light min-vh-100 p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="fw-bold text-success">
            <i class="fas fa-running me-2"></i> Tryouts Management
        </h2>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <ul class="nav custom-tabs mb-4" id="tryoutTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active custom-tab-btn" data-bs-target="#schedules" type="button">
                <i class="fas fa-calendar-alt me-1"></i> Tryout Schedules
            </button>
        </li>
        <li class="nav-item ms-2" role="presentation">
            <button class="nav-link custom-tab-btn relative" data-bs-target="#recruits" type="button">
                <i class="fas fa-user-check me-1"></i> Passed Recruits
                <?php if(isset($recruits) && $recruits->count() > 0): ?>
                    <span class="absolute top-0 right-0 -mt-1 -mr-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"><?php echo e($recruits->count()); ?></span>
                <?php endif; ?>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="tryoutTabsContent">

        <div class="tab-pane fade show active" id="schedules">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 border-top border-success border-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold text-secondary">Add New Schedule</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('tryouts.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Sport Event <span class="text-danger">*</span></label>
                                    <select name="sport_event" class="form-select" required>
                                        <option value="">Select Sport...</option>
                                        <optgroup label="Ball Games">
                                            <option value="Basketball_Men">Basketball (Men)</option>
                                            <option value="Basketball_Women">Basketball (Women)</option>
                                            <option value="Volleyball_Men">Volleyball (Men)</option>
                                            <option value="Volleyball_Women">Volleyball (Women)</option>
                                        </optgroup>
                                        <optgroup label="Racket Sports">
                                            <option value="Badminton_Men">Badminton (Men)</option>
                                            <option value="Badminton_Women">Badminton (Women)</option>
                                        </optgroup>
                                        <optgroup label="Combat Sports & Others">
                                            <option value="Taekwondo_Men">Taekwondo (Men)</option>
                                            <option value="Chess">Chess</option>
                                            <option value="Swimming">Swimming</option>
                                            <option value="Athletics">Athletics</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="tryout_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Time <span class="text-danger">*</span></label>
                                    <input type="time" name="tryout_time" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Venue <span class="text-danger">*</span></label>
                                    <input type="text" name="venue" class="form-control" placeholder="e.g. Main Court, Gym" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-secondary">Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Bring own equipment"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                    <i class="fas fa-save me-1"></i> Save Schedule
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 fw-bold text-secondary">Active Tryout Schedules</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 w-100">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th class="ps-4">Sport Event</th>
                                            <th>Date & Time</th>
                                            <th>Venue & Notes</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td class="ps-4 fw-bold text-success"><?php echo e(str_replace('_', ' ', $schedule->sport_event)); ?></td>
                                                <td>
                                                    <span class="fw-semibold text-dark"><?php echo e(\Carbon\Carbon::parse($schedule->tryout_date)->format('M d, Y')); ?></span><br>
                                                    <small class="text-muted"><i class="far fa-clock me-1"></i> <?php echo e(\Carbon\Carbon::parse($schedule->tryout_time)->format('h:i A')); ?></small>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold"><?php echo e($schedule->venue); ?></span><br>
                                                    <small class="text-muted fst-italic"><?php echo e($schedule->notes ?? 'No notes'); ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <form action="<?php echo e(route('tryouts.destroy', $schedule->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3" onclick="return confirm('Remove schedule?')">
                                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <p class="text-muted mb-0">No tryout schedules have been posted yet.</p>
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

        <div class="tab-pane fade" id="recruits" style="display: none;">
            <div class="alert alert-info border-info mb-4 flex items-center shadow-sm">
                <i class="fas fa-info-circle me-3 fs-4 text-info"></i>
                <div>
                    <strong>Action Required:</strong> These students passed their tryouts but are still classified as "Recruits." 
                    Update their profile to move them to the Master Roster.
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
                                        <td class="px-4 py-3 border-r text-center"><?php echo e($recruit->contact_number ?? 'No Phone'); ?> <br><span class="text-xs text-gray-500"><?php echo e($recruit->email); ?></span></td>
                                        <td class="px-4 py-3 border-r text-center text-gray-500"><?php echo e($recruit->updated_at->format('M d, Y')); ?></td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="<?php echo e(route('student.athlete', ['id' => $recruit->id])); ?>" class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-2 rounded text-xs font-bold transition">Update to Official Athlete</a>
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

<style>
    /* The main bottom border for the entire tab list */
    .custom-tabs {
        border-bottom: 2px solid #198754; /* Bootstrap success green */
        display: flex;
    }

    /* Unclicked Tab State */
    .custom-tab-btn {
        background-color: #ffffff;
        color: #6c757d;
        border: 1px solid #dee2e6;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        padding: 10px 24px;
        margin-bottom: -2px; /* Pulls the tab down to overlap the bottom line */
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }

    /* Hover effect for unclicked tabs */
    .custom-tab-btn:hover:not(.active) {
        background-color: #e9ecef;
        color: #198754;
    }

    /* Clicked (Active) Tab State */
    .custom-tab-btn.active {
        background-color: #f8f9fa; /* Matches the bg-light of your main container */
        color: #198754 !important;
        border: 2px solid #198754;
        border-bottom: 2px solid #f8f9fa; /* Erases the bottom line inside the tab */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.custom-tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Hide all tab panes
                tabPanes.forEach(pane => {
                    pane.classList.remove('show', 'active');
                    pane.style.display = 'none'; 
                });

                // Show the targeted tab pane
                const targetId = this.getAttribute('data-bs-target');
                const targetPane = document.querySelector(targetId);
                targetPane.classList.add('show', 'active');
                targetPane.style.display = 'block'; 
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/tryout_schedules.blade.php ENDPATH**/ ?>