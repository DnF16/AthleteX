

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > CLASSES AND LESSONS
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body" style="background-color: #EBF1DE;">
                    <div class="section-box border p-3" style="background-color: #DCE6F1; border: 1px solid #999;">
                        <h6 class="fw-bold fst-italic border-bottom border-secondary pb-1 mb-3">CLASSES AND LESSONS</h6>
                        <form action="<?php echo e(route('admin.addClass')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-2 row"><label class="col-sm-4 form-label-sm text-end">Default Location</label><div class="col-sm-8"><input type="text" name="location" class="form-control form-control-sm"></div></div>
                                    <div class="mb-2 row"><label class="col-sm-4 form-label-sm text-end">Default Teacher</label><div class="col-sm-8"><input type="text" name="teacher" class="form-control form-control-sm"></div></div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-2 row"><label class="col-sm-4 form-label-sm text-end">Default Subject</label><div class="col-sm-8"><input type="text" name="subject" class="form-control form-control-sm"></div></div>
                                    <div class="mb-2 row"><label class="col-sm-4 form-label-sm text-end">Default Class Type</label><div class="col-sm-8"><input type="text" name="type" class="form-control form-control-sm"></div></div>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-success w-100 h-75 fw-bold shadow-sm"><i class="fas fa-plus-circle fa-2x mb-1"></i><br>Add Class</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered custom-table bg-white text-center align-middle">
                    <thead>
                        <tr><th>Location</th><th>Subject</th><th>Type</th><th>Status</th><th>Icon</th><th>File Name</th></tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($course->location); ?></td>
                            <td><?php echo e($course->subject); ?></td>
                            <td><?php echo e($course->type); ?></td>
                            <td><span class="badge bg-success"><?php echo e($course->status); ?></span></td>
                            <td><i class="fas fa-book text-primary"></i></td>
                            <td><?php echo e($course->icon_file); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/admin/classes.blade.php ENDPATH**/ ?>