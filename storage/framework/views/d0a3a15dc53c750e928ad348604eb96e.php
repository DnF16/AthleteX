 

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="bg-light min-vh-100 p-4">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body" style="background-color: #e8f5e9; border-left: 5px solid #2e4e1f;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold text-success mb-1">
                        <i class="fas fa-share-alt me-2"></i>Registration Form Link
                    </h5>
                    <p class="text-muted small mb-0">
                        Copy this link and send it to students, alumni, or tryout applicants.
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white" 
                               value="<?php echo e(route('alumni.register.show')); ?>" 
                               id="regLink" readonly>
                        <button class="btn btn-success" onclick="copyToClipboard()">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <a href="<?php echo e(route('alumni.register.show')); ?>" target="_blank" class="btn btn-outline-success">
                            <i class="fas fa-external-link-alt"></i> Visit Link
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("regLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999); 
            navigator.clipboard.writeText(copyText.value);
            alert("Link copied! You can now paste it in Messenger or Email.");
        }
    </script>

    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h2 class="fw-bold text-success">
            <i class="fas fa-user-check me-2"></i> Pending Verifications
        </h2>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
        // Moved the queries ABOVE the buttons so we can count them for the notifications!

        // 1. Fetch Students (Everyone NOT Alumni and NOT Tryout)
        $studentPendings = \App\Models\Athlete::where('approval_status', 'pending')
                            ->whereNotIn('classification', ['Alumni', 'Tryout'])
                            ->latest()->get();

        // 2. Fetch Alumni ONLY
        $alumniPendings = \App\Models\Athlete::where('approval_status', 'pending')
                            ->where('classification', 'Alumni')
                            ->latest()->get();
        
        // 3. Fetch Tryouts ONLY
        $tryoutPendings = \App\Models\Athlete::where('approval_status', 'pending')
                            ->where('classification', 'Tryout')
                            ->latest()->get();
    ?>

    <!-- THREE SEPARATE TABS WITH NOTIFICATION BADGES -->
    <div class="d-flex gap-3 mb-4">
        <button id="student-tab-btn" onclick="showSection('student')" class="btn btn-success fw-bold flex-fill">
            Student Requests
            <?php if($studentPendings->count() > 0): ?>
                <span class="badge bg-danger ms-2 rounded-pill"><?php echo e($studentPendings->count()); ?></span>
            <?php endif; ?>
        </button>
        
        <button id="alumni-tab-btn" onclick="showSection('alumni')" class="btn btn-outline-secondary fw-bold flex-fill">
            Alumni Requests
            <?php if($alumniPendings->count() > 0): ?>
                <span class="badge bg-danger ms-2 rounded-pill"><?php echo e($alumniPendings->count()); ?></span>
            <?php endif; ?>
        </button>
        
        <button id="tryout-tab-btn" onclick="showSection('tryout')" class="btn btn-outline-secondary fw-bold flex-fill">
            Tryout Applicants
            <?php if($tryoutPendings->count() > 0): ?>
                <span class="badge bg-danger ms-2 rounded-pill"><?php echo e($tryoutPendings->count()); ?></span>
            <?php endif; ?>
        </button>
    </div>

    <!-- ============================================== -->
    <!-- 1. STUDENT SECTION -->
    <!-- ============================================== -->
    <div id="student-section">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <?php if($studentPendings->isEmpty()): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-check text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted fs-5">All caught up! No student requests pending.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Student ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Classification</th>
                                    <th>Sport Event</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $studentPendings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark"><?php echo e($p->student_id); ?></td>
                                    <td><span class="fw-semibold"><?php echo e($p->first_name); ?> <?php echo e($p->last_name); ?></span></td>
                                    <td><span class="text-muted small"><?php echo e($p->email); ?></span></td>
                                    <td><span class="badge bg-secondary"><?php echo e($p->classification); ?></span></td>
                                    <td><span class="badge bg-info text-dark"><?php echo e(str_replace('_', ' ', $p->sport_event)); ?></span></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="<?php echo e(route('admin.approve.athlete', $p->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm px-3" onclick="return confirm('Approve <?php echo e($p->first_name); ?>?')">
                                                    <i class="fas fa-check me-1"></i> Approve
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.reject.athlete', $p->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Reject this request?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. ALUMNI SECTION -->
    <!-- ============================================== -->
    <div id="alumni-section" style="display:none;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <?php if($alumniPendings->isEmpty()): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-graduation-cap text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted fs-5">No alumni requests pending.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Student ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Classification</th>
                                    <th>Sport Event</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $alumniPendings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark"><?php echo e($p->student_id); ?></td>
                                    <td><span class="fw-semibold"><?php echo e($p->first_name); ?> <?php echo e($p->last_name); ?></span></td>
                                    <td><span class="text-muted small"><?php echo e($p->email); ?></span></td>
                                    <td><span class="badge bg-secondary"><?php echo e($p->classification); ?></span></td>
                                    <td><span class="badge bg-info text-dark"><?php echo e(str_replace('_', ' ', $p->sport_event)); ?></span></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="<?php echo e(route('admin.approve.athlete', $p->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm px-3" onclick="return confirm('Approve <?php echo e($p->first_name); ?> as Alumni?')">
                                                    <i class="fas fa-check me-1"></i> Approve
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.reject.athlete', $p->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Reject this alumni request?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. TRYOUT SECTION -->
    <!-- ============================================== -->
    <div id="tryout-section" style="display:none;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <?php if($tryoutPendings->isEmpty()): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted fs-5">No tryout applicants yet.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Applicant Name</th>
                                    <th>Contact Info</th>
                                    <th>Sport Applying For</th>
                                    <th>Date Applied</th>
                                    <th class="text-center">Tryout Decision</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tryoutPendings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark"><?php echo e($p->first_name); ?> <?php echo e($p->last_name); ?></td>
                                    <td>
                                        <span class="text-dark small"><i class="fas fa-envelope me-1"></i> <?php echo e($p->email); ?></span><br>
                                        <span class="text-muted small"><i class="fas fa-phone me-1"></i> <?php echo e($p->contact_number ?? 'N/A'); ?></span>
                                    </td>
                                    <td><span class="badge bg-warning text-dark px-3 py-2"><?php echo e(str_replace('_', ' ', $p->sport_event)); ?></span></td>
                                    <td class="text-secondary small"><?php echo e($p->created_at->format('M d, Y')); ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="<?php echo e(route('admin.approve.athlete', $p->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-primary btn-sm px-3" onclick="return confirm('Did <?php echo e($p->first_name); ?> pass the tryouts? This will make them an Active athlete.')">
                                                    <i class="fas fa-trophy me-1"></i> Passed
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.reject.athlete', $p->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Did they fail/not show up? This will remove their record.')">
                                                    <i class="fas fa-times me-1"></i> Failed
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<script>
    function showSection(section) {
        // Buttons
        const studentBtn = document.getElementById('student-tab-btn');
        const alumniBtn = document.getElementById('alumni-tab-btn');
        const tryoutBtn = document.getElementById('tryout-tab-btn');

        // Sections
        document.getElementById('student-section').style.display = (section === 'student') ? 'block' : 'none';
        document.getElementById('alumni-section').style.display = (section === 'alumni') ? 'block' : 'none';
        document.getElementById('tryout-section').style.display = (section === 'tryout') ? 'block' : 'none';

        // Toggle Button Styles
        studentBtn.classList.toggle('btn-success', section === 'student');
        studentBtn.classList.toggle('btn-outline-secondary', section !== 'student');
        
        alumniBtn.classList.toggle('btn-success', section === 'alumni');
        alumniBtn.classList.toggle('btn-outline-secondary', section !== 'alumni');

        tryoutBtn.classList.toggle('btn-success', section === 'tryout');
        tryoutBtn.classList.toggle('btn-outline-secondary', section !== 'tryout');

        // Save state so it doesn't reset when they click approve
        localStorage.setItem('activeApprovalTab', section);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const activeSection = localStorage.getItem('activeApprovalTab') || 'student';
        showSection(activeSection);
    });
</script>
    
</div>
        
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/approvals.blade.php ENDPATH**/ ?>