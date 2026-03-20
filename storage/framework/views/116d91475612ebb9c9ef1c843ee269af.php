 

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="bg-light min-vh-100 p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="fw-bold text-success">
            <i class="fas fa-boxes me-2"></i> Equipment Requests
        </h2>
        <button class="btn btn-success fw-bold shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#newRequestModal">
            <i class="fas fa-plus me-2"></i> New Request
        </button>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-success border-5" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <?php if(isset($requests) && $requests->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list text-muted mb-3" style="font-size: 3rem;"></i>
                    <p class="text-muted fs-5">No equipment requests found.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 w-100">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 py-3">Date Requested</th>
                                <th>Requested By</th>
                                <th>Event</th>
                                <th>Total Items</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 fw-semibold text-dark"><?php echo e(\Carbon\Carbon::parse($req->date_requested)->format('M d, Y')); ?></td>
                                    <td class="text-dark fw-bold uppercase"><?php echo e($req->requested_by); ?></td>
                                    <td class="text-secondary"><?php echo e($req->event); ?></td>
                                    <td>
                                        <?php
                                            $itemCount = is_array($req->items) ? count($req->items) : (is_string($req->items) ? count(json_decode($req->items, true) ?? []) : 0);
                                        ?>
                                        <span class="badge bg-secondary rounded-pill px-3"><?php echo e($itemCount); ?> items</span>
                                    </td>
                                    <td>
                                        <?php if($req->status === 'Pending'): ?>
                                            <span class="badge bg-warning text-dark px-3 py-1 rounded shadow-sm fw-bold"><i class="fas fa-clock me-1"></i> Pending</span>
                                        <?php elseif($req->status === 'Approved'): ?>
                                            <span class="badge bg-success px-3 py-1 rounded shadow-sm fw-bold"><i class="fas fa-check me-1"></i> Approved</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-3 py-1 rounded shadow-sm fw-bold"><i class="fas fa-times me-1"></i> Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#viewRequestModal<?php echo e($req->id); ?>">
                                            <i class="fas fa-eye"></i> View
                                        </button>
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

<div class="modal fade" id="newRequestModal" tabindex="-1" data-bs-backdrop="false" style="background-color: rgba(0, 0, 0, 0.6);">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 4px;">
            
            <div class="modal-header bg-dark text-white border-0 py-2">
                <h6 class="modal-title mb-0"><i class="fas fa-file-signature me-2"></i> Document Draft</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0" style="background-color: #f8f9fa;">
                <form action="<?php echo e(route('equipment.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="bg-white mx-auto my-4 p-5 shadow-sm" style="max-width: 900px; border: 1px solid #dee2e6;">
                        
                        <div class="d-flex justify-content-between align-items-end pb-2 mb-4" style="border-bottom: 2px solid black;">
                            <div>
                                <i class="fas fa-university fs-3 text-secondary me-2"></i>
                                <span class="fw-bold fs-5 text-secondary tracking-widest uppercase">University of the Cordilleras</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-0 fst-italic">Sports Development Office</h5>
                        </div>

                        <h4 class="text-center fw-bold text-dark mb-5 text-decoration-underline" style="letter-spacing: 1px;">COACH'S EQUIPMENT REQUEST FORM</h4>

                        <div class="row mb-4">
                            <div class="col-md-8 d-flex align-items-center">
                                <label class="fw-bold me-2 mb-0">Event:</label>
                                <input type="text" name="event" class="form-control px-2 flex-grow-1" placeholder="Enter Event Name" required style="background: transparent; border: none; border-bottom: 1px solid black; border-radius: 0; box-shadow: none;">
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="fw-bold me-2 mb-0">Date:</label>
                                <input type="date" name="date_requested" class="form-control px-2 flex-grow-1" value="<?php echo e(date('Y-m-d')); ?>" required style="background: transparent; border: none; border-bottom: 1px solid black; border-radius: 0; box-shadow: none;">
                            </div>
                        </div>

                        <div class="table-responsive mb-2">
                            <table class="table table-bordered border-dark mb-0">
                                <thead class="bg-light text-center align-middle" style="border-bottom: 2px solid black;">
                                    <tr>
                                        <th style="width: 10%;">Qty</th>
                                        <th style="width: 15%;">Unit</th>
                                        <th style="width: 50%;">Item(s) / Description(s)</th>
                                        <th style="width: 15%;">Amount</th>
                                        <th style="width: 10%; border: none; background: transparent;"></th> 
                                    </tr>
                                </thead>
                                <tbody id="equipment-tbody">
                                    <tr class="align-middle">
                                        <td><input type="number" name="items[0][qty]" class="form-control border-0 text-center" placeholder="0" required></td>
                                        <td><input type="text" name="items[0][unit]" class="form-control border-0 text-center" placeholder="e.g. pcs" required></td>
                                        <td><input type="text" name="items[0][description]" class="form-control border-0" placeholder="Item description..." required></td>
                                        <td><input type="number" step="0.01" name="items[0][amount]" class="form-control border-0 text-center" placeholder="₱ 0.00" required></td>
                                        <td class="text-center" style="border: none; background: transparent;">
                                            <button type="button" class="btn btn-sm btn-outline-danger" disabled><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mb-5 pb-3">
                            <button type="button" class="btn btn-sm btn-success fw-bold shadow-sm px-3" onclick="addEquipmentRow()">
                                <i class="fas fa-plus me-1"></i> Add Item Row
                            </button>
                        </div>

                        <div class="row mt-4 pt-4">
                            <div class="col-md-6">
                                <p class="mb-0">Requested by:</p>
                                <div class="px-4 text-center" style="margin-top: 60px;">
                                    <input type="text" name="requested_by" class="form-control text-center fw-bold text-uppercase px-2 mb-1" value="<?php echo e(auth()->user()->role === 'coach' ? (auth()->user()->coach ? auth()->user()->coach->coach_first_name . ' ' . auth()->user()->coach->coach_last_name : auth()->user()->name) : auth()->user()->name); ?>" required style="background: transparent; border: none; border-bottom: 1px solid black; border-radius: 0; box-shadow: none;">
                                    <p class="fw-bold mb-0" style="visibility: hidden;">Spacer</p>
                                    <p class="small text-muted mb-0">(Name | Signature | Date)</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Approved by:</p>
                                <div class="px-4 text-center" style="margin-top: 60px;">
                                    <div style="height: 38px; border-bottom: 1px solid black;" class="mb-1 w-100"></div>
                                    <p class="fw-bold mb-0 text-dark uppercase" style="letter-spacing: 0.5px;">DR. DANILO L CONG-O</p>
                                    <p class="small text-muted mb-0">Director, SDO</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-3">
                            <p class="small text-muted mb-0" style="font-size: 0.75rem;">UC-ADM-SDO-FORM-07</p>
                            <p class="small text-muted mb-0" style="font-size: 0.75rem;">August 17, 2020 Rev. 01</p>
                        </div>
                    </div>

                    <div class="bg-white p-3 border-top text-end">
                        <button type="button" class="btn btn-secondary px-4 fw-bold me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm"><i class="fas fa-paper-plane me-2"></i> Submit Request</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php if(isset($requests) && !$requests->isEmpty()): ?>
    <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="viewRequestModal<?php echo e($req->id); ?>" tabindex="-1" data-bs-backdrop="false" style="background-color: rgba(0, 0, 0, 0.6);">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 4px;">
                    
                    <div class="modal-header bg-dark text-white border-0 py-2">
                        <h6 class="modal-title mb-0"><i class="fas fa-file-invoice me-2"></i> View Document</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-0" style="background-color: #f8f9fa;">
                        
                        <div class="bg-white mx-auto my-4 p-5 shadow-sm text-dark" style="max-width: 900px; border: 1px solid #dee2e6;">
                            
                            <div class="d-flex justify-content-between align-items-end pb-2 mb-4" style="border-bottom: 2px solid black;">
                                <div>
                                    <i class="fas fa-university fs-3 text-secondary me-2"></i>
                                    <span class="fw-bold fs-5 text-secondary tracking-widest uppercase">University of the Cordilleras</span>
                                </div>
                                <h5 class="fw-bold text-dark mb-0 fst-italic">Sports Development Office</h5>
                            </div>

                            <h4 class="text-center fw-bold text-dark mb-5 text-decoration-underline" style="letter-spacing: 1px;">COACH'S EQUIPMENT REQUEST FORM</h4>

                            <div class="row mb-4">
                                <div class="col-md-8 d-flex align-items-center">
                                    <label class="fw-bold me-2 mb-0">Event:</label>
                                    <div class="flex-grow-1 px-2 pb-1" style="border-bottom: 1px solid black;">
                                        <?php echo e($req->event); ?>

                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <label class="fw-bold me-2 mb-0">Date:</label>
                                    <div class="flex-grow-1 px-2 pb-1" style="border-bottom: 1px solid black;">
                                        <?php echo e(\Carbon\Carbon::parse($req->date_requested)->format('m/d/Y')); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered border-dark mb-0">
                                    <thead class="bg-light text-center align-middle" style="border-bottom: 2px solid black;">
                                        <tr>
                                            <th style="width: 10%;">Qty</th>
                                            <th style="width: 15%;">Unit</th>
                                            <th style="width: 55%;">Item(s) / Description(s)</th>
                                            <th style="width: 20%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $items = is_string($req->items) ? json_decode($req->items, true) : $req->items;
                                            $totalAmount = 0;
                                        ?>
                                        
                                        <?php if($items): ?>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $totalAmount += floatval($item['amount'] ?? 0); ?>
                                                <tr class="align-middle text-center">
                                                    <td><?php echo e($item['qty'] ?? 0); ?></td>
                                                    <td><?php echo e($item['unit'] ?? ''); ?></td>
                                                    <td class="text-start px-3"><?php echo e($item['description'] ?? ''); ?></td>
                                                    <td>₱ <?php echo e(number_format(floatval($item['amount'] ?? 0), 2)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        
                                        <tr class="align-middle fw-bold bg-light">
                                            <td colspan="3" class="text-end pe-3 uppercase tracking-widest">Total Amount:</td>
                                            <td class="text-center text-success">₱ <?php echo e(number_format($totalAmount, 2)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4 pt-4">
                                <div class="col-md-6">
                                    <p class="mb-0">Requested by:</p>
                                    <div class="px-4 text-center" style="margin-top: 60px;">
                                        <div class="fw-bold text-uppercase px-2 mb-1 pb-1" style="border-bottom: 1px solid black;">
                                            <?php echo e($req->requested_by); ?>

                                        </div>
                                        <p class="fw-bold mb-0" style="visibility: hidden;">Spacer</p>
                                        <p class="small text-muted mb-0">(Name | Signature | Date)</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">Approved by:</p>
                                    <div class="px-4 text-center" style="margin-top: 60px;">
                                        
                                        <?php if($req->status === 'Approved'): ?>
                                            <div class="fw-bold text-success px-2 mb-1 pb-1 d-flex justify-content-center align-items-center" style="border-bottom: 1px solid black; font-family: 'Courier New', Courier, monospace;">
                                                <i class="fas fa-check-double me-2"></i> DIGITAL APPROVAL (<?php echo e($req->updated_at->format('m/d/Y')); ?>)
                                            </div>
                                        <?php elseif($req->status === 'Rejected'): ?>
                                            <div class="fw-bold text-danger px-2 mb-1 pb-1 d-flex justify-content-center align-items-center" style="border-bottom: 1px solid black; font-family: 'Courier New', Courier, monospace;">
                                                <i class="fas fa-times me-2"></i> REJECTED
                                            </div>
                                        <?php else: ?>
                                            <div style="height: 38px; border-bottom: 1px solid black;" class="mb-1 w-100"></div>
                                        <?php endif; ?>

                                        <p class="fw-bold mb-0 text-dark uppercase" style="letter-spacing: 0.5px;">DR. DANILO L CONG-O</p>
                                        <p class="small text-muted mb-0">Director, SDO</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-3">
                                <p class="small text-muted mb-0" style="font-size: 0.75rem;">UC-ADM-SDO-FORM-07</p>
                                <p class="small text-muted mb-0" style="font-size: 0.75rem;">August 17, 2020 Rev. 01</p>
                            </div>
                        </div>

                        <div class="bg-white p-3 border-top d-flex justify-content-between align-items-center">
                            
                            <div>
                                <?php if(auth()->user()->role === 'admin' && $req->status === 'Pending'): ?>
                                    <div class="d-flex gap-2">
                                        <form action="<?php echo e(route('equipment.approve', $req->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm" onclick="return confirm('Are you sure you want to APPROVE this request?')">
                                                <i class="fas fa-check me-2"></i> Approve Request
                                            </button>
                                        </form>
                                        
                                        <form action="<?php echo e(route('equipment.reject', $req->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold" onclick="return confirm('Are you sure you want to REJECT this request?')">
                                                <i class="fas fa-times me-2"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                <?php elseif($req->status === 'Approved'): ?>
                                    <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> This request has been approved.</span>
                                <?php elseif($req->status === 'Rejected'): ?>
                                    <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i> This request was rejected.</span>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="btn btn-secondary px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Close Document</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<style>
    .uppercase { text-transform: uppercase; }
    .tracking-widest { letter-spacing: 0.1em; }
    
    .form-control:focus {
        background-color: #f0fdf4 !important;
        outline: none;
        box-shadow: none;
    }
    
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
</style>

<script>
    let rowIndex = 1;

    function addEquipmentRow() {
        const tbody = document.getElementById('equipment-tbody');
        const tr = document.createElement('tr');
        tr.className = 'align-middle';
        
        tr.innerHTML = `
            <td><input type="number" name="items[${rowIndex}][qty]" class="form-control border-0 text-center" placeholder="0" required></td>
            <td><input type="text" name="items[${rowIndex}][unit]" class="form-control border-0 text-center" placeholder="e.g. pcs" required></td>
            <td><input type="text" name="items[${rowIndex}][description]" class="form-control border-0" placeholder="Item description..." required></td>
            <td><input type="number" step="0.01" name="items[${rowIndex}][amount]" class="form-control border-0 text-center" placeholder="₱ 0.00" required></td>
            <td class="text-center" style="border: none; background: transparent;">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()" title="Remove Row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(tr);
        rowIndex++;
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/equipment.blade.php ENDPATH**/ ?>