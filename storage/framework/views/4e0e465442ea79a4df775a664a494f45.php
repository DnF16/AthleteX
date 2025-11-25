

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > CERTIFICATES & AWARDS
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header text-center fst-italic fw-bold border-bottom-0" 
                    style="background-color: #C4D79B; border: 1px solid #999; font-family: serif;">
                    CERTIFICATES & AWARDS
                </div>

                <div class="card-body p-0" style="background-color: #EBF1DE; border: 1px solid #999; border-top: none;">
                    
                    <div class="d-flex justify-content-end p-2 bg-light border-bottom">
                        <button class="btn btn-success btn-sm fw-bold shadow-sm">
                            <i class="fas fa-plus-circle"></i> Add Certificate
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered border-secondary text-center bg-white mb-0 align-middle">
                            <thead style="background-color: #DCE6F1;">
                                <tr>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 15%;">Type</th>
                                    <th style="width: 20%;">File Name</th>
                                    <th style="width: 40%;">Thumbnail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $certs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="height: 50px;">
                                    <td><?php echo e($cert->name); ?></td>
                                    <td><?php echo e($cert->type); ?></td>
                                    <td><?php echo e($cert->file_name); ?></td>
                                    <td class="bg-light text-muted">
                                        <?php if($cert->type == 'Award'): ?>
                                            <i class="fas fa-trophy text-warning fa-lg"></i>
                                        <?php else: ?>
                                            <small>No Preview</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr style="height: 50px;"><td></td><td></td><td></td><td class="bg-light"></td></tr>
                                <tr style="height: 50px;"><td></td><td></td><td></td><td class="bg-light"></td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/admin/certificates.blade.php ENDPATH**/ ?>