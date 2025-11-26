

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2 p-3" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > SCHEDULING SETTINGS
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body" style="background-color: #EBF1DE;">
                    
                    <form action="<?php echo e(route('admin.saveSettings')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            
                            <div class="col-md-5">
                                <div class="section-box border p-3 h-100" style="background-color: #E4EAD5; border: 1px solid #999;">
                                    <h6 class="fw-bold fst-italic text-center mb-4" style="font-family: serif; letter-spacing: 1px;">SCHEDULE SETTINGS</h6>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">Weekday Start</label>
                                        <div class="col-sm-6">
                                            <select name="weekday_start" class="form-select form-select-sm border-secondary rounded-0">
                                                <option value="Monday" <?php echo e((\App\Models\Setting::get('weekday_start') == 'Monday') ? 'selected' : ''); ?>>Monday</option>
                                                <option value="Sunday" <?php echo e((\App\Models\Setting::get('weekday_start') == 'Sunday') ? 'selected' : ''); ?>>Sunday</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">1st Class Start</label>
                                        <div class="col-sm-6"><input type="time" name="class_start_time" class="form-control form-control-sm border-secondary rounded-0" value="<?php echo e(\App\Models\Setting::get('class_start_time', '08:00')); ?>"></div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">Last Class End</label>
                                        <div class="col-sm-6"><input type="time" name="class_end_time" class="form-control form-control-sm border-secondary rounded-0" value="<?php echo e(\App\Models\Setting::get('class_end_time', '17:00')); ?>"></div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">Interval (min)</label>
                                        <div class="col-sm-6">
                                            <input type="number" name="schedule_interval" class="form-control border-secondary rounded-0" value="<?php echo e(\App\Models\Setting::get('schedule_interval', 60)); ?>">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm w-100 mt-2">Save Schedule Defaults</button>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="card border border-secondary rounded-0">
                                    <div class="card-header text-center fw-bold fst-italic py-1" style="background-color: #C4D79B; border-bottom: 1px solid #999;">
                                        Scheduled Class Days
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered table-sm mb-0 bg-white border-secondary">
                                            <tbody style="font-size: 0.9rem;">
                                                <tr><td class="ps-3 w-50">Monday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Tuesday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Wednesday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Thursday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Friday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Saturday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Sunday</td><td class="text-center text-muted"></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr class="border-secondary my-4">

                    <div class="section-box border p-3 mb-3" style="background-color: #DCE6F1; border: 1px solid #999;">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Add New Holiday</h6>
                        <form action="<?php echo e(route('admin.addHoliday')); ?>" method="POST" class="row g-2">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-3"><label class="form-label-sm">Holiday Name</label><input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Christmas Break" required></div>
                            <div class="col-md-2"><label class="form-label-sm">From</label><input type="date" name="from_date" class="form-control form-control-sm" required></div>
                            <div class="col-md-2"><label class="form-label-sm">To</label><input type="date" name="to_date" class="form-control form-control-sm" required></div>
                            <div class="col-md-2"><label class="form-label-sm">Term</label><input type="text" name="term" class="form-control form-control-sm" placeholder="e.g. 1st"></div>
                            <div class="col-md-3"><button type="submit" class="btn btn-primary btn-sm w-100">Save Holiday</button></div>
                        </form>
                    </div>

                    <h5 class="text-center fw-bold fst-italic mb-0 pt-2" style="font-family: serif; background-color: #bfbfbf; border: 1px solid #999; border-bottom: none;">Scheduled Holidays</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered border-secondary text-center bg-white mb-0">
                            <thead style="background-color: #C4D79B;">
                                <tr>
                                    <th style="width: 25%;">Holiday Name</th>
                                    <th style="width: 25%;">From Date</th>
                                    <th style="width: 25%;">To Date</th>
                                    <th style="width: 25%;">Term</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="height: 35px;">
                                        <td><?php echo e($holiday->name); ?></td>
                                        <td><?php echo e($holiday->from_date); ?></td>
                                        <td><?php echo e($holiday->to_date); ?></td>
                                        <td><?php echo e($holiday->term); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($holidays->isEmpty()): ?>
                                    <tr style="height: 35px;"><td colspan="4" class="text-muted">No holidays scheduled yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/admin/scheduling.blade.php ENDPATH**/ ?>