 

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > APPLICATION SETTINGS
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body" style="background-color: #EBF1DE;">
                    
                    <form action="<?php echo e(route('admin.saveSettings')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="section-box border p-3 mb-3" style="background-color: #DCE6F1;">
                            <h6 class="fw-bold fst-italic border-bottom border-secondary pb-1 mb-3">APPLICATION SETTINGS</h6>

                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 text-end"><label class="form-label-sm fw-bold">Share & Sync</label></div>
                                <div class="col-md-4"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" name="share_sync" value="true" checked></div></div>

                                <div class="col-md-2 text-end"><label class="form-label-sm fw-bold">Sort Names By</label></div>
                                <div class="col-md-4"><select class="form-select form-select-sm" name="sort_names_by"><option>Last Name, First Name</option><option>First Name, Last Name</option></select></div>
                            </div>

                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 text-end"><label class="form-label-sm fw-bold">App/Shared Folder</label></div>
                                <div class="col-md-10"><div class="input-group input-group-sm"><input type="text" name="shared_folder_path" class="form-control" value="D:\Documents_File\1. Important Databases"><button class="btn btn-success" type="button"><i class="fas fa-folder-open"></i></button></div></div>
                            </div>

                            <hr class="my-3 text-secondary">

                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 text-end"><label class="form-label-sm fw-bold">% Format</label></div>
                                <div class="col-md-4"><input type="text" name="percent_format" class="form-control form-control-sm" value="0"></div>
                                <div class="col-md-2 text-end"><label class="form-label-sm fw-bold">Date Format</label></div>
                                <div class="col-md-4"><input type="text" name="date_format" class="form-control form-control-sm" value="mm/dd/yy"></div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 text-end"><label class="form-label-sm fw-bold">Time Format</label></div>
                                <div class="col-md-4"><input type="text" name="time_format" class="form-control form-control-sm" value="h:mm am/pm"></div>
                                <div class="col-md-2 text-end"><label class="form-label-sm fw-bold">Currency Format</label></div>
                                <div class="col-md-4"><input type="text" name="currency_format" class="form-control form-control-sm" value="$#,##0_);($#,##0)"></div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success fw-bold"><i class="fas fa-save"></i> Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header text-center fw-bold" style="background-color: #C4D79B;">Common Field Format</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center mb-0" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                                <tr><th style="width: 25%;">Date</th><th style="width: 25%;">Time</th><th style="width: 25%;">Percent</th><th style="width: 25%;">Currency</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>mm/dd/yy</td><td>h:mm</td><td>0%</td><td>$#,##0_);($#,##0)</td></tr>
                                <tr><td>mm/dd/yyyy</td><td>h:mm:ss</td><td>0.00%</td><td>$#,##0.00_);[Red]($#,##0.00)</td></tr>
                                <tr><td>d-mmm-yy</td><td>h:mm am/pm</td><td>0.00%</td><td>$#,##0.00_);($#,##0.00)</td></tr>
                                <tr><td>dd-mmm-yy</td><td>h:mm am/pm</td><td></td><td>$#,##0.00_);[Red]($#,##0.00)</td></tr>
                                <tr><td>dd-mmm-yyyy</td><td></td><td></td><td></td></tr>
                                <tr><td>mmm-yy</td><td></td><td></td><td></td></tr>
                                <tr><td>mm/dd</td><td></td><td></td><td></td></tr>
                                <tr><td>mmmm</td><td></td><td></td><td></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/admin/settings.blade.php ENDPATH**/ ?>