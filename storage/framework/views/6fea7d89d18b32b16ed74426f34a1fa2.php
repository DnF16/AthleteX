<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Registration - SDO</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
</head>
<body class="bg-gradient-to-br from-green-900 to-green-800 min-h-screen flex items-center justify-center p-4">

    <!-- Modal-style Card -->
    <div class="w-full max-w-xl bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="bg-green-800 text-white p-6 text-center">
            <h1 class="text-2xl font-bold mb-1 flex items-center justify-center gap-2">
                <span>📇</span> Athlete Registration
            </h1>
            <p class="text-green-100 opacity-80 text-sm">Sports Development Office • Enrollment & Profiling</p>
        </div>

        <!-- Form Content -->
        <div class="p-6 space-y-6">

            <!-- Alerts -->
            <?php if(session('success')): ?>
                <div class="bg-green-100 text-green-900 p-3 rounded-md text-sm border border-green-300">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="bg-red-100 text-red-900 p-3 rounded-md text-sm border border-red-300">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="bg-red-100 text-red-900 p-3 rounded-md text-sm border border-red-300">
                    <ul class="list-disc list-inside mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session('tryout_success')): ?>
                <div class="bg-green-50 border-l-4 border-green-600 p-3 rounded-md text-green-800 text-sm">
                    <strong>🎫 Registration Confirmed!</strong>
                    <p class="mt-1"><?php echo session('tryout_success'); ?></p>
                </div>
            <?php endif; ?>

            <div id="tryout-alert" class="hidden bg-blue-50 border-l-4 border-blue-600 p-3 rounded-md text-blue-800 text-sm">
                <strong>Tryout Applicant:</strong> Please fill out your basic details. Your tryout schedule will be shown after submission.
            </div>

            <!-- Form -->
            <form action="<?php echo e(route('alumni.register.submit')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>

                <!-- Registration Type -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Registration Type <span class="text-red-600">*</span></label>
                    <select name="classification" id="classification" class="w-full rounded-md border border-gray-300 p-2 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600" required onchange="toggleFields()">
                        <option value="">-- Select Your Status --</option>
                        <option value="Tryout" <?php echo e(old('classification') == 'Tryout' ? 'selected' : ''); ?>>Tryout Applicant</option>
                        <option value="Alumni" <?php echo e(old('classification') == 'Alumni' ? 'selected' : ''); ?>>Alumni / Graduate</option>
                    </select>
                </div>

                <!-- Basic Info -->
                <div id="basic-info-section" class="hidden space-y-3">
                    <h2 class="text-gray-800 font-semibold border-b border-gray-300 pb-1">Basic Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="text-gray-700 text-sm">Student ID <span class="text-red-600" id="id_star">*</span></label>
                            <input type="text" name="student_id" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-gray-700 text-sm">Email <span class="text-red-600">*</span></label>
                            <input type="email" name="email" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-gray-700 text-sm">Contact Number <span class="text-red-600">*</span></label>
                            <input type="text" name="contact_number" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="text-gray-700 text-sm">First Name <span class="text-red-600">*</span></label>
                            <input type="text" name="first_name" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600" required>
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm">M.I.</label>
                            <input type="text" name="middle_initial" maxlength="3" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm">Last Name <span class="text-red-600">*</span></label>
                            <input type="text" name="last_name" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600" required>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm">Sport Event <span class="text-red-600">*</span></label>
                        <select name="sport_event" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600" required>
                            <option value="">-- Select Sport --</option>
                            <optgroup label="Ball Games">
                                <option value="Basketball_Men">Basketball (Men)</option>
                                <option value="Basketball_Women">Basketball (Women)</option>
                            </optgroup>
                            <optgroup label="Racket Sports">
                                <option value="Badminton_Men">Badminton (Men)</option>
                                <option value="Badminton_Women">Badminton (Women)</option>
                            </optgroup>
                            <optgroup label="Combat Sports & Others">
                                <option value="Taekwondo_Men">Taekwondo (Men)</option>
                                <option value="Taekwondo_Women">Taekwondo (Women)</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <!-- Shared Fields -->
                <div id="shared-fields" class="hidden space-y-3">
                    <h2 class="text-gray-800 font-semibold border-b border-gray-300 pb-1">Contact & Address</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-gray-700 text-sm">Mobile Number <span class="text-red-600">*</span></label>
                            <input type="text" name="contact_number" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm">Facebook/Social Link</label>
                            <input type="url" name="facebook_link" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700 text-sm">Home Address <span class="text-red-600">*</span></label>
                        <input type="text" name="address" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="text-gray-700 text-sm">City / Municipality <span class="text-red-600">*</span></label>
                            <input type="text" name="city_municipality" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm">Province</label>
                            <input type="text" name="province_state" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm">Zip Code</label>
                            <input type="text" name="zip_code" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        </div>
                    </div>

                    <h2 class="text-gray-800 font-semibold border-b border-gray-300 pb-1 mt-2">Academic Info</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-gray-700 text-sm">Course / Program <span class="text-red-600">*</span></label>
                            <input type="text" name="course" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600" placeholder="e.g. BSIT">
                        </div>
                        <div>
                            <label class="text-gray-700 text-sm">Alumni / Graduate</label>
                            <select name="status" class="w-full p-2 rounded-md border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                <option value="">-- Select --</option>
                                <option value="1">Alumni</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex flex-col md:flex-row gap-3 mt-4">
                    <button type="submit" class="w-full md:w-auto bg-green-700 hover:bg-green-800 text-white py-2.5 rounded-md font-semibold transition">Submit Registration</button>
                    <a href="<?php echo e(url('/')); ?>" class="w-full md:w-auto text-green-800 hover:text-green-600 text-center">Cancel</a>
                </div>

            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    toggleFields();
});

function toggleFields() {
    const status = document.getElementById("classification").value;
    const basicInfo = document.getElementById("basic-info-section");
    const sharedFields = document.getElementById("shared-fields");
    const tryoutAlert = document.getElementById("tryout-alert");
    const idStar = document.getElementById("id_star");

    basicInfo.classList.add('hidden');
    sharedFields.classList.add('hidden');
    tryoutAlert.classList.add('hidden');

    if(status === "Tryout") {
        basicInfo.classList.remove('hidden');
        tryoutAlert.classList.remove('hidden');
        idStar.style.display = 'none';
    } else if(status === "Alumni") {
        basicInfo.classList.remove('hidden');
        sharedFields.classList.remove('hidden');
        idStar.style.display = 'inline';
    }
}
</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\AthleteX\resources\views/features/alumni_registration.blade.php ENDPATH**/ ?>