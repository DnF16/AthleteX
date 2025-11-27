
<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0"><div class="row g-0">
    <div class="col-md-3 col-lg-2 p-3" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;"><?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
        <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">ADMIN > TRANSACTION ITEMS</div>
        <div class="row">
            <div class="col-md-4"><div class="section-box"><h6 class="fw-bold border-bottom pb-2">Add Item</h6>
                <form action="<?php echo e(route('admin.addTransaction')); ?>" method="POST"><?php echo csrf_field(); ?>
                    <input type="text" name="name" class="form-control mb-2" placeholder="Item Name">
                    <select name="type" class="form-select mb-2"><option>Income</option><option>Expense</option></select>
                    <input type="text" name="category" class="form-control mb-3" placeholder="Category">
                    <button class="btn btn-success w-100">Add</button>
                </form>
            </div></div>
            <div class="col-md-8"><table class="table table-bordered custom-table bg-white table-striped">
                <thead><tr><th>Item Name</th><th>Type</th><th>Category</th></tr></thead>
                <tbody><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($item->name); ?></td><td><?php echo e($item->type); ?></td><td><?php echo e($item->category); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
            </table></div>
        </div>
    </div>
</div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/admin/transactions.blade.php ENDPATH**/ ?>