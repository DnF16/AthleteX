<div class="list-group rounded-0 h-100 shadow-sm" style="border: 1px solid #c4d79b;">
    <div class="list-group-item border-0 fw-bold text-uppercase text-white text-center py-3" 
         style="background-color: #2e4e1f; border-radius: 0; font-size: 0.95rem;">
        Admin Menu
    </div>
    <?php
        // 1. Count Pending Approvals for the Notification Badge
<<<<<<< HEAD
        $pendingCount = \App\Models\Athlete::where('approval_status', 'pending')->count();
=======
        $pendingCount = \App\Models\Athlete::where('status', 'pending')->count();
>>>>>>> publicform-fix

        $admin_links = [
            'general' => ['name' => 'General Information', 'icon' => 'fas fa-info-circle'],
            
            // --- NEW TAB: PENDING VERIFICATIONS ---
            'approvals' => [
                'name' => 'Pending Verifications', 
                'icon' => 'fas fa-user-check',
                'badge' => $pendingCount // Pass the count here
            ],
            
            'users' => ['name' => 'Users & Security', 'icon' => 'fas fa-user-shield'],
            'settings' => ['name' => 'Application Settings', 'icon' => 'fas fa-sliders-h'],
            'classes' => ['name' => 'Classes & Lessons', 'icon' => 'fas fa-book'],
            'scheduling' => ['name' => 'Scheduling Settings', 'icon' => 'fas fa-clock'],
            'certificates' => ['name' => 'Certificates & Awards', 'icon' => 'fas fa-award'],
            'grades' => ['name' => 'Grades & Scoring', 'icon' => 'fas fa-star'],
            'transactions' => ['name' => 'Transactions', 'icon' => 'fas fa-money-check'],
        ];
    ?>

    <?php $__currentLoopData = $admin_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route_name => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('admin.' . $route_name)); ?>" 
       class="list-group-item list-group-item-action border-0 py-2 fw-semibold d-flex justify-content-between align-items-center
       <?php echo e(request()->routeIs('admin.' . $route_name) ? 'bg-light text-success border-start border-5 border-success ps-3' : 'bg-transparent text-secondary'); ?>"
       style="border-bottom: 1px solid #eee; font-size: 0.9rem; transition: all 0.15s;">
       
       <div>
           <i class="<?php echo e($link['icon']); ?> me-2" style="width: 20px;"></i> <?php echo e($link['name']); ?>

       </div>

       <?php if(isset($link['badge']) && $link['badge'] > 0): ?>
           <span class="badge bg-danger rounded-pill"><?php echo e($link['badge']); ?></span>
       <?php endif; ?>

    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>