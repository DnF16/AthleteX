<?php $__env->startSection('title', 'SDO Reports Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div id="tab-content" class="bg-white p-6 rounded w-full">
    <div class="space-y-6">

        <!-- 📢 FEEDBACK ALERTS -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-4" role="alert">
                <div class="flex items-center">
                    <i class="bi bi-check-circle-fill text-xl me-2"></i>
                    <span class="font-bold"><?php echo e(session('success')); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-4" role="alert">
                <div class="flex items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill text-xl me-2"></i>
                    <span class="font-bold"><?php echo e(session('error')); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <!-- END FEEDBACK ALERTS -->

        <!-- Page Header -->
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">SDO Reports Dashboard</h1>
        </div>

        <!-- 🚑 SDO EMERGENCY MEDICAL DASHBOARD -->
        <h3 class="text-xl font-bold text-red-700 mt-8 mb-4">
            <i class="bi bi-exclamation-octagon-fill me-2"></i> Pending Medical Incidents
        </h3>
        <div class="bg-white rounded shadow p-6 overflow-x-auto mb-8 border-t-4 border-red-600">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase">Athlete</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase">Incident Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase">Date Submitted</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-red-800 uppercase">Action / Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $incidentReports ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#<?php echo e($incident->id); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">
                                <?php echo e($incident->first_name); ?> <?php echo e($incident->last_name); ?>

                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-red-700"><?php echo e($incident->incident_title); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($incident->created_at)->format('M d, Y h:i A')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                
                                <!-- VIEW DOCUMENT BUTTON -->
                                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded shadow-sm text-sm transition duration-150" data-bs-toggle="modal" data-bs-target="#viewIncidentModal<?php echo e($incident->id); ?>">
                                    <i class="bi bi-file-earmark-text"></i> View
                                </button>

                                <?php if($incident->status === 'Pending'): ?>
                                    <!-- GENERATE TICKET BUTTON -->
                                    <form action="/incidents/approve/<?php echo e($incident->id); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded shadow-sm text-sm transition duration-150">
                                            <i class="bi bi-check2-circle"></i> Approve
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <!-- ALREADY APPROVED TICKET NO. -->
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        <i class="bi bi-upc-scan me-1"></i> <?php echo e($incident->insurance_ticket_no); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="bi bi-shield-check text-3xl mb-2 block text-gray-300"></i>
                                No pending medical incidents. You are all caught up!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- END SDO MEDICAL DASHBOARD -->

        <!-- Standard Reports Table -->
        <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">Standard Coach Reports</h3>
        <div class="bg-white rounded shadow p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coach</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($report->coach->coach_first_name); ?> <?php echo e($report->coach->coach_last_name); ?></td>
                            <td class="px-6 py-4"><?php echo e($report->title); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                <?php echo e($report->file_name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($report->status === 'pending'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                <?php elseif($report->status === 'received'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                <?php elseif($report->status === 'rejected'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($report->created_at->format('M d, Y H:i')); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <!-- Download Button -->
                                <a href="<?php echo e(route('reports.download', $report->id)); ?>" class="text-blue-600 hover:text-blue-800" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>

                                <?php if($report->status === 'pending'): ?>
                                    <!-- Mark as Received -->
                                    <form method="POST" action="<?php echo e(route('reports.mark-received', $report->id)); ?>" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-800" title="Mark as Received" onclick="return confirm('Mark this report as received?')">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>

                                    <!-- Mark as Rejected -->
                                    <form method="POST" action="<?php echo e(route('reports.mark-rejected', $report->id)); ?>" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Mark as Rejected" onclick="return confirm('Mark this report as rejected?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No reports submitted yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- 📝 READ-ONLY DOCUMENT MODALS FOR THE ADMIN -->
<!-- ========================================== -->
<?php $__currentLoopData = $incidentReports ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- NUCLEAR MODAL FIX APPLIED HERE: data-bs-backdrop="false" and manual dark background -->
<div class="modal fade" id="viewIncidentModal<?php echo e($incident->id); ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" style="background-color: rgba(0,0,0,0.6); z-index: 99999;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content shadow-2xl rounded-none border-0">
            
            <div class="modal-header bg-gray-100 border-b-2 border-black rounded-none">
                <h5 class="modal-title font-bold text-gray-800 uppercase tracking-widest">
                    <i class="bi bi-file-earmark-medical me-2"></i> Official Document View
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-8 bg-white text-black font-sans print:p-0">
                
                <!-- TOP HEADER INFO -->
                <div class="flex justify-between items-end mb-4">
                    <div>
                        <h2 class="text-2xl font-black uppercase tracking-tight">Incident Report Form</h2>
                    </div>
                    <div class="text-right text-sm">
                        <span class="font-bold">IR No.</span>
                        <span class="ml-2 font-mono underline <?php echo e($incident->insurance_ticket_no ? 'text-black font-bold' : 'text-red-600'); ?>">
                            <?php echo e($incident->insurance_ticket_no ?? 'PENDING APPROVAL'); ?>

                        </span>
                    </div>
                </div>

                <!-- TOP INCIDENT INFO TABLE -->
                <table class="w-full border-collapse border border-black mb-4 text-sm">
                    <tr>
                        <td class="border border-black p-2 bg-gray-100 font-bold w-1/3">Incident Title:</td>
                        <td class="border border-black p-2 font-bold"><?php echo e($incident->incident_title); ?></td>
                    </tr>
                    <tr>
                        <td class="border border-black p-2 bg-gray-100 font-bold">Incident Type:</td>
                        <td class="border border-black p-2">
                            <?php echo e($incident->incident_type); ?>

                            <?php if($incident->incident_type_specify): ?>
                                - <?php echo e($incident->incident_type_specify); ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-black p-2 bg-gray-100 font-bold">Person/s Involved:</td>
                        <td class="border border-black p-2"><?php echo e($incident->persons_involved); ?></td>
                    </tr>
                    <tr>
                        <td class="border border-black p-2 bg-gray-100 font-bold">Date & Time:</td>
                        <td class="border border-black p-2"><?php echo e(\Carbon\Carbon::parse($incident->incident_date)->format('m/d/Y')); ?> @ <?php echo e(\Carbon\Carbon::parse($incident->incident_time)->format('h:i A')); ?></td>
                    </tr>
                    <tr>
                        <td class="border border-black p-2 bg-gray-100 font-bold">Exact Location:</td>
                        <td class="border border-black p-2"><?php echo e($incident->exact_location); ?></td>
                    </tr>
                </table>

                <!-- ============================================== -->
                <!-- EXACT FORM MATCH (NARRATIVE & SIGNATURES)      -->
                <!-- ============================================== -->
                <table class="w-full border-collapse border border-black text-sm mb-0">
                    <tbody>
                        <!-- Description -->
                        <tr>
                            <td class="border border-black bg-gray-100 font-bold text-center py-1">Description of the Incident:</td>
                        </tr>
                        <tr>
                            <td class="border border-black p-4 align-top whitespace-pre-wrap" style="min-height: 120px;"><?php echo e($incident->incident_details); ?></td>
                        </tr>
                        
                        <!-- Immediate Actions -->
                        <tr>
                            <td class="border border-black bg-gray-100 font-bold text-center py-1">Immediate Action/s Taken:</td>
                        </tr>
                        <tr>
                            <td class="border border-black p-4 align-top whitespace-pre-wrap" style="min-height: 120px;"><?php echo e($incident->immediate_actions); ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Signatures Table -->
                <table class="w-full border-collapse border border-black text-sm border-t-0">
                    <tbody>
                        <tr>
                            <td class="border border-black font-bold p-1 pl-2 w-1/2">Accomplished by</td>
                            <td class="border border-black font-bold p-1 pl-2 w-1/2">Noted by</td>
                        </tr>
                        <tr>
                            <!-- INCREASED HEIGHT TO h-40 FOR SIGNATURES -->
                            <td class="border border-black h-40 text-center align-bottom pb-2">
                                <!-- Blank for physical signature -->
                            </td>
                            <td class="border border-black h-40 text-center align-middle relative">
                                <?php if($incident->status !== 'Pending'): ?>
                                    <!-- Digital Approval Stamp -->
                                    <div class="inline-block border-2 border-red-600 text-red-600 font-bold uppercase tracking-widest px-4 py-1 rotate-[-5deg] opacity-70">
                                        SDO Approved
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-black text-center text-xs py-2">
                                <span class="font-bold block text-sm">Reporting Individual</span>
                                <span>( Name &nbsp;&nbsp;|&nbsp;&nbsp; Signature &nbsp;&nbsp;|&nbsp;&nbsp; Date )</span>
                            </td>
                            <td class="border border-black text-center text-xs py-2">
                                <span class="font-bold block text-sm">SDO Director</span>
                                <span>( Name &nbsp;&nbsp;|&nbsp;&nbsp; Signature &nbsp;&nbsp;|&nbsp;&nbsp; Date )</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Exact Footer from Document -->
                <div class="flex justify-between border-t border-black mt-8 pt-1 text-[10px] text-gray-500 font-sans">
                    <div>
                        UC-SDO-IRF<br>
                        January 27, 2025 Rev.00
                    </div>
                    <div class="text-right">
                        Page 1 of 1
                    </div>
                </div>
                <!-- ============================================== -->

            </div>

            <!-- Admin Action Buttons (Hidden when printing) -->
            <div class="modal-footer bg-gray-100 flex justify-between items-center border-t-2 border-black rounded-none print:hidden">
                <button type="button" class="btn btn-secondary font-bold" data-bs-dismiss="modal">Close Document</button>
                
                <div class="flex space-x-2">
                    <button type="button" class="btn btn-outline-dark font-bold shadow-sm" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print Form
                    </button>

                    <?php if($incident->status === 'Pending'): ?>
                        <form action="/incidents/approve/<?php echo e($incident->id); ?>" method="POST" class="m-0">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <button type="submit" class="btn btn-danger font-bold px-4 shadow">
                                <i class="bi bi-check2-circle"></i> Approve & Generate Ticket
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/reports/admin_reports.blade.php ENDPATH**/ ?>