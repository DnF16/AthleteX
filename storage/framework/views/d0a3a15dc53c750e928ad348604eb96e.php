 

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="bg-light min-vh-100 p-4">

    <div class="card shadow-sm border-0 mb-4" style="background-color: #f0fdf4; border-left: 5px solid #166534; border-radius: 8px;">
        <div class="card-body py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-share-nodes text-success fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-success mb-0">Registration Form Link</h6>
                    <p class="text-muted small mb-0">Copy this link and send it to students, alumni, or tryout applicants.</p>
                </div>
            </div>
            
            <div class="d-flex gap-2 align-items-center" style="width: 500px;">
                <input type="text" class="form-control form-control-sm bg-white border-light text-muted" 
                       value="<?php echo e(route('alumni.register.show')); ?>" id="regLink" readonly>
                
                <button class="btn btn-success btn-sm d-flex align-items-center px-3 fw-bold" onclick="copyToClipboard()">
                    <i class="fas fa-copy me-2"></i> Copy
                </button>
                
                
                <a href="<?php echo e(route('alumni.register.show')); ?>" target="_blank" class="btn btn-outline-success btn-sm px-3 fw-bold d-flex align-items-center">
                    Open <span class="ms-1"></span>
                </a>
            </div>
        </div>
    </div>

    <div class="mb-4 mt-2">
        <h5 class="fw-bold text-success d-flex align-items-center">
            <i class="fas fa-user-check me-2"></i> Pending Verifications
        </h5>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <ul class="nav custom-tabs mb-4" id="approvalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active custom-tab-btn" data-bs-target="#regular" type="button">
                <i class="fas fa-users me-1"></i> Active & Alumni Requests
            </button>
        </li>
        <li class="nav-item ms-2" role="presentation">
            <button class="nav-link custom-tab-btn" data-bs-target="#tryout" type="button">
                <i class="fas fa-running me-1"></i> Tryout Applicants
            </button>
        </li>
    </ul>

    <div class="tab-content" id="approvalTabsContent">
        
        <?php
            $regularPendings = \App\Models\Athlete::where('status', 'Pending')
                                ->whereIn('classification', ['Alumni'])
                                ->latest()->get();
            
            $tryoutPendings = \App\Models\Athlete::where('status', 'Pending')
                                ->where('classification', 'Tryout')
                                ->latest()->get();
        ?>

        <div class="tab-pane fade show active" id="regular">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <?php if($regularPendings->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-check text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted fs-5">All caught up! No regular requests pending.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 w-100">
                                <thead class="bg-light">
                                    <tr class="text-dark fw-bold small">
                                        <th class="ps-4 py-3">Student ID</th>
                                        <th>Full Name</th>
                                        <th>Type</th>
                                        <th>Sport Event</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $regularPendings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?php echo e($p->student_id); ?></td>
                                        <td>
                                            <span class="fw-bold uppercase"><?php echo e($p->last_name); ?>, <?php echo e($p->first_name); ?></span><br>
                                            <span class="text-muted small"><?php echo e($p->email); ?></span>
                                        </td>
                                        <td><span class="badge bg-secondary px-3 py-1 rounded-pill"><?php echo e($p->classification); ?></span></td>
                                        <td><span class="badge bg-warning text-dark px-3 py-1 rounded shadow-sm fw-bold"><?php echo e(str_replace('_', ' ', $p->sport_event)); ?></span></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="<?php echo e(route('admin.approve.athlete', $p->id)); ?>" method="POST" class="ajax-form">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
                                                        <i class="fas fa-trophy me-2"></i> Passed
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.reject.athlete', $p->id)); ?>" method="POST" class="ajax-form">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
                                                        <i class="fas fa-times me-2"></i> Failed
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

        <div class="tab-pane fade" id="tryout" style="display: none;">
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
                                <thead class="bg-light">
                                    <tr class="text-dark fw-bold small">
                                        <th class="ps-4 py-3">Applicant Name</th>
                                        <th>Contact Info</th>
                                        <th>Sport Applying For</th>
                                        <th>Date Applied</th>
                                        <th class="text-center">Tryout Decision</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $tryoutPendings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark uppercase"><?php echo e($p->last_name); ?>, <?php echo e($p->first_name); ?></td>
                                        <td>
                                            <div class="small mb-1"><i class="fas fa-envelope text-muted me-2"></i><?php echo e($p->email); ?></div>
                                            <div class="small text-muted"><i class="fas fa-phone me-2"></i><?php echo e($p->contact_number ?? 'N/A'); ?></div>
                                        </td>
                                        <td><span class="badge bg-warning text-dark px-3 py-1 rounded shadow-sm fw-bold"><?php echo e(str_replace('_', ' ', $p->sport_event)); ?></span></td>
                                        <td class="text-secondary small"><?php echo e($p->created_at->format('M d, Y')); ?></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="<?php echo e(route('admin.approve.athlete', $p->id)); ?>" method="POST" class="ajax-form">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
                                                        <i class="fas fa-trophy me-2"></i> Passed
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.reject.athlete', $p->id)); ?>" method="POST" class="ajax-form">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
                                                        <i class="fas fa-times me-2"></i> Failed
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

    </div> 
</div> 

<style>
    /* The main bottom border for the entire tab list */
    .custom-tabs {
        border-bottom: 2px solid #198754; 
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
        margin-bottom: -2px; 
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
        background-color: #f8f9fa; 
        color: #198754 !important;
        border: 2px solid #198754;
        border-bottom: 2px solid #f8f9fa; 
    }

    /* Button and Badge Styles */
    .badge.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
    .btn-primary { background-color: #0d6efd !important; border: none; }
    .btn-outline-danger { color: #dc3545; border-color: #dc3545; }
    .btn-outline-danger:hover { background-color: #dc3545; color: white; }
    .uppercase { text-transform: uppercase; }
</style>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("regLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); 
        navigator.clipboard.writeText(copyText.value);
        alert("Link copied! You can now paste it in Messenger or Email.");
    }

    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Bulletproof Tab Logic
        const tabButtons = document.querySelectorAll('.custom-tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        // Check Local Storage for active tab
        const activeTabId = localStorage.getItem('activeApprovalTab');
        if (activeTabId) {
            const btnToClick = document.querySelector(`[data-bs-target="${activeTabId}"]`);
            if(btnToClick) btnToClick.click();
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Save to local storage
                const targetId = this.getAttribute('data-bs-target');
                localStorage.setItem('activeApprovalTab', targetId);

                // Update Button Classes
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Update Pane Visibility
                tabPanes.forEach(pane => {
                    pane.classList.remove('show', 'active');
                    pane.style.display = 'none'; 
                });
                
                const targetPane = document.querySelector(targetId);
                targetPane.classList.add('show', 'active');
                targetPane.style.display = 'block'; 
            });
        });

        // 2. AJAX Row fading logic
        const actionForms = document.querySelectorAll('.ajax-form');
        
        actionForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 
                
                // Get action type to customize confirmation message
                const isApprove = this.action.includes('approve');
                const confirmMsg = isApprove ? "Are you sure you want to pass this applicant?" : "Are you sure you want to fail this applicant?";
                
                if (!confirm(confirmMsg)) return; 

                const url = this.getAttribute('action');
                const row = this.closest('tr'); 
                const token = this.querySelector('input[name="_token"]').value;
                const btn = this.querySelector('button');

                btn.disabled = true;
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        row.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                        row.style.opacity = 0;
                        row.style.transform = "translateX(20px)";
                        setTimeout(() => row.remove(), 500); 
                    }
                })
                .catch(error => {
                    console.error("AJAX Error:", error);
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    alert("Something went wrong. Please try again.");
                });
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/approvals.blade.php ENDPATH**/ ?>