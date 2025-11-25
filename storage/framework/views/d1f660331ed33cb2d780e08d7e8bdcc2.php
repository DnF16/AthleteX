

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > GRADES AND SCORING
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body" style="background-color: #EBF1DE;">
                    
                    <div class="text-center fst-italic fw-bold border border-dark mb-3 bg-light py-1" style="font-family: serif;">
                        GRADES AND SCORING SETUP
                    </div>

                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="border border-secondary">
                                <div class="text-center fw-bold border-bottom border-secondary py-1" style="background-color: #bfbfbf;">
                                    GRADES & SCORES
                                </div>
                                <table class="table table-bordered border-secondary mb-0 text-center bg-white table-sm">
                                    <thead style="background-color: #DCE6F1;">
                                        <tr><th>Grades & Scores</th><th>Min. %</th><th>Min. Score</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>A</td><td>90%</td><td>90</td></tr>
                                        <tr><td>B</td><td>80%</td><td>80</td></tr>
                                        <tr><td>F</td><td>0%</td><td>0</td></tr>
                                        <tr style="height: 30px;"><td>&nbsp;</td><td></td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="border border-secondary mb-4">
                                <div class="text-center fw-bold border-bottom border-secondary py-1 bg-light fst-italic small">Year/Level</div>
                                <div class="bg-white text-center p-2"><div class="border-bottom py-1">1st Year</div><div class="py-1">4th Year</div></div>
                            </div>
                            <div class="border border-secondary">
                                <div class="text-center fw-bold border-bottom border-secondary py-1 bg-light fst-italic small">Exam Types</div>
                                <div class="bg-white text-center p-2"><div class="border-bottom py-1">Quiz</div><div class="py-1">Assignment</div></div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="border border-secondary">
                                <div class="text-center fw-bold border-bottom border-secondary py-1" style="background-color: #bfbfbf;">
                                    SCHOLARSHIP CRITERIA
                                </div>
                                <table class="table table-bordered border-secondary mb-0 text-center bg-white table-sm">
                                    <thead style="background-color: #DCE6F1;">
                                        <tr><th>Level</th><th>Criteria (Pts)</th><th>Criteria (%)</th><th>Certificate/Award</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr style="height: 30px;"><td>1st Year</td><td>100</td><td>100%</td><td>Full Scholarship</td></tr>
                                        <tr style="height: 30px;"><td>&nbsp;</td><td></td><td></td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-3 text-end"><button class="btn btn-success"><i class="fas fa-save"></i> Save Grade Criteria</button></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views\admin\grades.blade.php ENDPATH**/ ?>