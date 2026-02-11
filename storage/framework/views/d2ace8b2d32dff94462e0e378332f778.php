<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Registration - SDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .form-header { background: #2e4e1f; color: white; padding: 40px; border-radius: 10px 10px 0 0; text-align: center; }
        .form-container { max-width: 900px; margin: 40px auto; background: white; border-radius: 10px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .form-section { padding: 40px; }
        .section-title { color: #2e4e1f; border-bottom: 2px solid #c4d79b; padding-bottom: 10px; margin-bottom: 20px; margin-top: 30px; font-weight: bold; }
        
        /* HIDE SECTIONS BY DEFAULT */
        #basic-info-section, #shared-fields, #active-student-fields { display: none; }
    </style>
</head>
<body>

<div class="container mb-5">
    <div class="form-container">
        <div class="form-header">
            <h2 class="mb-2 fw-bold"><i class="bi bi-person-vcard-fill me-2"></i>Athlete Registration</h2>
            <p class="mb-0 opacity-75">Sports Development Office • Enrollment & Profiling</p>
        </div>

        <div class="form-section">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success d-flex align-items-center mb-4">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div><?php echo e(session('success')); ?></div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger d-flex align-items-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                    <div><?php echo e(session('error')); ?></div>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('alumni.register.submit')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-4 bg-light p-4 rounded border border-success">
                    <label class="form-label fw-bold h5">Step 1: Registration Type <span class="text-danger">*</span></label>
                    <select name="classification" id="classification" class="form-select form-select-lg border-success" required onchange="toggleFields()">
                        <option value="">-- Select Your Status --</option>
                        <option value="Active" <?php echo e(old('classification') == 'Active' ? 'selected' : ''); ?>>Active Student (New or Renewing)</option>
                        <option value="Alumni" <?php echo e(old('classification') == 'Alumni' ? 'selected' : ''); ?>>Alumni / Graduate</option>
                    </select>
                </div>

                <div id="basic-info-section">
                    <h5 class="section-title">Basic Identification</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Student ID <span class="text-danger">*</span></label>
                            <input type="text" name="student_id" class="form-control" value="<?php echo e(old('student_id')); ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo e(old('first_name')); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">M.I.</label>
                            <input type="text" name="middle_initial" class="form-control" maxlength="3" value="<?php echo e(old('middle_initial')); ?>">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo e(old('last_name')); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                         <label class="form-label fw-bold">ID Picture (2x2 or Passport) <span class="text-danger">*</span></label>
                         <input type="file" name="profile_picture" class="form-control" accept="image/*">
                         <div class="form-text">Accepted formats: JPG, PNG, JPEG</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sport Event <span class="text-danger">*</span></label>
                        <select name="sport_event" class="form-select" required>
                            <option value="">-- Select Sport --</option>
                            <optgroup label="Ball Games">
                                <option value="Basketball_Men">Basketball (Men)</option>
                                <option value="Basketball_Women">Basketball (Women)</option>
                                <option value="Volleyball_Men">Volleyball (Men)</option>
                                <option value="Volleyball_Women">Volleyball (Women)</option>
                                <option value="Football">Football</option>
                                <option value="Softball">Softball</option>
                                <option value="Baseball">Baseball</option>
                            </optgroup>
                            <optgroup label="Racket Sports">
                                <option value="Badminton_Men">Badminton (Men)</option>
                                <option value="Badminton_Women">Badminton (Women)</option>
                                <option value="Table_Tennis_Men">Table Tennis (Men)</option>
                                <option value="Table_Tennis_Women">Table Tennis (Women)</option>
                                <option value="Tennis_Men">Tennis (Men)</option>
                                <option value="Tennis_Women">Tennis (Women)</option>
                            </optgroup>
                            <optgroup label="Combat Sports & Others">
                                <option value="Taekwondo_Men">Taekwondo (Men)</option>
                                <option value="Taekwondo_Women">Taekwondo (Women)</option>
                                <option value="Arnis_Men">Arnis (Men)</option>
                                <option value="Arnis_Women">Arnis (Women)</option>
                                <option value="Boxing">Boxing</option>
                                <option value="Sepak_Takraw">Sepak Takraw</option>
                                <option value="Chess">Chess</option>
                                <option value="Swimming">Swimming</option>
                                <option value="Athletics">Athletics</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div id="active-student-fields">
                    <h5 class="section-title">Personal Details</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Birthdate <span class="text-danger">*</span></label>
                            <input type="date" name="birthdate" class="form-control" value="<?php echo e(old('birthdate')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" value="<?php echo e(old('age')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sex <span class="text-danger">*</span></label>
                            <select name="sex" class="form-select">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Civil Status</label>
                            <select name="civil_status" class="form-select">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Blood Type</label>
                            <select name="blood_type" class="form-select">
                                <option value="">Unknown</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="shared-fields">
                    <h5 class="section-title">Contact & Address Information</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_number" class="form-control" value="<?php echo e(old('contact_number')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Facebook/Social Link</label>
                            <input type="url" name="facebook_link" class="form-control" value="<?php echo e(old('facebook_link')); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Home Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">City / Municipality <span class="text-danger">*</span></label>
                            <input type="text" name="city_municipality" class="form-control" value="<?php echo e(old('city_municipality')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Province</label>
                            <input type="text" name="province_state" class="form-control" value="<?php echo e(old('province_state')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control" value="<?php echo e(old('zip_code')); ?>">
                        </div>
                    </div>

                    <h5 class="section-title">Academic Information</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Course / Program <span class="text-danger">*</span></label>
                            <input type="text" name="course" class="form-control" placeholder="e.g. BSIT" value="<?php echo e(old('course')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Year Level</label>
                            <select name="year_level" class="form-select">
                                <option value="">-- Select --</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                    </div>

                    <div id="emergency-section">
                        <h5 class="section-title">In Case of Emergency</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Contact Person Name <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_person" class="form-control" value="<?php echo e(old('emergency_person')); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Number <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_contact" class="form-control" value="<?php echo e(old('emergency_contact')); ?>">
                            </div>
                            </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-success btn-lg text-white shadow fw-bold py-3">SUBMIT REGISTRATION</button>
                    <a href="<?php echo e(url('/')); ?>" class="text-center text-secondary mt-2 text-decoration-none">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
    });

    function toggleFields() {
        var status = document.getElementById("classification").value;
        var basicInfo = document.getElementById("basic-info-section");
        var sharedFields = document.getElementById("shared-fields");
        var activeFields = document.getElementById("active-student-fields");
        var emergencySection = document.getElementById("emergency-section"); // Logic for Emergency

        if (status === "") {
            basicInfo.style.display = "none";
            sharedFields.style.display = "none";
            activeFields.style.display = "none";
        } else {
            basicInfo.style.display = "block";
            sharedFields.style.display = "block";
            
            if (status === "Active") {
                activeFields.style.display = "block";
                emergencySection.style.display = "block"; // Show Emergency
                setRequired('Active');
            } else {
                activeFields.style.display = "none";
                emergencySection.style.display = "none"; // Hide Emergency for Alumni
                setRequired('Alumni');
            }
        }
    }

    function setRequired(mode) {
        // ALWAYS required
        let alwaysRequired = ['student_id', 'email', 'first_name', 'last_name', 'sport_event'];
        
        // SHARED required
        let sharedRequired = ['contact_number', 'address', 'city_municipality', 'course'];
        
        // ACTIVE ONLY required
        let activeRequired = ['birthdate', 'sex', 'emergency_person', 'emergency_contact'];

        function setList(names, isRequired) {
            names.forEach(name => {
                let el = document.getElementsByName(name)[0];
                if(el) el.required = isRequired;
            });
        }

        if (mode === 'Active') {
            setList(sharedRequired, true);
            setList(activeRequired, true);
        } else {
            setList(sharedRequired, true);
            setList(activeRequired, false); // Turn off required for hidden fields
        }
    }
</script>

</body>
</html><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/alumni_registration.blade.php ENDPATH**/ ?>