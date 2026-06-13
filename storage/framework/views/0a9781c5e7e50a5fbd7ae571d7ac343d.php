<?php $__env->startSection('title', 'My Reports'); ?>

<?php $__env->startSection('content'); ?>
<div id="tab-content" class="bg-white p-6 rounded w-full">
    <div class="space-y-6">
        <?php if(session('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-4" role="alert">
                <div class="flex items-center">
                    <i class="bi bi-check-circle-fill text-xl me-2"></i>
                    <span class="font-bold"><?php echo e(session('success')); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-4" role="alert">
                <div class="flex items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill text-xl me-2"></i>
                    <span class="font-bold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc ms-8 mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">My Reports</h1>
        </div>

        <div class="flex justify-center mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadReportModal">
                <i class="bi bi-cloud-upload me-1"></i>
                Upload Standard Report
            </button>
        </div>

        <!-- 🚑 SDO SMART INCIDENT FORM WIZARD -->
        <div class="bg-red-50 border-l-4 border-red-500 rounded shadow p-6 mb-6">
            <div class="flex items-center mb-3">
                <i class="bi bi-heart-pulse text-red-600 text-2xl me-2"></i>
                <h2 class="text-xl font-bold text-red-700 mb-0">Official SDO Incident Report</h2>
            </div>
            <p class="text-sm text-red-600 mb-6">Step <span id="step-counter">1</span> of 3: Please provide the details of the incident below.</p>

            <form action="<?php echo e(route('incidents.report')); ?>" method="POST" id="smartIncidentForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="coach_id" value="<?php echo e(auth()->user()->coach->id ?? 1); ?>">

                <!-- ================= STEP 1: CONTEXT & LOCATION ================= -->
                <div id="step1">
                    <h4 class="text-md font-bold text-gray-800 mb-3 border-b border-red-200 pb-2">Part 1: Context & Location</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-danger">Select Primary Athlete <span class="text-red-500">*</span></label>
                            <select name="athlete_id" class="form-select border-danger text-gray-700" required>
                                <option value="" disabled selected>-- Choose an Athlete --</option>
                                <?php if(isset($athletes) && count($athletes) > 0): ?>
                                    <?php $__currentLoopData = $athletes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $athlete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($athlete->id); ?>"><?php echo e($athlete->first_name); ?> <?php echo e($athlete->last_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <option value="" disabled>No athletes found. Please add athletes first.</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-danger">All Person/s Involved <span class="text-red-500">*</span></label>
                            <input type="text" name="persons_involved" class="form-control border-danger" placeholder="Full names of everyone involved" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-danger">Date of Incident <span class="text-red-500">*</span></label>
                            <input type="date" name="incident_date" class="form-control border-danger" value="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-danger">Time of Incident <span class="text-red-500">*</span></label>
                            <input type="time" name="incident_time" class="form-control border-danger" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-danger">Exact Location <span class="text-red-500">*</span></label>
                            <input type="text" name="exact_location" class="form-control border-danger" placeholder="e.g., Main Gym, Court B" required>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" onclick="nextStep(2)" class="btn btn-danger">Next: Incident Type <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div>

                <!-- ================= STEP 2: INCIDENT TYPE ================= -->
                <div id="step2" class="hidden">
                    <h4 class="text-md font-bold text-gray-800 mb-3 border-b border-red-200 pb-2">Part 2: Incident Classification</h4>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-danger">Incident Title <span class="text-red-500">*</span></label>
                            <input type="text" name="incident_title" class="form-control border-danger" placeholder="A brief title (e.g., Sprained Ankle during Practice)" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-danger">Incident Type <span class="text-red-500">*</span></label>
                            <select id="incident_type" name="incident_type" class="form-select border-danger text-gray-700" onchange="handleTypeChange()" required>
                                <option value="" disabled selected>-- Select Type --</option>
                                <option value="Injury">Injury</option>
                                <option value="Equipment Malfunction">Equipment Malfunction</option>
                                <option value="Facility Hazard">Facility Hazard</option>
                                <option value="Behavioral Issues">Behavioral Issues</option>
                                <option value="Medical Emergency">Medical Emergency</option>
                                <option value="Transportation-Related Incident">Transportation-Related Incident</option>
                                <option value="Property Damage">Property Damage</option>
                                <option value="Unauthorized use of school facility/property">Unauthorized use of school facility/property</option>
                                <option value="Holding of activity without approval">Holding of activity without approval</option>
                                <option value="Intoxicated Person">Intoxicated Person</option>
                                <option value="Smoking">Smoking</option>
                                <option value="Illegal Drugs">Illegal Drugs</option>
                                <option value="Accident">Accident</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                        <!-- Dynamic Specifics Container -->
                        <div class="col-md-6 hidden" id="specify_container">
                            <label class="form-label fw-bold text-danger">Please Specify Details <span class="text-red-500">*</span></label>
                            
                            <!-- Sub-dropdown for Intoxicated -->
                            <select id="specify_intoxicated" class="form-select border-danger hidden">
                                <option value="Concealing intoxicating beverages">Concealing intoxicating beverages</option>
                                <option value="Hangover">Hangover</option>
                            </select>

                            <!-- Sub-dropdown for Drugs -->
                            <select id="specify_drugs" class="form-select border-danger hidden">
                                <option value="Concealing">Concealing</option>
                                <option value="Using">Using</option>
                                <option value="Selling">Selling</option>
                            </select>

                            <!-- Text input for Accident / Others -->
                            <input type="text" id="incident_type_specify" class="form-control border-danger hidden" placeholder="Describe specifics...">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button type="button" onclick="prevStep(1)" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Back</button>
                        <button type="button" onclick="nextStep(3)" class="btn btn-danger">Next: Narrative <i class="bi bi-arrow-right ms-1"></i></button>
                    </div>
                </div>

                <!-- ================= STEP 3: NARRATIVE & ACTIONS ================= -->
                <div id="step3" class="hidden">
                    <h4 class="text-md font-bold text-gray-800 mb-3 border-b border-red-200 pb-2">Part 3: Narrative & Resolution</h4>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-danger">Description of the Incident <span class="text-red-500">*</span></label>
                            <textarea name="incident_details" class="form-control border-danger" rows="3" placeholder="What exactly happened?" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-danger">Immediate Action/s Taken <span class="text-red-500">*</span></label>
                            <textarea name="immediate_actions" class="form-control border-danger" rows="2" placeholder="e.g., Applied ice, notified campus security, sent to clinic" required></textarea>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button type="button" onclick="prevStep(2)" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Back</button>
                        <button type="submit" class="btn btn-danger text-lg font-bold shadow-lg">
                            <i class="bi bi-send-exclamation me-1"></i> Submit Official Report
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 🧠 JAVASCRIPT FOR THE SMART WIZARD -->
        <script>
            function nextStep(step) {
                // 1. Validate the current step before moving forward
                let currentStep = step - 1;
                let container = document.getElementById('step' + currentStep);
                let inputs = container.querySelectorAll('input[required], select[required], textarea[required]');
                
                for (let input of inputs) {
                    if (!input.checkValidity()) {
                        input.reportValidity(); // Shows the browser's native "Please fill out this field" tooltip
                        return; // Stops the function from advancing the page
                    }
                }

                // 2. Hide all steps
                document.getElementById('step1').classList.add('hidden');
                document.getElementById('step2').classList.add('hidden');
                document.getElementById('step3').classList.add('hidden');

                // 3. Show the target step
                document.getElementById('step' + step).classList.remove('hidden');
                document.getElementById('step-counter').innerText = step;
            }

            function prevStep(step) {
                document.getElementById('step1').classList.add('hidden');
                document.getElementById('step2').classList.add('hidden');
                document.getElementById('step3').classList.add('hidden');

                document.getElementById('step' + step).classList.remove('hidden');
                document.getElementById('step-counter').innerText = step;
            }

            function handleTypeChange() {
                let type = document.getElementById('incident_type').value;
                let specifyContainer = document.getElementById('specify_container');
                let specifyInput = document.getElementById('incident_type_specify');
                let specifySelectIntoxicated = document.getElementById('specify_intoxicated');
                let specifySelectDrugs = document.getElementById('specify_drugs');

                // Reset: Hide everything and remove the 'name' attribute so empty data isn't submitted
                specifyContainer.classList.add('hidden');
                
                specifyInput.classList.add('hidden'); 
                specifyInput.removeAttribute('name');
                specifyInput.removeAttribute('required');
                
                specifySelectIntoxicated.classList.add('hidden'); 
                specifySelectIntoxicated.removeAttribute('name');
                
                specifySelectDrugs.classList.add('hidden'); 
                specifySelectDrugs.removeAttribute('name');

                // Logic: Show only what is needed based on selection
                if (type === 'Intoxicated Person') {
                    specifyContainer.classList.remove('hidden');
                    specifySelectIntoxicated.classList.remove('hidden');
                    specifySelectIntoxicated.setAttribute('name', 'incident_type_specify');
                } else if (type === 'Illegal Drugs') {
                    specifyContainer.classList.remove('hidden');
                    specifySelectDrugs.classList.remove('hidden');
                    specifySelectDrugs.setAttribute('name', 'incident_type_specify');
                } else if (type === 'Accident' || type === 'Others') {
                    specifyContainer.classList.remove('hidden');
                    specifyInput.classList.remove('hidden');
                    specifyInput.setAttribute('name', 'incident_type_specify');
                    specifyInput.setAttribute('required', 'required');
                    specifyInput.placeholder = type === 'Accident' ? 'Describe the accident...' : 'Please specify...';
                }
            }
        </script>
        <!-- END SDO SMART INCIDENT FORM WIZARD -->

        <!-- 🚑 MEDICAL INCIDENTS HISTORY TABLE -->
        <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">My Medical Incident Reports</h3>
        <div class="bg-white rounded shadow p-6 overflow-x-auto mb-8 border-t-4 border-red-500">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Athlete</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Incident Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Ticket No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Date Submitted</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $incidentReports ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">
                                <?php echo e($incident->first_name); ?> <?php echo e($incident->last_name); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($incident->incident_details); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($incident->status === 'Pending'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending SDO Approval</span>
                                <?php elseif($incident->status === 'SDO_Approved'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">SDO Approved</span>
                                <?php elseif($incident->status === 'Ticket_Claimed'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ticket Claimed</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo e($incident->status); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-sm font-bold <?php echo e($incident->insurance_ticket_no ? 'text-green-600' : 'text-gray-400'); ?>">
                                <?php echo e($incident->insurance_ticket_no ?? 'Awaiting Code...'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($incident->created_at)->format('M d, Y g:i A')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="bi bi-shield-check text-3xl mb-2 block text-gray-300"></i>
                                No medical incidents reported yet. Safe season!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- END MEDICAL INCIDENTS TABLE -->

        <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">Standard File Uploads</h3>
        <div class="bg-white rounded shadow p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Received</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4"><?php echo e($report->title); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                <a href="<?php echo e(route('reports.download', $report->id)); ?>" class="hover:underline">
                                    <?php echo e($report->file_name); ?>

                                </a>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($report->created_at->format('M d, Y')); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php echo e($report->received_at ? $report->received_at->format('M d, Y') : '—'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo e(route('reports.download', $report->id)); ?>" class="text-blue-600 hover:text-blue-800" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No standard reports submitted yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="modal fade" id="uploadReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Upload Standard Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="<?php echo e(route('coach.reports.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Report Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select File <span class="text-red-500">*</span></label>
                        <input type="file" name="file" class="form-control <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <small class="form-text text-muted">Max file size: 10MB</small>
                        <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/reports/coach_reports.blade.php ENDPATH**/ ?>